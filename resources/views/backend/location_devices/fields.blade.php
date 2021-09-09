<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Direccion:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- Installation Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('installation_date', 'Dia de la instalacion:') !!}
    @if($desde == "Edit")    
        <p>{{ $locationDevice->installation_date }}</p>  
    @endif           
    {{ Form::date('installation_date', null, ['class' => 'form-control']) }}
</div>

<!-- Installation Hour Field -->
<div class="form-group col-sm-6">
    {!! Form::label('installation_hour', 'Hora de la Instalacion:') !!}
    @if($desde == "Edit")    
        <p>{{ $locationDevice->installation_hour }}</p> 
    @endif       
    {!! Form::time('installation_hour', null, ['class' => 'form-control']) !!}
</div>

@if($desde == "Edit")
    <!-- Remove Date Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('remove_date', 'Dia del Retiro:') !!}
        <p>{{ $locationDevice->remove_date }}</p>            
        {{ Form::date('remove_date', null, ['class' => 'form-control']) }}    
    </div>
    <!-- Remove Hour Field -->
    <!-- <div class="form-group col-sm-6">
        {!! Form::label('remove_hour', 'Hora del retiro:') !!}
        {!! Form::time('remove_hour', null, ['class' => 'form-control']) !!}
    </div> -->
@endif

<!-- Latitude Field -->
<div class="form-group col-sm-6">
    {!! Form::label('latitude', 'Latitud:') !!}
    {!! Form::number('latitude', null, ['class' => 'form-control', 'step'=>'any']) !!}
</div>

<!-- Length Field -->
<div class="form-group col-sm-6">
    {!! Form::label('length', 'longitud:') !!}
    {!! Form::number('length', null, ['class' => 'form-control', 'step'=>'any']) !!}
</div>

<!-- Device Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device_id', 'Dispositivo:') !!}
    {!! Form::select('device_id', $devices, null, ['class' => 'form-control']) !!}
</div>

<!-- Area Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area_id', 'Area:') !!}
    {!! Form::select('area_id', $areas, null, ['class' => 'form-control']) !!}
</div>