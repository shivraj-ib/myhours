<!-- Modal -->
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{$formDetails['title']}}</h4>
            </div>
            <form method="POST" action="" id="edit_form">
                {{ csrf_field() }}
                <div class="modal-body">
                    @foreach ($fields as $key => $field)
                        @if ($field['type'] == 'text')
                            <div class="form-group">
                                <label for="{{$key}}">{{$field['lable']}}</label>
                                <input type="text" class="form-control {{$field['class']}}" value="{{$field['value']}}" id="{{$field['id']}}" name="{{$key}}">
                            </div>
                        @elseif ($field['type'] == 'checkbox')                            
                            <div class="checkbox">
                                <label for="{{$key}}">
                                    <input type="checkbox" value="{{$field['def_value']}}" class="{{$field['class']}}" id="{{$field['id']}}" name="{{$key}}" @if($field['def_value'] == $field['value']) checked @endif>
                                    {{$field['lable']}}
                                </label>
                            </div>
                        @elseif ($field['type'] == 'checkbox-group') 
                        @isset($field['def_value'])
                            <label for="{{$key}}">{{$field['lable']}}</label><br>                            
                            @foreach($field['def_value'] as $options)
                                <label class="checkbox-inline"><input type="checkbox" class="{{$field['class']}}" name="{{$key}}[]" value="{{$options['value']}}" @isset($field['value']) @if(in_array($options['value'],$field['value'])) checked @endif @endisset>{{$options['lable']}}</label>
                            @endforeach 
                        @endisset    
                        @elseif ($field['type'] == 'radio')
                        
                        @elseif ($field['type'] == 'select')
                        @isset($field['def_value'])
                            <div class="form-group">
                                <label for="{{$key}}">{{$field['lable']}}</label>
                                <select class="form-control {{$field['class']}}" id="{{$field['id']}}" name="{{$key}}">>
                                    <option value="">Please select</option>
                                    @foreach($field['def_value'] as $options)
                                         <option value="{{$options['value']}}" @if(isset($field['value']) && $field['value'] == $options['value']) selected @endif>{{$options['lable']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endisset
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
