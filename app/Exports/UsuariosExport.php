<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsuariosExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    // Constructor para recibir las fechas
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // Consulta de los usuarios filtrados por fechas
    public function query()
    {
        return User::query()
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);
    }

    // Encabezados de las columnas en el Excel
    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Correo Electrónico',
            'DNI',
            'Sector',
            'Calle',
            'Género',
            'Referencia',
            'Casa',
            'Estado', 
            'Rol',
            'Fecha de Creación'
        ];
    }

    // Mapeo de los datos a las columnas
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->dni,
            $user->sector,
            $user->calle,
            $user->genero,
            $user->referencia,
            $user->casa,
            $user->status, 
            $user->roles->pluck('name')->implode(', '),  // Obtenemos el nombre del rol del usuario
            $user->created_at->toDateString(),  // Fecha de creación en formato YYYY-MM-DD
        ];
    }
}
