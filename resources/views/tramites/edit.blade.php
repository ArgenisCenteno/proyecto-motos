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
                            <h3 class="p-2 bold">Detalles del Tramite</h3>
                        </div>
                       
                    </div>
                    <div class="">
                  @if(Auth::user()->hasRole('superAdmin'))
                    @include('tramites.fields')
                  @else
                    @include('tramites.showfields')
                  
                          @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main> <!--end::App Main--> <!--begin::Footer-->
@endsection
