<div class="table-responsive">
    <table class="table" id="typeVariables-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($typeVariables as $typeVariable)
            <tr>
                <td>{{ $typeVariable->name }}</td>
            <td>{{ $typeVariable->description }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.typeVariables.destroy', $typeVariable->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.typeVariables.show', [$typeVariable->id]) }}" class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.typeVariables.edit', [$typeVariable->id]) }}" class='btn btn-default btn-xs'>
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
