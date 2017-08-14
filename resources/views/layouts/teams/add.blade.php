<!-- Modal -->
<div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{$formDetails['title']}}</h4>
            </div>            
            <form method="POST" action="#" id="add_form">
                {{ csrf_field() }}                
                <div class="modal-body">
                    @foreach ($fields as $key => $field)
                        @if ($field['type'] == 'text')
                            <div class="form-group">
                                <label for="{{$key}}">{{$field['lable']}}</label>
                                <input type="text" class="form-control {{$field['class']}}" id="{{$field['id']}}" name="{{$key}}">
                            </div>
                        @elseif ($field['type'] == 'checkbox')
                            <div class="checkbox">
                                <label for="{{$key}}">
                                    <input type="checkbox" value="{{$field['def_value']}}" class="{{$field['class']}}" id="{{$field['id']}}" name="{{$key}}">
                                    {{$field['lable']}}
                                </label>
                            </div>
                        @elseif ($field['type'] == 'radio')
                        
                        @elseif ($field['type'] == 'select')
                        
                        @elseif ($field['type'] == 'textarea')
                        
                        @elseif ($field['type'] == 'password')
                        
                        @elseif ($field['type'] == 'hidden')
                            <input type="hidden" name="{{$key}}" value="{{$field['value']}}">
                        @else
                        
                        @endif
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>      
    </div>
</div>
