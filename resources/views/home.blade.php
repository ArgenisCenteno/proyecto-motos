

@extends('layout.app')
@section('content')

<main id="main" class="main">

    <div class="">
        <h1>Bienvenido, {{Auth::user()->name}} </h1>
    </div><!-- End Page Title -->
    @if(Auth::user()->hasRole('superAdmin'))
    <section>
        <div class="row">
            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                <div class="small-box bg-vinotinto text-white">
                    <div class="inner">
                        <h3>{{$totalVehiculos}}</h3>
                        <p>Vehículos</p>
                    </div> <span class="small-box-icon material-icons">two_wheeler</span>
                    </svg> 
                </div> <!--end::Small Box Widget 1-->
            </div> <!--end::Col-->
            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                <div class="small-box bg-vinotinto text-white">
                    <div class="inner">
                        <h3>{{$totalViajes}}</h3>
                        <p>Viajes</p>
                    </div> <span class="small-box-icon material-icons">card_travel</span>
                </div> <!--end::Small Box Widget 1-->
            </div> <!--end::Col-->
            <!-- /.col -->
            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                <div class="small-box bg-vinotinto text-white">
                    <div class="inner">
                        <h3>{{$totalConductoresRegistrados}}</h3>
                        <p>Conductores</p>
                    </div> <span class="small-box-icon material-icons">description</span>
                </div> <!--end::Small Box Widget 1-->
            </div> <!--end::Col-->
            

            <!-- fix for small devices only -->
            <!-- <div class="clearfix hidden-md-up"></div> -->

           
            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                <div class="small-box bg-vinotinto text-white">
                    <div class="inner">
                        <h3>{{$totalPasajeros}}</h3>
                        <p>Pasajeros</p>
                    </div> <span class="small-box-icon material-icons">group_add</span>
                </div> <!--end::Small Box Widget 1-->
            </div> <!--end::Col-->
            
        </div>

        <div class="row">
            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                <div class="small-box bg-vinotinto text-white">
                    <div class="inner">
                        <h3>{{$totalVehiculos}}</h3>
                        <p>Ingresos de hoy</p>
                    </div> <span class="small-box-icon material-icons">payments</span>
                </div> <!--end::Small Box Widget 1-->
            </div> <!--end::Col-->
            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                <div class="small-box bg-vinotinto text-white">
                    <div class="inner">
                        <h3>{{$totalViajes}}</h3>
                        <p>Viajes realizados hoy</p>
                    </div> <span class="small-box-icon material-icons">sell</span>
                </div> <!--end::Small Box Widget 1-->
            </div> <!--end::Col-->
            <!-- /.col -->
            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                <div class="small-box bg-vinotinto text-white">
                    <div class="inner">
                        <h3>{{$totalConductoresRegistrados}}</h3>
                        <p>Tramites registrados</p>
                    </div> <span class="small-box-icon material-icons">content_paste</span>
                </div> <!--end::Small Box Widget 1-->
            </div> <!--end::Col-->
            

            <!-- fix for small devices only -->
            <!-- <div class="clearfix hidden-md-up"></div> -->

           
            <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                <div class="small-box bg-vinotinto text-white">
                    <div class="inner">
                        <h3>{{$totalPasajeros}}</h3>
                        <p>Vehículos Inactivos</p>
                    </div><span class="small-box-icon material-icons">pending_actions</span>
                </div> <!--end::Small Box Widget 1-->
            </div> <!--end::Col-->
            
        </div>
        <!-- /.row -->
        <div class="card-body">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-7">
                <p class="text-center">
                        <strong>Total de Viajes Mensual</strong>
                    </p>

                    <!-- Contenedor para el gráfico -->
                    <div id="combined-chart"></div>
                </div>
                <!-- /.col -->
                <div class="col-md-5">
                    <p class="text-center">
                        <strong>Los combatientes de Punta de Mata</strong>
                    </p>

                    <div class="d-flex justify-content-center">
                        <img src="https://img.freepik.com/foto-gratis/hermosa-joven-viajando-ciudad_23-2149063315.jpg?t=st=1735406854~exp=1735410454~hmac=fbc468e87dbc074f50916be2f2c6ccc1b989258d976016cebfd3d5d54164c8cc&w=360"
                            alt="imagen" width="300px">
                    </div>
                    <!-- /.progress-group -->
                </div>
                <!-- /.col -->
            </div>
            <!--end::Row-->
        </div>
    </section>
