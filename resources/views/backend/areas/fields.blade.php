<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Village Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('village_id', 'Municipio:') !!}
    {!! Form::select('village_id', $villages, null, ['class' => 'form-control']) !!}
</div>