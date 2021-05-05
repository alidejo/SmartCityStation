<div class="table-responsive">
    <table class="table" id="devices-table">
        <thead>
            <tr>
                <th>Device Code</th>
        <th>State</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($devices as $device)
            <tr>
                <td>{{ $device->device_code }}</td>
            <td>{{ $device->state }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['backend.devices.destroy', $device->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('backend.devices.show', [$device->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('backend.devices.edit', [$device->id]) }}" class='btn btn-default btn-xs'>
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
