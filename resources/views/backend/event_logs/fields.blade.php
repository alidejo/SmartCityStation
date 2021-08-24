<!-- Date Event Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date_event', 'Date Event:') !!}
    {!! Form::date('date_event', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Event Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_event', 'Type Event:') !!}
    {!! Form::text('type_event', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>