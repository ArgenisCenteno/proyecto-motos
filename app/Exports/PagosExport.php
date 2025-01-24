<?php

namespace App\Exports;

use App\Models\Pago;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PagosExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $fecha_inicio;
    protected $fecha_fin;

    // Constructor para recibir las fechas
    public function __construct($fecha_inicio, $fecha_fin)
    {
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    // Método que devuelve la colección de pagos en el rango de fechas
    public function collection()
    {
        return Pago::with(['user', 'recibos', 'viaje']) // Cargar las relaciones con usuarios y recibos
            ->whereBetween('created_at', [$this->fecha_inicio, $this->fecha_fin]) // Filtrar por la fecha de creación
            ->orderBy('created_at', 'asc') // Ordenar por fecha de creación
            ->get()
            ->map(function($pago) {
                return [
                    'ID' => $pago->id,
                    'Banco Origen' => $pago->banco_origen,
                    'Banco Destino' => $pago->banco_destino,
                    'Número de Referencia' => $pago->referencia,
                    'Monto Total' => $pago->monto,
                    'Metodo de Pago' => $pago->metodo_pago,
                    'Cliente' => $pago->viaje->user->name ?? 'N/A', // Nombre del usuario que creó el pago
                    'Fecha de Creación' => $pago->created_at->format('d-m-Y'),
                ];
            });
    }

    // Encabezados del Excel
    public function headings(): array
    {
        return [
            'ID',
            'Banco Origen',
            'Banco Destino',
            'Número de Referencia',
            'Monto Total',
            'Metodo de Pago',
            'Cliente',
            'Fecha de Creación',
        ];
    }
}
