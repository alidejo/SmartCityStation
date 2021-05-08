<div class="table-responsive">
    <table class="table" id="variableDevices-table">
        <thead>
            <tr>
                <th>Device</th>
                <th>Variable</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($variableDevices as $variableDevice)
            <tr>
                <td>{{ $variableDevice->device->device_code }}</td>
                <td>{{ $variableDevice->dataVariable->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['backend.variableDevices.destroy', $variableDevice->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('backend.variableDevices.show', [$variableDevice->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('backend.variableDevices.edit', [$variableDevice->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
