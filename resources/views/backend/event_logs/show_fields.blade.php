<!-- Date Event Field -->
<div class="col-sm-12">
    {!! Form::label('date_event', 'Fecha del Evento:') !!}
    <p>{{ $eventLog->date_event }}</p>
</div>

<!-- Type Event Field -->
<div class="col-sm-12">
    {!! Form::label('type_event', 'Tipo del Evento:') !!}
    <p>{{ $eventLog->type_event }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Descripcion:') !!}
    <p>{{ $eventLog->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Creado El:') !!}
    <p>{{ $eventLog->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Actualizado El:') !!}
    <p>{{ $eventLog->updated_at }}</p>
</div>

