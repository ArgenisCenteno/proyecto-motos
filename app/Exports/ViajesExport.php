<?php
namespace App\Exports;

use App\Models\Viaje;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ViajesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $fecha_inicio;
    protected $fecha_fin;

    // Constructor para recibir las fechas
    public function __construct($fecha_inicio, $fecha_fin)
    {
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    // Método que devuelve la colección de viajes en el rango de fechas
    public function collection()
    {
        // Cargar los viajes junto con la información del conductor y del vehículo
        return Viaje::with('vehiculo.user') // Relación con vehículo y usuario
            ->whereBetween('created_at', [$this->fecha_inicio, $this->fecha_fin]) // Filtrar por el campo created_at
            ->orderBy('created_at', 'asc') // Ordenar por created_at
            ->get()
            ->map(function($viaje) {
                return [
                    'ID' => $viaje->id,
                    'Conductor' => $viaje->vehiculo->user->name ?? 'N/A', // Obtener el nombre del conductor
                    'Cliente' => $viaje->user->name ?? 'N/A', // Nombre del cliente si está relacionado
                    'Fecha del Viaje' => $viaje->created_at->format('d-m-Y'), // Formato de la fecha (created_at)
                    'Distancia' => $viaje->distancia_km, // Distancia del viaje
                    'Precio' => $viaje->precio, // Precio del viaje
                    'Estado' => $viaje->estado, // Estado del viaje
                    'Dirección' => $viaje->direccion, // Estado del viaje
                ];
            });
    }
    

    // Encabezados del Excel
    public function headings(): array
    {
        return [
            'ID',
            'Conductor',
            'Cliente',
            'Fecha del Viaje',
            'Distancia',
            'Precio',
            'Estado',
            'Dirección'
        ];
    }
}
