<table id="data-table-list" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Team Name</th>
            <th>Status</th>            
            <th>Last Updated</th>
            <th>Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Team Name</th>
            <th>Status</th>
            <th>Last Updated</th>
            <th>Action</th>
        </tr>
    </tfoot>
    <tbody>        
        @foreach ($teams as $team)
        <tr>
            <td>{{$team->id}}</td>
            <td>{{$team->team_name}}</td>
            <td>@if($team->active == 1) Active @else Inactive @endif</td>
            <td>{{ $team->updated_at }}</td>
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