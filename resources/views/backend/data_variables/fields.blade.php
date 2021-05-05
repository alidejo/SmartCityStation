<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Alert Threshold Field -->
<div class="form-group col-sm-6">
    {!! Form::label('alert_threshold', 'Alert Threshold:') !!}
    {!! Form::text('alert_threshold', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Variable Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_variable_id', 'Type Variable:') !!}
    {!! Form::select('type_variable_id', $tipyVariables, null, ['class' => 'form-control']) !!}
</div>