<?php
// app/Http/Controllers/ConductorController.php

namespace App\Http\Controllers;

use App\Models\User; // Assuming User model is used for conductores
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Alert;
class PasajeroController extends Controller
{
    public function index(Request $request)
    {
        // Fetch conductores with role "conductor"
        if ($request->ajax()) {
            $users = User::role('cliente')->get(); // Use `with` to eager load roles

            return DataTables::of($users)
               
                ->addColumn('fecha', function ($row) {
                    return $row->created_at->format('m-d-Y'); // Use getRoleNames() to get assigned roles
    
                })
                ->addColumn('status', function ($row) {
                    // Pass the row's id to the actions Blade view
                    return $row->status == 'Activo' ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
                })
                ->addColumn('actions', function ($row) {
                    $viewUrl = route('pasajeros.show', $row->id);
                    
                    return '<a href="' . $viewUrl . '" class="btn btn-info btn-sm">Ver</a>
                            
                         ';
                })
                ->rawColumns(['role', 'actions', 'status'])
                ->make(true);
        } else {
            return view('pasajeros.index');
        }
    }

    public function show($id)
    {
        $pasajero = User::findOrFail($id);
        return view('pasajeros.show', compact('pasajero'));
    }
}
