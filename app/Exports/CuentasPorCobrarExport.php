<?php

namespace App\Exports;

use App\Models\CuentaPorCobrar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CuentasPorCobrarExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $fecha_inicio;
    protected $fecha_fin;

    // Constructor para recibir las fechas
    public function __construct($fecha_inicio, $fecha_fin)
    {
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    // Método que devuelve la colección de cuentas por cobrar en el rango de fechas
    public function collection()
    {
        return CuentaPorCobrar::with(['user', 'procesadoPor', 'viaje']) // Cargar las relaciones
            ->whereBetween('created_at', [$this->fecha_inicio, $this->fecha_fin]) // Filtrar por created_at
            ->orderBy('created_at', 'asc') // Ordenar por la fecha de creación
            ->get()
            ->map(function($cuenta) {
                return [
                    'ID' => $cuenta->id,
                    'Descripción' => $cuenta->descripcion,
                    'Monto' => $cuenta->monto,
                    'Estado' => $cuenta->status,
                    'Viaje' => $cuenta->viaje->id ?? 'N/A', // ID del viaje asociado, si lo tiene
                    'Generado Por' => $cuenta->user->name ?? 'N/A', // Nombre del usuario que generó la cuenta
                    'Procesado Por' => $cuenta->procesadoPor->name ?? 'N/A', // Nombre del usuario que procesó la cuenta
                    'Fecha Creación' => $cuenta->created_at->format('d-m-Y'),
                ];
            });
    }

    // Encabezados del Excel
    public function headings(): array
    {
        return [
            'ID',
            'Descripción',
            'Monto',
            'Estado',
            'ID del Viaje',
            'Generado Por',
            'Procesado Por',
            'Fecha Creación',
        ];
    }
}
