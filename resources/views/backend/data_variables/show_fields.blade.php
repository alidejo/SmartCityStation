<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{{ $dataVariable->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Descripcion:') !!}
    <p>{{ $dataVariable->description }}</p>
</div>

<!-- Alert Threshold Field -->
<div class="col-sm-12">
    {!! Form::label('alert_threshold', 'Umbral:') !!}
    <p>{{ $dataVariable->alert_threshold }}</p>
</div>

<!-- Type Variable Name Field -->
<div class="col-sm-12">
    {!! Form::label('type_variable_id', 'Tipo de Varible:') !!}
    <p>{{ $dataVariable->typeVariable->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Creado El:') !!}
    <p>{{ $dataVariable->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Actualizado El:') !!}
    <p>{{ $dataVariable->updated_at }}</p>
</div>

