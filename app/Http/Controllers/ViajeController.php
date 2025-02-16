<?php

namespace App\Http\Controllers;

use App\Models\CuentaPorCobrar;
use App\Models\Sector;
use App\Models\Servicio;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Viaje;
use App\Notifications\CuentaPorCobrarNotification;
use App\Notifications\ViajeActualizadoNotification;
use App\Notifications\ViajeAsignacionNotification;
use App\Notifications\ViajeCanceladoNotification;
use App\Notifications\ViajeSolicitadoNotification;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
class ViajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $user = Auth::user();
            if ($user->hasRole('superAdmin')) {
                // Si es superAdmin, obtiene todos los viajes
                $viajes = Viaje::with('user')->orderBy('id', 'DESC')->get();
            } elseif ($user->hasRole('cliente')) {
                // Si es Cliente, obtiene solo los viajes de su usuario
                $viajes = Viaje::with('user')->where('user_id', $user->id)->orderBy('id', 'DESC')->get();
            } else {  
                // Manejo para otros roles si es necesario (opcional)
                $viajes = Viaje::with('user')->where('conductor_id', $user->id)->orderBy('id', 'DESC')->get();
            } // Cargar relaciones con 'vehiculo' y 'user'

            return DataTables::of($viajes)
                // Columna para vehiculo_id, si no tiene se muestra un badge "Sin asignar"
                ->addColumn('vehiculo_id', function ($row) {
                    return $row->vehiculo ? $row->vehiculo->placa : '<span class="badge badge-dark">Sin asignar</span>';
                })
                // Columna para mostrar el estado con un badge
                ->addColumn('estado', function ($row) {
                    $estado = ucfirst($row->estado); // Convertir la primera letra a mayúscula
                    $badgeClass = '';

                    switch ($row->estado) {
                        case 'Iniciado':
                            $badgeClass = 'badge-warning';
                            break;
                        case 'Completado':
                            $badgeClass = 'badge-success';
                            break;
                        case 'Cancelado':
                            $badgeClass = 'badge-danger';
                            break;
                        default:
                            $badgeClass = 'badge-secondary'; // Estado desconocido
                            break;
                    }
                    return '<span class="badge ' . $badgeClass . '">' . $estado . '</span>';
                })
                // Columna para hora de salida, si no tiene se muestra "Sin iniciar" en un badge
                ->addColumn('hora_salida', function ($row) {
                    return $row->hora_salida ? $row->hora_salida->format('H:i') : '<span class="badge badge-dark">Sin iniciar</span>';
                })
                // Columna para hora de llegada, si no tiene se muestra "Sin finalizar" en un badge
                ->addColumn('hora_llegada', function ($row) {
                    return $row->hora_llegada ? $row->hora_llegada->format('H:i') : '<span class="badge badge-dark">Sin finalizar</span>';
                })
                ->addColumn('usuario', function ($row) {
                    return $row->user->name;
                })
                // Columna para mostrar la fecha de creación en formato 'd-m-Y'
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-m-Y');
                })
                // Columna para mostrar la fecha de actualización en formato 'd-m-Y'
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d-m-Y');
                })
                // Columna de acciones (editar y eliminar)
                ->addColumn('actions', function ($row) {
                    return view('viajes.actions', compact('row'))->render();
                })


                ->rawColumns(['vehiculo_id', 'estado', 'hora_salida', 'hora_llegada', 'created_at', 'updated_at', 'actions']) // Permitir HTML en estas columnas
                ->make(true);
        } else {
            return view('viajes.index'); // Vista para mostrar la datatable
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicios = Servicio::all();
        $larga = Servicio::where('descripcion', 'CARRERA LARGA')->first();
        $corta = Servicio::where('descripcion', 'CARRERA CORTA')->first();

        $largo = Servicio::all();
        $sectores = Sector::all();
        return view('viajes.create')->with('corta', $corta)->with('larga', $larga)->with('sectores', $sectores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos enviados
        $request->validate([

            'origen_lat' => 'required|numeric',
            'origen_lon' => 'required|numeric',
            'destino_lat' => 'required|numeric',
            'destino_lon' => 'required|numeric',
            'distancia' => 'required|numeric',
            'tiempo' => 'required|numeric',
        ]);


        //En caso crear usuario

        
      
        if($request->name && $request->email && $request->cedula && $request->nuevoUser) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->cedula), // Encriptar la contraseña
                'dni' => $request->cedula,
    
            ]);
    
            // Asignar el rol al usuario
            $user->assignRole('cliente');
            $userId = $user->id;
        }else{
            $userId = auth()->id();
        }

        $distanciaKm = $request->distancia;



        if ($distanciaKm > 3) {
            $servicio = Servicio::where('descripcion', 'CARRERA LARGA')->first();
        } else {
            $servicio = Servicio::where('descripcion', 'CARRERA CORTA')->first();
        }


        $precioPorKm = $servicio->costo;
        $precio = $precioPorKm;
        // Crear una nueva instancia del modelo Viaje y guardar los datos
        $viaje = new Viaje();
        $viaje->user_id = $userId;
        $viaje->origen = json_encode(['lat' => $request->origen_lat, 'lon' => $request->origen_lon]);
        $viaje->destino = json_encode(['lat' => $request->destino_lat, 'lon' => $request->destino_lon]);
        $viaje->distancia_km = $distanciaKm;
        $viaje->precio = $precio;
        $viaje->estado = 'Pendiente';
        $viaje->direccion = $request->direccion_destino;
        $viaje->sector_id = $request->sector;

        $viaje->save();

        // Crear una cuenta por cobrar en estado 'Pendiente'
        $cuenta = new CuentaPorCobrar();
        $cuenta->descripcion = 'Cobro por servicio de viaje';
        $cuenta->monto = $precio;
        $cuenta->status = 'Pendiente';
        $cuenta->viaje_id = $viaje->id;
        $cuenta->user_id = $userId;
        $cuenta->procesado_por = null;
        $cuenta->save();

        // Notificar al usuario solicitante sobre la cuenta pendiente
        $viaje->user->notify(new CuentaPorCobrarNotification($cuenta));

        // Enviar notificación a usuarios con rol 'superAdmin'
        $superAdmins = User::whereHas('roles', function ($query) {
            $query->where('name', 'superAdmin');
        })->get();

        foreach ($superAdmins as $admin) {
            $admin->notify(new ViajeSolicitadoNotification($viaje));
        }

        // Redireccionar con mensaje de éxito
        Alert::success('¡Éxito!', 'Viaje solicitado correctamente, debe realizar el pago y se le asignara un conductor')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('pagar', ['id' => $cuenta->id]);

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
        // Buscar el viaje por su ID
        $viaje = Viaje::with('vehiculo', 'user')->findOrFail($id);
        $users = User::role('conductor')->where('status', 'Activo')->get();
        // Retornar la vista de edición y pasar los datos del viaje
        $origen = json_decode($viaje->origen, true);
        $destino = json_decode($viaje->destino, true);

        //     dd($users);
        return view('viajes.edit', compact('viaje', 'origen', 'destino', 'users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $viaje = Viaje::find($id);
        $vehiculo = Vehicle::where('user_id', $request->user_id)->first();

        $nuevo = true;

        if (!$viaje->vehiculo_id) {
            $nuevo = false;
        }

        if ($request->user_id) {
            if (!$vehiculo) {
                Alert::error('¡Error!', 'Este usuario no tiene vehículo registrado')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                return redirect()->route('viajes.index');
            }

            $viaje->vehiculo_id = $vehiculo->id;
            $viaje->conductor_id = $vehiculo->user_id;
        }

        
        $viaje->estado = $request->estado;

        if ($request->estado == 'Iniciado') {
            $viaje->hora_salida = now();
        } elseif ($request->estado == 'Finalizado') {
            $viaje->hora_llegada = now();
        }

        $viaje->save();

        // Notificar al usuario o a un rol específico como 'superAdmin'
        $viaje->user->notify(new ViajeActualizadoNotification($viaje));

      
        if ( isset($viaje->conductor_id)) {
            $chofer = User::find($viaje->conductor_id);
          
            if ($chofer) {
                $chofer->notify(new ViajeAsignacionNotification($viaje));

            }
        }

        Alert::success('¡Éxito!', 'Viaje actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('viajes.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       try {
        $vehiculo = Viaje::findOrFail($id);
        Alert::success('¡Éxito!', 'Registro eliminado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        $vehiculo->delete();
       } catch (\Throwable $th) {
        Alert::error('¡No se puede eliminar!', 'Este registro se relaciona con viajes, no se puede eliminar sin antes eliminar dichos viajes')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

       }

        return redirect()->route('viajes.index')->with('success', 'Vehículo eliminado con éxito.');
    }

    public function cancelar($id)
    {
        // Buscar el viaje por ID
        $viaje = Viaje::findOrFail($id);

        // Verificar si el viaje ya no está finalizado
        if ($viaje->estado === 'Finalizado') {
            Alert::error('¡Error!', 'No se puede cancelar un viaje que ya finalizó')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back()->with('error', 'No se puede cancelar un viaje que ya ha finalizado.');
        } else if ($viaje->estado === 'Cancelado') {
            Alert::error('¡Error!', 'No se puede cancelar un viaje que ya fue cancelado con anterioridad')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back()->with('error', 'No se puede cancelar un viaje que ya ha finalizado.');
        }

        // Cambiar el estado a "Cancelado"
        $viaje->estado = 'Cancelado';
        $viaje->save();

        // Enviar notificación al usuario del viaje
        $viaje->user->notify(new ViajeCanceladoNotification($viaje));


        $superAdmins = User::whereHas('roles', function ($query) {
            $query->where('name', 'superAdmin');
        })->get();
        foreach ($superAdmins as $admin) {
            $admin->notify(new ViajeCanceladoNotification($viaje));
        }

        // Redirigir con un mensaje de éxito
        Alert::success('¡Éxito!', 'Viaje cancelado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->back()->with('success', 'El viaje ha sido cancelado exitosamente.');
    }
}
