@extends('layouts.app')
@section('content')
<p>You are currently Viewing {{ Route::currentRouteName() }}</p>
@if($add_new === true)
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">{{$formDetails['title']}}</button>
@endif
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
<div class="list-container" data-route="{{$formDetails['list-route']}}">
    @include('layouts.teams.list')
</div>
@endsection
