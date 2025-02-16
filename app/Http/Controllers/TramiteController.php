<?php

namespace App\Http\Controllers;

use App\Exports\TramitesExport;
use App\Models\RegistroConductor;
use App\Models\Tramite;
use App\Models\User;
use App\Models\Vehicle;
use App\Notifications\TramiteActualizadoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Alert;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
class TramiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->hasRole('superAdmin')){
                $users = Tramite::with('user', 'aprobadoPor', 'revisadoPor')->get(); // Use `with` to eager load roles
    
            }elseif(Auth::user()->hasRole('conductor')){
                $users = Tramite::with('user', 'aprobadoPor', 'revisadoPor')->where('user_id',Auth::user()->id )->get(); // Use `with` to eager load roles
    
            }

            return DataTables::of($users)

                ->addColumn('fecha', function ($row) {
                    return $row->created_at->format('m-d-Y'); // Use getRoleNames() to get assigned roles
    
                })
                ->addColumn('actions', function ($row) {
                    // Pass the row's id to the actions Blade view
                    return view('tramites.actions', ['id' => $row->id])->render();
                })
                
                ->rawColumns(['role', 'actions'])
                ->make(true);
        } else {
            return view('tramites.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tramite = Tramite::find($id);
        $registro = RegistroConductor::where('user_id', $tramite->user_id)->first();
        $conductor = $tramite->user;
        $vehiculo = Vehicle::where('user_id', $tramite->user_id)->where('created_at', $tramite->created_at)->first();
        $registro = RegistroConductor::where('user_id', $tramite->user->id)->first();

        return view('tramites.edit', compact('tramite', 'registro', 'conductor', 'registro', 'vehiculo'));
    }

    /**
     * Update the specified resource in storage.
     */
   
    public function update(Request $request, string $id)
    {
        $tramite = Tramite::find($id);
        $registro = RegistroConductor::where('user_id', $tramite->user_id)->first();
        $user = User::find($tramite->user_id);
       // dd($request->estado);
    
        $notificar = false; // Variable para controlar el envío de la notificación
    
        if ($request->estado == 'Aprobado' && $tramite->estado == 'Pendiente') {
            $vehiculo = Vehicle::where('user_id', $user->id)->latest()->first();
            $registro->estado = 'Aprobado';
            $registro->save();
            $vehiculo->status = 'Activo';
            $vehiculo->save();
            $user->status = 'Activo';
            $user->save();


    
            $tramite->estado = 'Aprobado';
            $tramite->aprobado_por = Auth::id();
            $tramite->save();
    
            $notificar = true; // Activar notificación
        } elseif ($request->estado == 'Pendiente' && $tramite->estado == 'En proceso') {
            $registro->estado = 'En proceso';
            $registro->save();
    
            $tramite->estado = 'En proceso';
            $tramite->revisado_por = Auth::id();
            $tramite->save();
    
            $notificar = true;
        } elseif ($request->estado == 'Pendiente' && $tramite->estado == 'Rechazado') {
            $registro->estado = 'Rechazado';
            $registro->save();
    
            $user->status = 'No laborable';
            $user->save();
    
            $tramite->estado = 'Rechazado';
            $tramite->observacion = $request->observacion;
            $tramite->save();
    
            $notificar = true;
        } else if ($request->estado === 'Rechazado' && $tramite->estado === 'Aprobado') {
            Alert::error('Error!', 'Es incongruente aprobar un tramite que fue rechazado anteriormente, acción denegada')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('tramites.index'));
        } else if ($request->estado === 'Aprobado' && $tramite->estado === 'Rechazado') {
            Alert::error('Error!', 'Es incongruente rechazar un tramite que fue aprobado anteriormente, acción denegada')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('tramites.index'));
        }
    
        // Enviar notificación si el estado ha cambiado
        if ($notificar) {
            $user->notify(new TramiteActualizadoNotification($tramite));
        }
    
        Alert::success('¡Éxito!', 'Registro actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('tramites.index'));
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(Request $request)
    {
        // Obtener las fechas desde los parámetros de la solicitud
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validar que las fechas sean proporcionadas
        if (!$startDate || !$endDate) {
            return redirect()->back()->withErrors('Debe proporcionar un rango de fechas.');
        }

        // Generar y devolver el archivo de exportación
        return Excel::download(new TramitesExport($startDate, $endDate), 'tramites.xlsx');
    }
}
