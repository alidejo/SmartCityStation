<!-- Device Code Field -->
<div class="col-sm-12">
    {!! Form::label('device_code', 'Codigo de Dispositivo:') !!}
    <p>{{ $device->device_code }}</p>
</div>

<!-- State Field -->
<div class="col-sm-12">
    {!! Form::label('state', 'Estado:') !!}
    @if($device->state == 1)
        <p>Active</p>
    @else
    <p>Not Active</p>
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Creado El:') !!}
    <p>{{ $device->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Actualizado El:') !!}
    <p>{{ $device->updated_at }}</p>
</div>

