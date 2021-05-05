<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $area->name }}</p>
</div>

<!-- Village Name Field -->
<div class="col-sm-12">
    {!! Form::label('village_id', 'Village:') !!}
    <p>{{ $area->village->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $area->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $area->updated_at }}</p>
</div>

