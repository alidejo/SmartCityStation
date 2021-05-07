<div class="table-responsive">
    <table class="table" id="locationDevices-table">
        <thead>
            <tr>
                <th>Address</th>
                <th>Installation Date</th>
                <th>Installation Hour</th>
                <th>Remove Date</th>
                <!-- <th>Remove Hour</th> -->
                <th>Latitude</th>
                <th>Length</th>
                <th>Device</th>
                <th>Area</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($locationDevices as $locationDevice)
            <tr>
                <td>{{ $locationDevice->address }}</td>
            <td>{{ $locationDevice->installation_date }}</td>
            <td>{{ $locationDevice->installation_hour }}</td>
            @if($locationDevice->remove_date != $locationDevice->installation_date)
                <td>{{ $locationDevice->remove_date }}</td>
            @else
                <td></td>
            @endif
            <!-- <td>{{ $locationDevice->remove_hour }}</td> -->
            <td>{{ $locationDevice->latitude }}</td>
            <td>{{ $locationDevice->length }}</td>
            <td>{{ $locationDevice->device->device_code }}</td>
            <td>{{ $locationDevice->area->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['backend.locationDevices.destroy', $locationDevice->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('backend.locationDevices.show', [$locationDevice->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('backend.locationDevices.edit', [$locationDevice->id]) }}" class='btn btn-default btn-xs'>
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
