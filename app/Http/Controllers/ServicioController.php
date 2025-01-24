<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Alert;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $servicios = Servicio::all(); // Obtener todos los servicios

            return DataTables::of($servicios)
                ->addColumn('costo', function ($row) {
                    return number_format($row->costo, 2) . ' Bs'; // Formatear el costo con dos decimales
                })
                ->addColumn('fecha', function ($row) {
                    return $row->created_at->format('d-m-Y'); // Formatear la fecha de creación
                })
                ->addColumn('actions', function ($row) {
                    // Pass the row's id to the actions Blade view
                    return view('servicios.actions', ['id' => $row->id])->render();
                })
                
                ->rawColumns(['actions']) // Permitir HTML en la columna de acciones
                ->make(true);
        } else {
            return view('servicios.index'); // Vista para mostrar la datatable
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('servicios.create'); // Vista para el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'descripcion' => 'required|string|max:255|unique:servicios,descripcion',
            'costo' => 'required|numeric|min:0', // Validar que el costo sea un número positivo
        ]);

        // Crear un nuevo servicio
        $servicio = new Servicio();
        $servicio->descripcion = $validatedData['descripcion'];
        $servicio->costo = $validatedData['costo'];
        $servicio->save();

        Alert::success('¡Éxito!', 'Servicio creado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('servicios.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('servicios.edit', compact('servicio')); // Vista para el formulario de edición
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscar el servicio por ID
        $servicio = Servicio::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'descripcion' => 'required|string|max:255|unique:servicios,descripcion,' . $servicio->id, // Ignorar la descripción actual del servicio
            'costo' => 'required|numeric|min:0', // Validar que el costo sea un número positivo
        ]);

        // Actualizar el servicio
        $servicio->descripcion = $validatedData['descripcion'];
        $servicio->costo = $validatedData['costo'];
        $servicio->save();

        Alert::success('¡Éxito!', 'Servicio actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('servicios.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el servicio por ID
        $servicio = Servicio::findOrFail($id);

        // Eliminar el servicio
        $servicio->delete();

        Alert::success('¡Éxito!', 'Servicio eliminado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('servicios.index'));
    }
}
