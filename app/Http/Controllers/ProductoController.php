<?php

namespace App\Http\Controllers;

use App\Models\ImagenProducto;
use App\Models\Producto;
use App\Models\SubCategoria;
use Illuminate\Http\Request;
use Flash;
use Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function almacen(Request $request)
    {
        if ($request->ajax()) {
            // Cargar la relación de subcategorías e imágenes
            $productos = Producto::with(['subCategoria', 'imagenes'])->get();

            return DataTables::of($productos)
                ->editColumn('created_at', function ($producto) {
                    return $producto->created_at->format('Y-m-d H:i:s');
                })
                ->addColumn('subCategoria', function ($producto) {
                    return $producto->subCategoria ? $producto->subCategoria->nombre : '';
                })
                ->addColumn('imagen', function ($producto) {
                    // Si hay imágenes, mostrar la primera imagen
                    if ($producto->imagenes && $producto->imagenes->count() > 0) {
                        $imagenUrl = asset($producto->imagenes->first()->url); // Obtener la URL de la primera imagen
                        return '<img src="' . $imagenUrl . '" alt="Imagen del producto" width="100px" height="100px" class="img-thumbnail">';
                    }
                    return ''; // Si no hay imágenes, no mostrar nada
                })
                ->addColumn('actions', 'productos.actions')
                ->rawColumns(['imagen', 'status', 'actions', 'fecha_vencimiento']) // Especificar que 'imagen' contiene HTML
                ->make(true);
        } else {
            return view('productos.index');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategorias = SubCategoria::pluck('nombre', 'id');

        return view('productos.create')->with('subcategorias', $subcategorias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario aquí si es necesario

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'aplica_iva' => $request->aplica_iva,

            'cantidad' => $request->cantidad,
            'sub_categoria_id' => $request->sub_categoria_id,
            'disponible' => $request->disponible
        ]);



        // Guardar las imágenes asociadas al producto
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $rutaImagen = '/productos/' . $nombreImagen;
                $imagen->move(public_path('productos'), $nombreImagen);

                ImagenProducto::create([
                    'url' => $rutaImagen,
                    'producto_id' => $producto->id,
                    'status' => 'Activo'
                ]);
            }
        }

        // Mensaje de éxito y redirección
        Alert::success('Éxito!', 'Producto Registrado correctamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('almacen'));
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
    public function edit(Request $request, $id)
    {
        $subcategorias = SubCategoria::pluck('nombre', 'id');
        $producto = Producto::where('id', $id)->first();
        $imagenes = ImagenProducto::where('producto_id', $id)->get();

        return view('productos.edit')->with('subcategorias', $subcategorias)->with('producto', $producto)->with('imagenes', $imagenes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'aplica_iva' => 'required|boolean',


            'cantidad' => 'required|integer|min:0',
            'sub_categoria_id' => 'required|exists:sub_categorias,id',
            'disponible' => 'required|boolean',
        ]);

        // Buscar el producto por su ID
        $producto = Producto::findOrFail($id);

        // Actualizar los campos del producto
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio_compra = $request->precio_compra;
        $producto->precio_venta = $request->precio_venta;
        $producto->aplica_iva = $request->aplica_iva;

        $producto->cantidad = $request->cantidad;
        $producto->sub_categoria_id = $request->sub_categoria_id;
        $producto->disponible = $request->disponible;

        // Guardar el producto actualizado
        $producto->save();
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $rutaImagen = '/productos/' . $nombreImagen;
                $imagen->move(public_path('productos'), $nombreImagen);

                ImagenProducto::create([
                    'url' => $rutaImagen,
                    'producto_id' => $producto->id,
                    'status' => 'Activo'
                ]);
            }
        }
        // Redireccionar con un mensaje de éxito
        Alert::success('¡Éxito!', 'Producto actualizado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('almacen');
    }


    public function imagenesProducto(Request $request, $id)
    {

        $producto = Producto::where('id', $id)->first();


        if (!$producto) {
            Alert::error('¡Error!', 'No existe este producto')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('almacen'));
        }
        $imagenes = ImagenProducto::where('producto_id', $id)->get();

        return view('productos.imagenes')->with('producto', $producto)->with('imagenes', $imagenes);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $producto = Producto::where('id', $id)->first();


        if (!$producto) {
            Alert::error('¡Error!', 'No existe este producto')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('almacen'));
        }

        $producto->delete();
        Alert::success('¡Éxito!', 'Producto eliminado exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect()->route('almacen');
    }

    public function agregarImagen(Request $request, $id)
    {

        $producto = Producto::where('id', $id)->first();
        // Guardar las imágenes asociadas al producto
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $rutaImagen = '/productos/' . $nombreImagen;
                $imagen->move(public_path('productos'), $nombreImagen);

                ImagenProducto::create([
                    'url' => $rutaImagen,
                    'producto_id' => $producto->id,
                    'status' => 'Activo'
                ]);
            }
        }

        // Mensaje de éxito y redirección
        Alert::success('Éxito!', 'Imagenes registradas exitosamente')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
        return redirect(route('almacen'));
    }

    public function removerImagen($id)
    {

        $imagen = ImagenProducto::where('id', $id)->first();


        if (!$imagen) {
            Alert::error('¡Error!', 'No existe esta imagen')->showConfirmButton('Aceptar', 'rgba(79, 59, 228, 1)');
            return redirect(route('almacen'));
        }

        $imagen->delete();
        return response()->json([
            'success' => true,
            'message' => 'Imagen eliminada exitosamente.'
        ], 200);
    }
}
