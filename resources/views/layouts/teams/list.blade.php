<table id="data-table-list" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            @foreach ($columns as $column)
            <th>{{$column}}</th>            
            @endforeach
            <th>Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            @foreach ($columns as $column)
            <th>{{$column}}</th>            
            @endforeach
            <th>Action</th>
        </tr>
    </tfoot>
    <tbody>        
        @foreach ($teams as $team)
        <tr>
            @foreach ($columns as $key => $column)
            <td>{{$team->$key}}</td>            
            @endforeach            
            <td>
                <a href="{{route('edit_team',$team->id)}}" class="edit-item btn">
                    <span class="glyphicons glyphicons-edit">Edit</span>
                </a>
                <a href="{{route('delete_team',$team->id)}}" title="{{$team->team_name}}" class="delete-item btn">
                    <span class="glyphicons glyphicons-remove-sign">Delete</span>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>