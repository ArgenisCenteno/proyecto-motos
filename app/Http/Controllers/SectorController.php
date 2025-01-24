<?php

namespace App\Http\Controllers;

use App\Models\Parish;
use App\Models\Sector;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Alert;
class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sectors = Sector::with('parish')->get(); // Cargar la relación 'parroquia'

            return DataTables::of($sectors)
                ->addColumn('parroquia', function ($row) {
                    return $row->parish ? $row->parish->parish : 'N/A'; // Mostrar el nombre de la parroquia si existe
                })
                ->addColumn('estado', function ($row) {
                    // Pass the row's id to the actions Blade view
                    return $row->estado == 'Activo' ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
                })
                ->addColumn('fecha', function ($row) {
                    return $row->created_at->format('d-m-Y'); // Formatear la fecha de creación
                })
                ->addColumn('actions', function ($row) {
                    return view('sectores.actions', ['id' => $row->id])->render();
                })
                
                ->rawColumns(['actions', 'estado']) // Permitir HTML en la columna de acciones
                ->make(true);
        } else {
            return view('sectores.index'); // Vista para mostrar la datatable
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parroquias = Parish::where('municipality_id', '263')->get();
        return view('sectores.create')->with('parroquias', $parroquias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:sectors,nombre',
            'parroquia_id' => 'required|exists:parishes,id', // Verificar que la parroquia exista
            'estado' => 'required|string|max:255',
        ]);

        // Crear un nuevo sector
        $sector = new Sector();
        $sector->nombre = $validatedData['nombre'];
        $sector->parroquia_id = $validatedData['parroquia_id'];
        $sector->estado = $validatedData['estado'];
        $sector->save();

        Alert::success('¡Éxito!', 'Registro hecho correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('sectores.index'));
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
        $parroquias = Parish::where('municipality_id', '263')->get();
        $sector = Sector::find($id);
        return view('sectores.edit')->with('parroquias', $parroquias)->with('sector', $sector);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscar el sector por ID
        $sector = Sector::findOrFail($id);

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:sectors,nombre,' . $sector->id, // Ignorar el nombre actual del sector
            'parroquia_id' => 'required|exists:parishes,id', // Verificar que la parroquia exista
            'estado' => 'required|string|max:255',
        ]);

        // Actualizar el sector
        $sector->nombre = $validatedData['nombre'];
        $sector->parroquia_id = $validatedData['parroquia_id'];
        $sector->estado = $validatedData['estado'];
        $sector->save();

        Alert::success('¡Éxito!', 'Registro actualizado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('sectores.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el sector por ID
        $sector = Sector::findOrFail($id);

        // Eliminar el sector
        $sector->delete();

        Alert::success('¡Éxito!', 'Registro eliminado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('sectores.index'));
    }
}
