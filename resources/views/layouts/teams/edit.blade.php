<!-- Modal -->
<div class="modal fade" id="edit-team-modal" role="dialog">
    <div class="modal-dialog">    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Team</h4>
            </div>
            <div class="form-success"></div>
            <form method="POST" action="" id="edit_team_form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="team_name">Team Name</label>
                        <input type="text" class="form-control" id="team_name" name="team_name" value="{{$team->team_name}}">
                    </div>
                    <div class="checkbox">
                        <label for="active">
                            <input type="checkbox" value="1" id="active" name="active" @if($team->active == 1) checked @endif>Activiate Now
                        </label>
                    </div>                                   
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="{{route('update_team',$team->id)}}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>      
    </div>
</div>
