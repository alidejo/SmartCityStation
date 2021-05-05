<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $dataVariable->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $dataVariable->description }}</p>
</div>

<!-- Alert Threshold Field -->
<div class="col-sm-12">
    {!! Form::label('alert_threshold', 'Alert Threshold:') !!}
    <p>{{ $dataVariable->alert_threshold }}</p>
</div>

<!-- Type Variable Name Field -->
<div class="col-sm-12">
    {!! Form::label('type_variable_id', 'Type Varible:') !!}
    <p>{{ $dataVariable->typeVariable->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $dataVariable->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $dataVariable->updated_at }}</p>
</div>

