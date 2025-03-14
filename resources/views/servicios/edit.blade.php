@extends('layout.app')
@section('content')
<main id="main" class="main"> <!--begin::App Content Header-->
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class=" border-0 my-5">
                    <div class="px-2 row">
                        <div class="col-lg-12">
                            @include('flash::message')
                        </div>
                        <div class="col-md-6 col-6">
                            <h3 class="p-2 bold">Editar Servicio</h3>
                        </div>
                       
                    </div>
                    <div class="">
                  
                    {!! Form::model($servicio, ['route' => ['servicios.update', $servicio->id], 'method' => 'PUT', 'class' => 'btn-create', 'enctype' => 'multipart/form-data']) !!}
                            @include('servicios.edit_fields')
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection
