<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Team</h4>
            </div>
            <form method="POST" action="#" id="add_team_form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="team_name">Team Name</label>
                        <input type="text" class="form-control" id="team_name" name="team_name">
                    </div>
                    <div class="checkbox">
                        <label for="active"><input type="checkbox" value="1" id="active" name="active">Activiate Now</label>
                    </div>                                   
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="{{route('add_team')}}">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>      
    </div>
</div>
