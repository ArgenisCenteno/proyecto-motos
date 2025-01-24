<form action="{{ route('compras.generarCompra') }}" method="POST">
    @csrf <!-- Agrega el token CSRF para seguridad -->
    <section class="p-4 bg-light rounded shadow-sm">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        
        <span class="text-muted">{{ auth()->user()->name }}</span>
    </div>


    <!-- Monto total -->
    <div class="text-center mb-5">
        <h5 class="text-success">Monto Total a Pagar: <span id="totalVenta" class="totalVenta">$0.00</span></h5>
        <input type="hidden" name="productos" id="productosInput">
        <input type="hidden" name="metodos_pago" id="metodosPagoInput">
    </div>

    <hr class="mb-5" />

    <!-- Proveedor y Métodos de Pago -->
    <div class="row">
        <!-- Selección de Proveedor -->
        <div class="col-md-6 mb-4">
            <h4>Proveedor</h4>
            <select name="user_id" id="user_id" class="form-select select2">
                <option value="">Seleccione un Proveedor</option>
                @foreach($users as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Métodos de Pago -->
        <div class="col-md-6">
            <h4>Métodos de Pago</h4>
            <div class="row g-3">
                <div class="col-md-12">
                    <select class="form-select" id="metodoPago" name="metodoPago">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="Pago Movil">Pago Móvil</option>
                        <option value="Divisa">Divisa</option>
                        <option value="Punto de Venta">Punto de Venta</option>
                    </select>
                </div>
              
            </div>
        </div>
    </div>

   
    <!-- Productos en el carrito -->
    <div id="productoCarrito" class="bg-white p-3 rounded mb-4 shadow-sm">
        <!-- Aquí se cargarán los productos -->
    </div>

    <hr class="mt-5" />

    <!-- Botón de envío -->
    <div class="text-center">
        <button type="submit" id="submitBtn" class="btn btn-primary btn-lg" >Generar Venta</button>
    </div>
</section>


</form>