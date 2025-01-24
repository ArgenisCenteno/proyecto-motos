<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Compra;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\RegistroConductor;
use App\Models\Servicio;
use App\Models\SubCategoria;
use App\Models\Tramite;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Venta;
use App\Models\Viaje;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
     
        $totalTramites = Tramite::count();
        $totalPasajeros = User::whereHas('roles', function ($query) {
            $query->where('name', 'cliente');
        })->count();
    
        // Contar usuarios con rol 'conductor'
        $totalConductores = User::whereHas('roles', function ($query) {
            $query->where('name', 'conductor');
        })->count();
    
        $totalVehiculos = Vehicle::count();
        $totalConductoresRegistrados = RegistroConductor::where('estado', 'Aprobado')->count();
        $totalServicios = Servicio::count();
        $totalPagos = Pago::sum('monto');
        $totalViajes = Viaje::count();
        $viajes = Viaje::selectRaw('MONTH(created_at) as month, SUM(precio
        ) as total_sales')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Prepare data for chart
        $meses = [];
        $viajesData = [];

        // Map the data into arrays
        foreach ($viajes as $venta) {
            // Carbon to get the full month name (January, February, etc.)
            $meses[] = Carbon::createFromFormat('m', $venta->month)->format('F');
            $viajesData[] = $venta->total_sales;
        }
        return view('home', compact('meses','viajesData','totalTramites', 'totalPasajeros', 'totalConductores', 'totalVehiculos', 'totalConductoresRegistrados', 'totalServicios', 'totalPagos', 'totalViajes'));

    }
    
  
}
