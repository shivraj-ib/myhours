@extends('layouts.app')
@section('content')
<div class="container list-container" data-route="{{route('profile-details',$user->id)}}">
    <h1>Profile</h1>
    @include('auth.profile-details')
</div>
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
<!-- Modal profile pic uploda -->
<div class="modal fade" id="profilePicModal" role="dialog">
    <div class="modal-dialog">    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload Profile Picture</h4>
            </div>
            <form method="POST" action="" id="upload_profile_pic" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="usr">Upload Image:</label>
                        <input type="file" name="thumb" class="form-control" id="thumb">
                    </div>                           
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="{{route('add-profile-pic',$user->id)}}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>      
    </div>
</div>
@endsection
