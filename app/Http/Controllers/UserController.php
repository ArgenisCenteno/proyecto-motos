<?php

namespace App\Http\Controllers;

use App\Models\DatosBancario;
use App\Models\RegistroConductor;
use App\Models\Sector;
use App\Models\Servicio;
use App\Models\Tramite;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Alert;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->get(); // Use `with` to eager load roles

            return DataTables::of($users)
                ->addColumn('role', function ($row) {
                    $roles = $row->getRoleNames(); // Use getRoleNames() to get assigned roles
                    return '<span class="badge ' . $this->getRoleBadgeClass($roles->first()) . '">' . ucfirst($roles->first()) . '</span>';
                })

                ->addColumn('fecha', function ($row) {
                    return $row->created_at->format('m-d-Y'); // Use getRoleNames() to get assigned roles
    
                })
                ->addColumn('actions', function ($row) {
                    // Pass the row's id to the actions Blade view
                    return view('usuarios.actions', ['id' => $row->id])->render();
                })

                ->rawColumns(['role', 'actions'])
                ->make(true);
        } else {
            return view('usuarios.index');
        }
    }


    private function getRoleBadgeClass($roleName)
    {
        switch ($roleName) {
            case 'superAdmin':
                return 'bg-danger'; // Red badge
            case 'empleado':
                return 'bg-primary'; // Blue badge
            case 'cliente':
                return 'bg-success'; // Green badge
            default:
                return 'bg-secondary'; // Default badge
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los roles disponibles
        $roles = Role::all();
        $sectores = Sector::all();
        $servicios = Servicio::all();
        // Retornar la vista con los roles
        return view('usuarios.create', compact('roles', 'servicios'))->with('sectores', $sectores);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'dni' => 'required|string|max:20',
            'sector' => 'nullable|string|max:100',
            'calle' => 'nullable|string|max:100',
            'casa' => 'nullable|string|max:100',
            'foto_perfil' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Validar la foto de perfil
            'role' => 'required|string|exists:roles,name',

            'genero' => 'required|string|in:Masculino,Femenino,Otro',
            'referencia' => 'nullable|string|max:255',
        ]);

        // Manejar la subida de la foto de perfil


        if ($request->hasFile('foto_perfil')) {
            $documentItv = $request->file('foto_perfil');
            $documentItvFile = time() . $documentItv->getClientOriginalName();
            $documentItv->move(public_path('/files/users'), $documentItvFile);
            $documentItvPath = $documentItvFile;
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encriptar la contraseña
            'dni' => $request->dni,
            'sector' => $request->sector,
            'calle' => $request->calle,
            'casa' => $request->casa,
            'status' => 'Activo',
            'foto_perfil' => $documentItvPath, // Guardar la ruta de la foto de perfil
            'genero' => $request->genero,
            'referencia' => $request->referencia,

        ]);

        // Asignar el rol al usuario
        $user->assignRole($request->role);



        if ($request->role === 'conductor') {

            $tramite = new Tramite();
            $tramite->tipo = 'Registro de Conductor';
            $tramite->descripcion = 'Registro de Conductor para servicio de rider';
            $tramite->user_id = $user->id;
            $tramite->estado = 'Pendiente';
            $tramite->save();

            if ($request->hasFile('documento_conducir')) {
                $documentItv = $request->file('documento_conducir');
                $documentItvFile = time() . $documentItv->getClientOriginalName();
                $documentItv->move(public_path('/files/users'), $documentItvFile);
                $documento_conducir = $documentItvFile;
            }

            if ($request->hasFile('documento_contrato')) {
                $documentItv = $request->file('documento_contrato');
                $documentItvFile = time() . $documentItv->getClientOriginalName();
                $documentItv->move(public_path('/files/users'), $documentItvFile);
                $documento_contrato = $documentItvFile;
            }

            if ($request->hasFile('documento_propiedad')) {
                $documentItv = $request->file('documento_propiedad');
                $documentItvFile = time() . $documentItv->getClientOriginalName();
                $documentItv->move(public_path('/files/users'), $documentItvFile);
                $documento_propiedad = $documentItvFile;
            }

            $registro = new RegistroConductor();
            $registro->user_id = $user->id;
            $registro->estado = 'Pendiente';
            $registro->documento_propiedad = $documento_propiedad;
            $registro->documento_contrato = $documento_contrato;
            $registro->documento_conducir = $documento_conducir;
            $registro->save();

            //Registra vehículo
            // Create a new vehicle
            $vehiculo = new Vehicle();
            $vehiculo->user_id = $user->id; // Set the user_id to the authenticated user
            $vehiculo->tipo = $request->tipo;
            $vehiculo->marca = $request->marca;
            $vehiculo->modelo = $request->modelo;
            $vehiculo->color = $request->color;
            $vehiculo->placa = $request->placa;
            $vehiculo->anio = $request->anio;
            $vehiculo->propietario = $request->propietario;
            $vehiculo->servicio_id = $request->servicio_id;
            $vehiculo->save();

            // Registrar datos bancarios (si se proporcionan)
            if ($request->has('banco') && $request->has('dni') && $request->has('tipo_cuenta') && $request->has('numero_cuenta') && $request->has('estatus')) {
                $datosBancarios = new DatosBancario();
                $datosBancarios->user_id = $user->id;
                $datosBancarios->banco = $request->banco;
                $datosBancarios->dni = $request->dni2;
                $datosBancarios->tipo_cuenta = $request->tipo_cuenta;
                $datosBancarios->numero_cuenta = $request->numero_cuenta;
                $datosBancarios->estatus = $request->estatus;
                $datosBancarios->save();
            }

            // Registrar número de emergencia (si se proporciona)
            if ($request->has('telefono_emergencia')) {
                $user->telefono_emergencia = $request->telefono_emergencia;
                $user->save();
            }
            $user->status = 'Inactivo';
            $user->save();
        }

        // Redirigir a la lista de usuarios
        Alert::success('¡Éxito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('usuarios.index');
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
    public function edit($id)
    {
        // Encontrar el usuario por ID
        $usuario = User::findOrFail($id);

        // Obtener todos los roles disponibles
        $roles = Role::all();
        $sectores = Sector::all();


        // Retornar la vista con los datos del usuario y los roles
        return view('usuarios.edit', compact('usuario', 'roles', 'sectores'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'dni' => 'required|string|max:20',
            'sector' => 'nullable|string|max:100',
            'calle' => 'nullable|string|max:100',
            'casa' => 'nullable|string|max:100',
            'role' => 'required|string|exists:roles,name',
            'status' => 'required|string|in:Activo,Inactivo',
        ]);

        // Encontrar el usuario por ID
        $user = User::findOrFail($id);

        // Actualizar los campos del usuario
        $user->name = $request->name;
        $user->email = $request->email;

        // Si se proporciona una nueva contraseña, actualizarla
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->dni = $request->dni;
        $user->sector = $request->sector;
        $user->calle = $request->calle;
        $user->casa = $request->casa;
        $user->status = $request->status;

        // Manejar la foto de perfil
        if ($request->hasFile('foto_perfil')) {
            $documentItv = $request->file('foto_perfil');
            $documentItvFile = time() . $documentItv->getClientOriginalName();
            $documentItv->move(public_path('/files/users'), $documentItvFile);
            $user->foto_perfil = $documentItvFile; // Actualizar el path de la foto de perfil
        }

        // Guardar los cambios
        $user->save();

        // Asignar el nuevo rol al usuario
        $user->syncRoles([$request->role]);

        // Redirigir a la lista de usuarios con un mensaje de éxito
        Alert::success('¡Exito!', 'Registro actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');

        return redirect()->route('usuarios.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $user = User::find($id);

            $user->delete();
            Alert::success('¡Exito!', 'Registro eliminado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->route('usuarios.index');

        } catch (\Throwable $th) {
            Alert::error('¡Error!', 'Este registro no se puede eliminar, posiblemente por relacion con registros importantes')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect()->route('usuarios.index');

        }
    }

    public function buscarCedula(string $cedula)
    {
        $user = User::where('dni', $cedula)->first();

        if ($user) {
            // Si se encuentra el usuario, devolver los datos del usuario
            $response = ['data' => $user];
            return response()->json($response);
        } else {
            // Si no se encuentra el usuario, devolver un mensaje de error
            $response = ['message' => 'Usuario no encontrado'];
            return response()->json($response);
        }
    }
    public function buscarEmail(string $email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            // Si se encuentra el usuario, devolver los datos del usuario
            $response = ['data' => $user];
            return response()->json($response);
        } else {
            // Si no se encuentra el usuario, devolver un mensaje de error
            $response = ['message' => 'Usuario no encontrado'];
            return response()->json($response);
        }
    }
}
