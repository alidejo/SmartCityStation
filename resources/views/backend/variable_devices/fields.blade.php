<!-- Device Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device_id', 'Device:') !!}
    {!! Form::select('device_id', $devicies, ['class' => 'form-control']) !!}
</div>

<!-- Data Variable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('data_variable_id', 'Data Variable:') !!}
    {!! Form::select('data_variable_id', $variables, ['class' => 'form-control']) !!}
</div>