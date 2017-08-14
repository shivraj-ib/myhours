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
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">+ Add Team</button>
@include('layouts.teams.add')
<div id="confirm" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">    
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>    
<div class="list-container" data-route="{{route('teams-list')}}">
@include('layouts.teams.list')
</div>
@endsection
