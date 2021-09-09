@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Editar Dispositivo</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($device, ['route' => ['admin.devices.update', $device->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">

                    <!-- Device Code Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('device_code', 'Codigo Dispositivo:') !!}
                        {!! Form::text('device_code', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- State with toggle switch Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('state', 'Estado:') !!}
                        @if($device->state == 1)
                            {!! Form::checkbox('state', 'active', true,['class' => 'form-control switch-button']) !!}
                        @else
                            {!! Form::checkbox('state', 'active', false,['class' => 'form-control switch-button']) !!}
                        @endif
                    </div>

                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.devices.index') }}" class="btn btn-default">Cancelar</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
