@extends('main')

@section('addition-assets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="http://malsup.github.io/jquery.form.js"></script>
@endsection

@section('sidebar')
@parent    
@endsection

@section('content')
<p>You are currently Viewing {{ Route::currentRouteName() }}</p>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">+ Add Team</button>
@include('layouts.teams.add')
<table id="example" class="display" cellspacing="0" width="100%">
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
                <a href="{{route('edit_team',$team->id)}}" class="edit-team btn">
                    <span class="glyphicons glyphicons-edit">Edit</span>
                </a>
                <a href="{{route('delete_team',$team->id)}}" class="btn">
                    <span class="glyphicons glyphicons-remove-sign">Delete</span>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
