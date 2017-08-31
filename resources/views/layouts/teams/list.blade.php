@if (Route::currentRouteName() == 'hours' || Route::currentRouteName() == 'hours-list')
<div class="table-filter">
    <form class="form-inline" id="export_form" method="POST" action="{{route('export_hour',$user_id)}}">
        {{ csrf_field() }}  
        <div class="form-group">
            <label for="email">Filter By Activity Date From:</label>
            <input type="text" class="datepicker form-control" id="date_from" name="date_from">
        </div>
        <div class="form-group">
            <label for="email">To:</label>
            <input type="text" class="datepicker form-control" id="date_to" name="date_to">
        </div>        
        <button type="submit" class="btn btn-primary">Export</button>
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
                @foreach($links as $link)
                @if($link['active'] == 1)
                <a href="{{route($link['route_name'],$team->id)}}" class="{{$link['class']}}" title="{{$link['title']}}">
                    <i class="{{$link['icons']}}"></i>
                </a>
                @endif
                @endforeach                              
            </td>
        </tr>
        @endforeach
        @endisset
    </tbody>
</table>