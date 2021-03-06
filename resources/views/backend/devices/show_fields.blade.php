<!-- Device Code Field -->
<div class="col-sm-12">
    {!! Form::label('device_code', 'Device Code:') !!}
    <p>{{ $device->device_code }}</p>
</div>

<!-- State Field -->
<div class="col-sm-12">
    {!! Form::label('state', 'State:') !!}
    @if($device->state == 1)
        <p>Active</p>
    @else
    <p>Not Active</p>
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $device->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $device->updated_at }}</p>
</div>

