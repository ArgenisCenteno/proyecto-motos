<?php

namespace App\Http\Controllers;

use App\Models\CuentaPorCobrar;
use App\Models\Pago;
use App\Models\Recibo;
use App\Models\User;
use App\Notifications\PagoActualizadoNotification;
use App\Notifications\PagoRealizadoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Alert;
class CuentaPorCobrarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        $user = Auth::user();

        if ($user->hasRole('superAdmin')) {
            // Si es superAdmin, obtiene todas las cuentas por cobrar
            $cuentasPorCobrar = CuentaPorCobrar::with('user')->orderBy('id', 'DESC')->get();
        } elseif ($user->hasRole('cliente')) {  
            // Si es Cliente, obtiene solo las cuentas por cobrar de su usuario
            $cuentasPorCobrar = CuentaPorCobrar::with('user')->where('user_id', $user->id)->orderBy('id', 'DESC')->get();
        } else {  
           
            // Manejo para otros roles si es necesario (opcional)
            $cuentasPorCobrar = CuentaPorCobrar::whereHas('viaje', function ($query) {
                $query->where('conductor_id',  Auth::user()->id); // Filtra por el conductor autenticado
            })->get();
        }

        return DataTables::of($cuentasPorCobrar)
            // Columna para mostrar el ID de la cuenta por cobrar
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            // Columna para mostrar la descripción de la cuenta
            ->addColumn('descripcion', function ($row) {
                return $row->descripcion;
            })
            // Columna para mostrar el monto
            ->addColumn('monto', function ($row) {
                return number_format($row->monto, 2, ',', '.'); // Formato para el monto
            })
            // Columna para mostrar el estado con un badge
            ->addColumn('status', function ($row) {
                $estado = ucfirst($row->status);
                $badgeClass = '';

                switch ($row->status) {
                    case 'Pendiente':
                        $badgeClass = 'badge-warning';
                        break;
                    case 'Pagada':
                        $badgeClass = 'badge-success';
                        break;
                    case 'Rechazado':
                        $badgeClass = 'badge-danger';
                        break;
                    default:
                        $badgeClass = 'badge-secondary'; // Estado desconocido
                        break;
                }
                return '<span class="badge ' . $badgeClass . '">' . $estado . '</span>';
            })
            // Columna para mostrar el ID del viaje relacionado, si no tiene se muestra "Sin asignar"
            ->addColumn('fecha', function ($row) {
                return $row->created_at->format('m-d-Y');
            })
            // Columna para mostrar el usuario que creó la cuenta por cobrar
            ->addColumn('user', function ($row) {
                //dd($row);
                return $row->user ? $row->user->name : '<span class="badge badge-dark">Sin usuario</span>';
            })
            // Columna de acciones (editar y eliminar)
            ->addColumn('actions', function ($row) {
                $editUrl = route('cuentasPorCobrar.edit', $row->id);
                $pagarUrl = route('pagar', $row->id);
                $deleteUrl = route('cuentasPorCobrar.destroy', $row->id);
            
                return view('cuenta_por_cobrar.actions', [
                    'editUrl' => $editUrl,
                    'pagarUrl' => $pagarUrl,
                    'deleteUrl' => $deleteUrl,
                    'status' => $row->status
                ])->render();
            })
            
            
            ->rawColumns(['status', 'viaje_id', 'user', 'actions']) // Permitir HTML en estas columnas
            ->make(true);
    } else {
        return view('cuenta_por_cobrar.index'); // Vista para mostrar la datatable
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
        // Validar los datos del formulario
        // dd($request);
    
        // Obtener la cuenta por cobrar
        $cuenta = CuentaPorCobrar::findOrFail($request->id);
    
        // Verificar que la cuenta no esté ya pagada o cancelada
        if ($cuenta->status === 'Pagada' || $cuenta->status === 'Cancelada' || $cuenta->status === 'En proceso') {
            Alert::error('¡Error!', 'Esta cuenta no puede ser pagada')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->back()->withErrors(['La cuenta ya está pagada o cancelada.']);
        }
    
        // Determinar el método de pago
        $metodo = $request->banco_origen_transfer ? "Transferencia Bancaria" : "Pago Móvil";
    
        // Registrar el pago
        $pago = new Pago();
        $pago->viaje_id = $cuenta->viaje_id;
        $pago->monto = $request->monto_pago;
        $pago->metodo_pago = $metodo;
        $pago->banco_origen = $request->banco_origen_transfer ?? $request->banco_origen_movil;
        $pago->banco_destino = $request->banco_destino_transfer ?? $request->banco_destino_movil;
        $pago->referencia = $request->referencia_transfer ?? $request->referencia_movil;
        $pago->save();
    
        // Actualizar el estado de la cuenta a "En proceso"
        $cuenta->status = 'En proceso';
        $cuenta->pago_id = $pago->id;
        $cuenta->save();
    
        // Enviar notificación a superAdmins
        $superAdmins = User::whereHas('roles', function ($query) {
            $query->where('name', 'superAdmin');
        })->get();
    
        foreach ($superAdmins as $admin) {
            $admin->notify(new PagoRealizadoNotification($pago, $cuenta));
        }
    
        // Notificación de éxito al usuario
        Alert::success('¡Éxito!', 'Pago realizado exitosamente, espere su validación')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
    
        return redirect()->route('cuentasPorCobrar.index')->with('success', 'Pago registrado exitosamente.');
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
        // Obtener la cuenta por cobrar con el ID proporcionado, incluyendo los datos del pago
        $orden = CuentaPorCobrar::with(['user', 'pago'])->findOrFail($id);
    
        // Retornar la vista con los datos de la cuenta y el pago
        return view('cuenta_por_cobrar.edit', compact('orden'));
    }
    
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validar los datos del formulario
    $request->validate([
        'estado' => 'required|string|in:Pendiente,En Proceso,Pagada,Rechazado',
    ]);

    // Obtener la orden
    $orden = CuentaPorCobrar::findOrFail($id);

    // Verificar las transiciones de estado permitidas
    switch ($orden->status) {
        case 'Pagada':
            if ($request->estado !== 'Rechazado') {
                Alert::error('Error', 'Una cuenta pagada solo puede pasar a cancelada.')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                return redirect()->back();
            }
            break;

        case 'Pendiente':
            if (!in_array($request->estado, ['Pagada', 'Rechazada'])) {
                Alert::error('Error', 'Una cuenta pendiente solo puede pasar a pagada o rechazada.')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                return redirect()->back();
            }
            break;

        case 'Rechazado':
            if (in_array($request->estado, ['Pendiente', 'Pagada'])) {
                Alert::error('Error', 'Una cuenta rechazada no puede pasar a pendiente ni a pagada.')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
                return redirect()->back();
            }
            break;

        // Puedes añadir más casos aquí si es necesario
    }

    // Actualizar el estado de la orden
    $orden->status = $request->estado;
    

    if ($request->estado == 'Pagada') {
        $orden->procesado_por = Auth::id(); // Asigna el ID del usuario autenticado
    }
    $orden->save();

    $orden->user->notify(new PagoActualizadoNotification($orden));

    // Redirigir con un mensaje de éxito
    Alert::success('¡Éxito!', 'Cuenta actualizada correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

    return redirect()->route('cuentasPorCobrar.index');
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cuenta = CuentaPorCobrar::find($id);
            $cuenta->delete();
            Alert::success('¡Éxito!', 'Registro eliminado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

            return redirect()->route('cuentasPorCobrar.index');
        } catch (\Throwable $th) {
            Alert::error('¡No se puede eliminar!', 'No se pudo eliminar el registro')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

            return redirect()->route('cuentasPorCobrar.index');
        }
    }

    public function iniciarPago(string $id){
        
        $cuenta = CuentaPorCobrar::find($id);
        if ($cuenta->status === 'Pagada' || $cuenta->status === 'Rechazado') {
            return redirect()->back()->withErrors(['La cuenta ya está pagada o cancelada.']);
        }
     //   dd($cuenta);
        return view('cuenta_por_cobrar.pagar')->with('cuenta', $cuenta);
    }
}
