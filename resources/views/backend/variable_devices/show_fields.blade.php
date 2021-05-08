<!-- Device Field -->
<div class="col-sm-12">
    {!! Form::label('device_id', 'Device:') !!}
    <p>{{ $variableDevice->device->device_code }}</p>
</div>

<!-- Data Variable Field -->
<div class="col-sm-12">
    {!! Form::label('data_variable_id', 'Data Variable:') !!}
    <p>{{ $variableDevice->dataVariable->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $variableDevice->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $variableDevice->updated_at }}</p>
</div>

