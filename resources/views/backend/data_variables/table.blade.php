<div class="table-responsive">
    <table class="table" id="dataVariables-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Alert Threshold</th>
                <th>Type Variable</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($dataVariables as $dataVariable)
            <tr>
                <td>{{ $dataVariable->name }}</td>
                <td>{{ $dataVariable->description }}</td>
                <td>{{ $dataVariable->alert_threshold }}</td>
                <td>{{ $dataVariable->typeVariable->name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.dataVariables.destroy', $dataVariable->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.dataVariables.show', [$dataVariable->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.dataVariables.edit', [$dataVariable->id]) }}" class='btn btn-default btn-xs'>
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
