@extends('layouts.app')
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>
@section('content')
<section class="content">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class=" p-4 col-12 col-sm-6 j" style="box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;">
                    <h3 class="my-3" style="color: black; !important">{{$producto->nombre}}</h3>
                   Descripción: <p>{{$producto->descripcion}}</p>
                    <hr>


                    <h4 class="mt-3 bold"><strong>Categoría:</strong> <small>  {{$producto->subcategoria->categoria->nombre}}
                    {{$producto->subcategoria->nombre}}     </small></h4>
                    <h4 class="mt-3 bold"> <strong>Subcategoría:</strong> <small> 
                    {{$producto->subcategoria->nombre}}     </small></h4>
                    <div class="">
                        <h2 class="mb-0 ">
                            {{$producto->precio_venta}}
                        </h2>

                    </div>
                    <div class="mt-4" style="margin-top: 160px !important;">
                        <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-dark btn-lg btn-flat"
                                style=" border:none; width: 100%; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Agregar
                            </button>
                        </form>

                    </div>
                    <div class="mt-4 product-share">
                        <a href="#" class="text-gray">
                            <i class="fab fa-facebook-square fa-2x"></i>
                        </a>
                        <a href="#" class="text-gray">
                            <i class="fab fa-twitter-square fa-2x"></i>
                        </a>
                        <a href="#" class="text-gray">
                            <i class="fas fa-envelope-square fa-2x"></i>
                        </a>
                        <a href="#" class="text-gray">
                            <i class="fas fa-rss-square fa-2x"></i>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-6" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
                    <h4 class="d-inline-block d-sm-none">{{$producto->nombre}}</h4>

                    <div class="col-12 w-100 h-100">
                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($producto->imagenes as $imagen)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img class="d-block w-100" src="{{ asset($imagen->url) }}" alt="Product Image">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleSlidesOnly" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleSlidesOnly" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="m-4">
    <h3 class="mt-4">Productos Similares</h3>
    <div class="row">
        @foreach ($similares as $similar)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm p-3">
                <img src="{{$similar->imagenes->first()->url}}" style="height: 250px; object-fit: cover;" class="card-img-top" alt="...">
                <div class="label-top shadow-sm">{{$similar->nombre}}</div>
                <div class="card-body">
                    <div class="clearfix mb-3">
                        <span class="float-start badge rounded-pill bg-success">{{$similar->precio_venta}}</span>
                    </div>
                    <h5 class="card-title">{{$similar->descripcion}}</h5>
                    <div class="text-center my-4">
                        <a href="#" class="btn btn-info">Detalles</a>
                    </div>
                    <div class="clearfix mb-1">
                        <span class="float-start"><i class="far fa-question-circle"></i></span>
                        <span class="float-end"><i class="fas fa-plus"></i></span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


</section>

@endsection
@include('layout.script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>