@if (Route::currentRouteName() == 'hours' || Route::currentRouteName() == 'hours-list')
<div class="table-filter">
    <form class="form-inline">
        <div class="form-group">
            <label for="email">Filter By Activity Date From:</label>
            <input type="text" class="datepicker form-control" id="date_from" name="date_from">
        </div>
        <div class="form-group">
            <label for="email">To:</label>
            <input type="text" class="datepicker form-control" id="date_to" name="date_to">
        </div>        
        <button type="button" class="btn btn-default" id="reset-table">Reset</button>
    </form>
</div>
@endif
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
        @isset($teams)    
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
        @endisset
    </tbody>
</table>