<?php
namespace App\Exports;

use App\Models\Tramite;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Carbon;

class TramitesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    // Recibe las fechas de inicio y fin para el filtrado
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Obtener los trámites para exportar.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Filtra los trámites por el rango de fechas
        return Tramite::whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(), 
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->get()
            ->map(function ($tramite) {
                // Mapear los datos del trámite a un formato adecuado para la exportación
                return [
                    'id' => $tramite->id,
                    'tipo' => $tramite->tipo,
                    'descripcion' => $tramite->descripcion,
                    'estado' => $tramite->estado,
                    'aprobado_por' => optional($tramite->aprobadoPor)->name, // Usar optional para evitar errores si es nulo
                    'revisado_por' => optional($tramite->revisadoPor)->name, // Usar optional para evitar errores si es nulo
                    'fecha_creacion' => $tramite->created_at->format('Y-m-d H:i:s'),
                    'fecha_actualizacion' => $tramite->updated_at->format('Y-m-d H:i:s'),
                ];
            });
    }

    /**
     * Definir los encabezados para la hoja de Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID', 
            'Tipo', 
            'Descripción', 
            'Estado', 
            'Aprobado Por', 
            'Revisado Por', 
            'Fecha de Creación', 
            'Fecha de Actualización'
        ];
    }
}
