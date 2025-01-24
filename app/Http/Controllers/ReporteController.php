<?php

namespace App\Http\Controllers;

use App\Exports\CuentasPorCobrarExport;
use App\Exports\PagosExport;
use App\Exports\ViajesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; 

class ReporteController extends Controller
{
    public function index(){
        return view('reporte.index');
    }

    public function exportarExcel(Request $request)
    {
        // Validar las fechas de entrada
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

      //  dd("test");
  
        // Exportar los viajes a Excel
        return Excel::download(new ViajesExport($request->fecha_inicio, $request->fecha_fin), 'viajes.xlsx');
    }

    public function exportarCuentasPorCobrarExcel(Request $request)
    {
        // Validar las fechas de entrada
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Exportar las cuentas por cobrar a Excel
        return Excel::download(new CuentasPorCobrarExport($request->fecha_inicio, $request->fecha_fin), 'cuentas_por_cobrar.xlsx');
    }

    public function exportarPagosExcel(Request $request)
    {
        // Validar las fechas de entrada
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // Exportar los pagos a Excel
        return Excel::download(new PagosExport($request->fecha_inicio, $request->fecha_fin), 'pagos.xlsx');
    }
}
