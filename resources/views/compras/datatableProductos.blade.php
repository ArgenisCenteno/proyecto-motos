<div class="table-responsive">
    <table class="table table-striped table-bordered " id="productos-table2">
        <thead class="thead-dark">
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Aplica IVA</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


@section('js')
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{asset('js/sweetalert2.js')}}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        let productosEnCarrito = [];


        $('#productos-table2').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('ventas.datatableProductoVenta') }}",
            dataType: 'json',
            type: "POST",
            columns: [
                {
                    data: 'nombre',
                    name: 'nombre',
                    className: "align-middle"
                },
                {
                    data: 'precio_venta',
                    name: 'precio_venta',
                    className: "align-middle",
                    render: $.fn.dataTable.render.number(',', '.', 2, '$')  // Formato de moneda
                },
                {
                    data: 'aplica_iva',
                    name: 'aplica_iva',
                    className: "align-middle text-center",
                    render: function (data) {
                        return data ? '<i class="text-success fas fa-check-circle"></i> Sí' : '<i class="text-danger fas fa-times-circle"></i> No';
                    }
                },
                {
                    data: 'id',
                    name: 'actions',
                    searchable: false,
                    orderable: false,
                    className: "align-middle text-center",
                    render: function (data, type, full, meta) {
                        return `
                        <button type="button" class="btn btn-sm btn-primary addToCartBtn" data-product-id="${data}">
                            <i class="fas fa-cart-plus"></i> Añadir
                        </button>`;
                    }
                }
            ],
            order: [[0, 'desc']],
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "No se encontraron productos",
                info: "Mostrando página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(filtrado de _MAX_ registros en total)",
                search: "Buscar:",
                paginate: {
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });

        $(document).on('click', '.addToCartBtn', function () {
            const productId = $(this).data('product-id');
            const url = '{{ route('productos.obtener', ['id' => ':id']) }}';
            const urlWithId = url.replace(':id', productId);
            const $button = $(this);

            $.ajax({
                url: urlWithId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const producto = response.producto;



                        const productName = producto.nombre;
                        const productPrice = producto.precio_compra;
                        const productIva = producto.aplica_iva ? 'Sí' : 'No';
                        var precioProductoIva = producto.precio_compra;
                        if (productIva == 'Sí') {
                            var precioProductoIva = productPrice * 1.16;
                        } else {
                            var precioProductoIva = productPrice;
                        }
                        const productDescription = producto.descripcion;
                        const productLote = producto.lote;
                        const productoStock = producto.cantidad;
                        const productSubcategoria = producto.subCategoria ? producto.subCategoria.nombre : '';

                        // Agregar el producto al array
                        productosEnCarrito.push({
                            id: productId,
                            nombre: productName,
                            precio: productPrice,
                            aplicaIva: producto.aplica_iva,
                            cantidad: 1 // Cantidad inicial
                        });
                        const productoHTML = `
   <div class="producto-item card mb-3 shadow-sm productoCarrito" id="productoCarrito_${productId}">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="fw-bold text-dark">${productName}</h5>
            <h5 class="text-success">Bs ${precioProductoIva}</h5>
        </div>
        <div class="mb-3">
            <h6 class="text-muted">Precio sin IVA:</h6>
            <span class="text-primary" id="precioProducto_${productId}">Bs${productPrice}</span>
        </div>
        
        <div class="mb-2 d-flex align-items-center">
            <h6 class="text-muted me-2">Aplica IVA:</h6>
            <span id="aplicaIVA_${productId}" class="badge ${productIva ? 'bg-success' : 'bg-danger'}">
                ${productIva ? 'Sí' : 'No'}
            </span>
        </div>

        <div class="mb-3">
            <h6 class="text-muted">Descripción:</h6>
            <p class="small text-secondary">${productDescription}</p>
        </div>
        
        <div class="d-flex justify-content-between align-items-center">
            <div class="input-group">
                <span class="input-group-text">Cantidad:</span>
                <input type="number" class="form-control cantidadProducto" value="1" min="1" id="cantidadProducto_${productId}">
                <input type="hidden" class="stock" id="stock_${productId}" value="${productoStock}"/>
            </div>
            <button type="button" class="btn btn-danger btn-sm ms-3 removeProducto" id="removeProducto_${productId}">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
    </div>
</div>

`;

                        // Agregar el productoHTML al contenedor #productoCarrito
                        $('#productoCarrito').append(productoHTML);
                        $button.prop('disabled', true);

                        // Calcular el total a pagar
                        calcularTotal();
                        actualizarProductosInput();
                    } else {
                        console.error('Error: No se pudo obtener el producto.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener el producto:', error);
                }
            });
        });

        $(document).on('click', '.removeProducto', function () {
            const productId = $(this).attr('id').split('_')[1];
            $('#productoCarrito_' + productId).remove();
            const $button = $(this);

            // Eliminar el producto del array
            productosEnCarrito = productosEnCarrito.filter(function (producto) {
                return producto.id != productId;
            });
            $('.addToCartBtn[data-product-id="' + productId + '"]').prop('disabled', false);
            calcularTotal();
            actualizarProductosInput();
        });

        $(document).on('change', '.cantidadProducto', function () {
            console.log("tets")
            const productId = $(this).attr('id').split('_')[1]; // Obtener el ID del producto
            const nuevaCantidad = parseInt($(this).val());
           


            // Actualizar la cantidad en el array
            productosEnCarrito = productosEnCarrito.map(function (producto) {
                if (producto.id == productId) {
                    producto.cantidad = nuevaCantidad;
                }
                return producto;
            });

            // Recalcular el total
            calcularTotal();
            actualizarProductosInput();
        });
        // Función para calcular el total de la venta
        function calcularTotal() {
            let total = 0;

            // Iterar sobre cada producto en el carrito
            $('.productoCarrito').each(function () {
                const productId = $(this).attr('id').split('_')[1];

                if (productId != undefined) {

                    const precioProducto = parseFloat($('#precioProducto_' + productId).text().replace('Bs', ''));

                    const cantidad = parseInt($('#cantidadProducto_' + productId).val());
                    const aplicaIva = $('#aplicaIVA_' + productId).text().trim() === 'Sí';

                    let subtotalProducto = precioProducto * cantidad;

                    // Aplicar el IVA si corresponde
                    if (aplicaIva) {
                        subtotalProducto *= 1.16; // 16% de IVA
                    }

                    total += subtotalProducto;

                }
            });



            // Mostrar el total calculado
            $('.totalVenta').text('$' + total.toFixed(2));

        }

        function actualizarProductosInput() {
            $('#productosInput').val(JSON.stringify(productosEnCarrito));
        }
    });


    let metodosPago = [];


    calcularTotalPagos();

    const tasaCambio = parseFloat($('#tasa').val());


   

    // Calcular y actualizar total a pagar y total cancelado
    function calcularTotalPagos() {
        totalPagar = 0;
        totalCancelado = 0;


        // Si el método de pago es divisa, aplicar la tasa de cambio al monto_bs
        metodosPago.forEach(metodo => {


            
                totalCancelado += metodo.monto_bs;
            
        });

        // Actualizar en el DOM
        let totalVenta = parseFloat($('#totalVenta').text().replace('$', ''));
        $('#cancelado').text('$' + totalCancelado.toFixed(2));
        $('#restante').text((totalCancelado - totalVenta).toFixed(2));


        // Habilitar o deshabilitar botón submit según el total pagado
        validarTotalPagado();
    }

    // Validar el total pagado y habilitar/deshabilitar botón submit
    function validarTotalPagado() {
        const tasa = parseFloat($('#tasa').val()) || 1; // Obtener la tasa de cambio (por defecto 1 si está vacío)
        const totalPagadoBs = totalCancelado * tasa;

        if (totalPagadoBs >= totalPagar) {
            $('#btnSubmit').prop('disabled', false).removeClass('btn-danger').addClass('btn-primary');
        } else {
            $('#btnSubmit').prop('disabled', true).removeClass('btn-primary').addClass('btn-danger');
            alert('El monto pagado no puede ser menor al total a pagar en bolívares.');
        }
    }

    // Evento cambio en la tasa de cambio
    $('#tasa').on('input', function () {
        tasaCambio = parseFloat($(this).val()) || 1; // Actualizar la tasa de cambio
        calcularTotalPagos(); // Recalcular total con la nueva tasa de cambio
    });

    // Envío del formulario
    $('#ventaForm').on('submit', function (event) {
        event.preventDefault();

        // Validar una última vez antes de enviar
        if (totalPagar <= 0 || totalCancelado < totalPagar) {
            alert('Aún no se ha pagado el total requerido.');
            return;
        }

        // Aquí puedes enviar el formulario al controlador
        // Implementa tu lógica para enviar los datos al servidor
        alert('Formulario enviado correctamente.');
        // this.submit(); // Descomenta esta línea para enviar el formulario realmente
    });
</script>

@endsection