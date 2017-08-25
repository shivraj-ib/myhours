    <div class="row">
        <div class="col-md-2">
            <div class="row">
                <div class="col-md-12">
                    <img class="user-avatar" src="@if(null !== $user->thumb) {{asset('storage/'.$user->thumb)}} @else {{asset('storage/avatar.png')}} @endif">
                </div>
                <div class="col-md-12 avatar-action-btn">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#profilePicModal">Upload</button>
                    <a class="btn btn-danger delete-item" href="{{route('del-profile-pic',$user->id)}}" class="delete-item btn">Remove</a>
                </div>
            </div>            
        </div>
        <div class="col-md-10">
            <div class="row">
            <div class="col-md-4 pull-right">
                <a href="{{route('edit-profile',$user->id)}}" class="btn btn-primary edit-item btn">
                    <span class="glyphicons glyphicons-edit">Edit</span>
                </a>
            </div>
            </div>    
            <div class="row">
                <div class="col-md-4 align-right">
                    <strong>Name</strong>
                </div>
                <div class="col-md-8">
                    {{$user->name}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 align-right">
                    <strong>Email</strong>
                </div>
                <div class="col-md-8">
                    {{$user->email}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 align-right">
                    <strong>Phone</strong>
                </div>
                <div class="col-md-8">
                    {{$user->phone}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 align-right">
                    <strong>Teams</strong>
                </div>
                <div class="col-md-8">
                    @php
                      if(isset($user->teams)){
                        $teams = '';
                        foreach($user->teams as $team){
                          $teams .= $team->team_name.", ";
                        }
                        echo trim($teams,", ");
                      }
                    @endphp
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 align-right">
                    <strong>Role</strong>
                </div>
                <div class="col-md-8">
                    @isset($user->role->role_name)
                    {{$user->role->role_name}}
                    @endisset
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 align-right">
                    <strong>Is Active ?</strong>
                </div>
                <div class="col-md-8">
                    @if($user->active == 1) Yes @else No @endif
                </div>
            </div>
        </div>
    </div>
