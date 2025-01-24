

@extends('layout.app')
@section('content')

<main id="main" class="main">

    <div class="">
        <h1>Bienvenido, {{Auth::user()->name}} </h1>
    </div><!-- End Page Title -->
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