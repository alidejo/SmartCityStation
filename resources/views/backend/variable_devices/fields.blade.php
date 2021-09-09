<!-- Device Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('device_id', 'Dispositivo:') !!}
    {!! Form::select('device_id', $devicies,null ,['class' => 'form-control']) !!}
</div>

<!-- Data Variable Id Field -->
<div class="form-group col-sm-12">
    {!! Form::label('data_variable_id', 'Datos de Variable:') !!}
    {!! Form::select('data_variable_id', $variables,null,['class' => 'form-control']) !!}
</div>