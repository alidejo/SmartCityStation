<!-- Address Field -->
<div class="col-sm-12">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $locationDevice->address }}</p>
</div>

<!-- Installation Date Field -->
<div class="col-sm-12">
    {!! Form::label('installation_date', 'Installation Date:') !!}
    <p>{{ $locationDevice->installation_date }}</p>
</div>

<!-- Installation Hour Field -->
<div class="col-sm-12">
    {!! Form::label('installation_hour', 'Installation Hour:') !!}
    <p>{{ $locationDevice->installation_hour }}</p>
</div>

<!-- Remove Date Field -->
@if($locationDevice->remove_date != $locationDevice->installation_date)
    <div class="col-sm-12">
        {!! Form::label('remove_date', 'Remove Date:') !!}    
        <p>{{ $locationDevice->remove_date }}</p>
    </div>
@endif

<!-- Remove Hour Field -->
<!-- <div class="col-sm-12">
    {!! Form::label('remove_hour', 'Remove Hour:') !!}
    <p>{{ $locationDevice->remove_hour }}</p>
</div> -->

<!-- Latitude Field -->
<div class="col-sm-12">
    {!! Form::label('latitude', 'Latitude:') !!}
    <p>{{ $locationDevice->latitude }}</p>
</div>

<!-- Length Field -->
<div class="col-sm-12">
    {!! Form::label('length', 'Length:') !!}
    <p>{{ $locationDevice->length }}</p>
</div>

<!-- Device Code Field -->
<div class="col-sm-12">
    {!! Form::label('device_id', 'Device:') !!}
    <p>{{ $locationDevice->device->device_code }}</p>
</div>

<!-- Name Area Field -->
<div class="col-sm-12">
    {!! Form::label('area_id', 'Area:') !!}
    <p>{{ $locationDevice->area->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $locationDevice->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $locationDevice->updated_at }}</p>
</div>

