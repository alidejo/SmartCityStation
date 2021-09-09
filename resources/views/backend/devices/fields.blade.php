<!-- Device Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('device_code', 'Codigo de Dispositivo:') !!}
    {!! Form::text('device_code', null, ['class' => 'form-control']) !!}
</div>

<!-- State with toggle switch Field -->
<div class="form-group col-sm-6">
    {!! Form::label('state', 'Estado:') !!}
    {!! Form::checkbox('state', 'active', true,['class' => 'form-control switch-button']) !!}
</div>