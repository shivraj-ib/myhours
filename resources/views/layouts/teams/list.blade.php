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
            @if($key == 'active')
                 <td>@if($team->$key == 1) Active @else Inactive @endif</td>
               @else 
               <td>{{$team->$key}}</td>
            @endif                        
            @endforeach            
            <td>
                <a href="{{route($links['edit'],$team->id)}}" class="edit-item btn">
                    <span class="glyphicons glyphicons-edit">Edit</span>
                </a>
                <a href="{{route($links['delete'],$team->id)}}" class="delete-item btn">
                    <span class="glyphicons glyphicons-remove-sign">Delete</span>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>