@else 
<section class="for-clients">
    <div class="container py-5">
       
        <p class="text-center text-muted">Explora los servicios disponibles y disfruta de los beneficios de nuestra plataforma.</p>

        <!-- Summary Cards -->
        <div class="row text-center mb-4">
            <div class="col-md-3">
                <div class="card bg-light shadow-sm">
                    <div class="card-body">
                        <span class="material-icons text-primary" style="font-size: 40px;">directions_bike</span>
                        <h4 class="mt-2">{{ $viajesCancelados + $viajesFinalizados + $viajesPendientes + $viajesIniciados ?? 0 }}</h4>
                        <p class="text-muted">Viajes Solicitados</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light shadow-sm">
                    <div class="card-body">
                        <span class="material-icons text-success" style="font-size: 40px;">check_circle</span>
                        <h4 class="mt-2"> {{ $viajesFinalizados ?? 0 }} </h4>
                        <p class="text-muted">Viajes Completados</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light shadow-sm">
                    <div class="card-body">
                        <span class="material-icons text-warning" style="font-size: 40px;">hourglass_empty</span>
                        <h4 class="mt-2">{{ $viajesPendientes ?? 0 }}</h4>
                        <p class="text-muted">Viajes Pendientes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-light shadow-sm">
                    <div class="card-body">
                        <span class="material-icons text-danger" style="font-size: 40px;">cancel</span>
                        <h4 class="mt-2">{{ $viajesCancelados ?? 0 }}</h4>
                        <p class="text-muted">Viajes Cancelados</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Options -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <span class="material-icons" style="font-size: 40px;">local_taxi</span>
                        <div class="ms-3">
                            <h5>Solicitar un Ride</h5>
                            <p class="mb-0">Elige tu destino y disfruta del mejor servicio.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <span class="material-icons" style="font-size: 40px;">star_rate</span>
                        <div class="ms-3">
                            <h5>Beneficios VIP</h5>
                            <p class="mb-0">Accede a descuentos y servicios exclusivos.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-warning text-white shadow-sm h-100">
                    <div class="card-body d-flex align-items-center">
                        <span class="material-icons" style="font-size: 40px;">support</span>
                        <div class="ms-3">
                            <h5>Soporte 24/7</h5>
                            <p class="mb-0">Estamos aquí para ayudarte en todo momento.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
         
    </div>
</section>

@endif

</main><!-- End #main -->

<!--begin::Footer-->
@include('layout.script')
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const meses = @json($meses);  // Los meses obtenidos de PHP
        const viajesData = @json($viajesData);  // Datos de compras

        // Opciones de la gráfica
        const combined_chart_options = {
            series: [
                {
                    name: "Viajes",
                    data: viajesData,  // Datos de compras
                    type: 'line',  // Tipo de gráfico para compras
                    color: '#28a745'  // Color para compras (verde)
                },

            ],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: true,
                }
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: [3, 3],  // Grosor de las líneas
                curve: 'smooth',  // Curva suave
            },
            fill: {

                color: "#0d6efd",  // Color de relleno (puedes usar el mismo color que la línea o diferente)
            },
            xaxis: {
                categories: meses,  // Meses para el eje X
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (val) {
                        return "Bs " + val.toFixed(2);  // Formato de los valores en el tooltip
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center',
                floating: true,
            }
        };

        // Crear el gráfico con las opciones
        const combined_chart = new ApexCharts(
            document.querySelector("#combined-chart"),
            combined_chart_options
        );
        combined_chart.render();
    });
</script>
@endsection