<!-- Device Field -->
<div class="col-sm-12">
    {!! Form::label('device_id', 'Dispositivo:') !!}
    <p>{{ $variableDevice->device->device_code }}</p>
</div>

<!-- Data Variable Field -->
<div class="col-sm-12">
    {!! Form::label('data_variable_id', 'Datos de la variable:') !!}
    <p>{{ $variableDevice->dataVariable->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Creado El:') !!}
    <p>{{ $variableDevice->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Actualizado El:') !!}
    <p>{{ $variableDevice->updated_at }}</p>
</div>

