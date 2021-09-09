<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{{ $area->name }}</p>
</div>

<!-- Village Name Field -->
<div class="col-sm-12">
    {!! Form::label('village_id', 'Municipio:') !!}
    <p>{{ $area->village->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Creado El:') !!}
    <p>{{ $area->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Actualizado El:') !!}
    <p>{{ $area->updated_at }}</p>
</div>

