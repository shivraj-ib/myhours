@extends('main')

@section('addition-assets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
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
            <th>Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Team Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td>1</td>
            <td>CMS1</td>
            <td>Active</td>
            <td>
                <a href="#" class="btn">
                    <span class="glyphicons glyphicons-edit">Edit</span>
                </a>
                <a href="#" class="btn">
                    <span class="glyphicons glyphicons-remove-sign">Delete</span>
                </a>
            </td>
        </tr>
    </tbody>
</table>
@endsection
