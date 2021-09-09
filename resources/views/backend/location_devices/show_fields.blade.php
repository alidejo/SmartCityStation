<!-- Address Field -->
<div class="col-sm-12">
    {!! Form::label('address', 'Direccion:') !!}
    <p>{{ $locationDevice->address }}</p>
</div>

<!-- Installation Date Field -->
<div class="col-sm-12">
    {!! Form::label('installation_date', 'Dia de la instalacion:') !!}
    <p>{{ $locationDevice->installation_date }}</p>
</div>

<!-- Installation Hour Field -->
<div class="col-sm-12">
    {!! Form::label('installation_hour', 'Hora de la Instalacion:') !!}
    <p>{{ $locationDevice->installation_hour }}</p>
</div>

<!-- Remove Date Field -->
@if($locationDevice->remove_date != $locationDevice->installation_date)
    <div class="col-sm-12">
        {!! Form::label('remove_date', 'Dia del Retiro:') !!}    
        <p>{{ $locationDevice->remove_date }}</p>
    </div>
@endif

<!-- Remove Hour Field -->
<!-- <div class="col-sm-12">
    {!! Form::label('remove_hour', 'Hora del retiro:') !!}
    <p>{{ $locationDevice->remove_hour }}</p>
</div> -->

<!-- Latitude Field -->
<div class="col-sm-12">
    {!! Form::label('latitude', 'Latitud:') !!}
    <p>{{ $locationDevice->latitude }}</p>
</div>

<!-- Length Field -->
<div class="col-sm-12">
    {!! Form::label('length', 'longitud:') !!}
    <p>{{ $locationDevice->length }}</p>
</div>

<!-- Device Code Field -->
<div class="col-sm-12">
    {!! Form::label('device_id', 'Dispositivo:') !!}
    <p>{{ $locationDevice->device->device_code }}</p>
</div>

<!-- Name Area Field -->
<div class="col-sm-12">
    {!! Form::label('area_id', 'Area:') !!}
    <p>{{ $locationDevice->area->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Creado El:') !!}
    <p>{{ $locationDevice->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Actualizado El:') !!}
    <p>{{ $locationDevice->updated_at }}</p>
</div>

