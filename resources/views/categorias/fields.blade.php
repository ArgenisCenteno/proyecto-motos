<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-12 col-md-12">

        {!! Form::label('nombre', 'Nombre:', ['class' => 'bold']) !!}
        {!! Form::text('nombre', null, ['class' => 'form-control round']) !!}
    </div>
    <div class="form-group col-sm-12 col-md-12">
        {!! Form::label('status', 'Estatus:', ['class' => 'bold']) !!}
        {!! Form::select('status', [
           '1' => 'Activo',
           '0' => 'Inactivo',
            ], null, ['class' => 'form-control round']) !!}

    </div>
</div>

<!-- Submit Field -->
<div class="float-end">
        {!! Form::submit('Aceptar', ['class' => 'btn btn-primary round', 'id' => 'submit_btn']) !!}
    </div>