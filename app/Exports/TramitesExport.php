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
        return Tramite::whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(), 
                Carbon::parse($this->endDate)->endOfDay()
            ])
            ->get();  // Filtra por el rango de fechas
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
