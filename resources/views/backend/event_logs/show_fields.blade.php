<!-- Date Event Field -->
<div class="col-sm-12">
    {!! Form::label('date_event', 'Date Event:') !!}
    <p>{{ $eventLog->date_event }}</p>
</div>

<!-- Type Event Field -->
<div class="col-sm-12">
    {!! Form::label('type_event', 'Type Event:') !!}
    <p>{{ $eventLog->type_event }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $eventLog->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $eventLog->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $eventLog->updated_at }}</p>
</div>

