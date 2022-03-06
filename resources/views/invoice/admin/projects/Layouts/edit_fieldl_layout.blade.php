@if(isset($project->ProjectFields))
    <form class="AddFieldForm row col-12 EditFieldForm" style="padding: 15px" id="EditFieldForm{{$NewEditItem}}" action="#" method="POST">
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
    
        <div class="row col-12" >
            <div class="ring-sidebar__title">
                <span>{{$thisProjectField->settings->name}}</span>
            </div>
        </div>
        <div class="row col-12">
            <div class="col-auto d-flex align-items-center">
                <span>Default Value:</span>     
            </div>
            <div class="dropdown col-auto  form-group p-0 m-0">
                <button class=" btn-style btn  dropdown-toggle col-12 form-control default_button_update_{{$thisProjectField->id}}"id="task_helper_button_creat_{{$project->id}}_{{$thisProjectField->settings->name}}_add"   type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if($thisProjectField->Default !== NULL)
                        {{json_decode($thisProjectField->Default)->name}}
                    @else
                        {{'No Value'}}
                @endif
                </button>
                <div  style="margin: 0; "class="dropdown-menu  col-12 form-group  default_value{{$thisProjectField->id}}" aria-labelledby="task_helper_button_creat_{{$project->id}}_{{$thisProjectField->settings->name}}_add">
                    
                        @if($thisProjectField->EmptyOrNot == 1 && $thisProjectField->settings->properties !== '[]')
                            <div class="row novalue" style="padding-right: 15px; display:none">
                                <div  class="dropdown-item settingitem col-12 "   data-value="0"  data-update="Default" data-field-id="{{$thisProjectField->id}}">
                                        No Value
                                </div>
                            </div>
                        @elseif($thisProjectField->EmptyOrNot == 1)
                            <div class="row" style="padding-right: 15px;">
                                <p  class="settingitem col-12" >
                                No options found
                                </p>
                            </div>
                        @elseif($thisProjectField->settings->properties !== '[]')
                            <div class="row" style="padding-right: 15px;">
                                <div  class="dropdown-item settingitem col-12 novalue"   data-value="0"  data-update="Default" data-field-id="{{$thisProjectField->id}}">
                                        No Value
                                </div>
                            </div>
                        @else
                            <div class="row" style="padding-right: 15px;">
                                <p  class="settingitem col-12" >
                                    No options found
                                </p>
                            </div>
                        @endif
                    @if($thisProjectField->settings->properties !== '[]')
                        @foreach(json_decode($thisProjectField->settings->properties) as $j => $setProprtie)
                            <div class="row" style="padding-right: 15px;">
                                <div data-value="{{$setProprtie->id}}" data-update="Default" data-field-id="{{$thisProjectField->id}}"  class="dropdown-item settingitem col-12" >
                                    
                                    {{$setProprtie->name}}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="row col-12">
            <div class="col-auto">
                <span>Empty Value:</span>     
            </div>
            <div class="dropdown col-auto row  form-group p-0 m-0">
                <div class="row col-12 emptyBox">
                        @if($thisProjectField->EmptyOrNot == 1 && $thisProjectField->settings->properties !== '[]')
                            <button  class=" btn-style btn  dropdown-toggle col-12 form-control " style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Cannot be empty    
                            </button>
                        @elseif($thisProjectField->EmptyOrNot == 1)
                            <button class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Can be empty    
                            </button>
                        @elseif($thisProjectField->settings->properties !== '[]')
                            @if($thisProjectField->EmptyOrNot == 0 && $thisProjectField->EmptyValue == NULL)
                                    <div class="row col-12">
                                        {{'Not:'.$project->name}}
                                    </div>
                                
                                        <button id="emptyButton{{$NewEditItem}}" class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Can be empty    
                                        </button>
                                @else
                                    <div class="row col-12">
                                        {{$thisProjectField->EmptyValue}}
                                    </div>
                                
                                        <button id="emptyButton{{$NewEditItem}}" class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Can be empty    
                                        </button>
                            @endif
                        @else
                            @if($thisProjectField->EmptyOrNot == 0)
                                    <div class="row col-12">
                                        {{'Not:'.$project->name}}
                                    </div>
                                
                                        <button class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Can be empty    
                                        </button>
                                @else
                                    <div class="row col-12">
                                        {{$thisProjectField->EmptyValue}}
                                    </div>
                                
                                        <button class=" btn-style btn  dropdown-toggle col-12 form-control" style="text-align:left;"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Can be empty    
                                        </button>
                            @endif
                        @endif
                    <div  style="margin: 0; "class="dropdown-menu  col-12 form-group drop_set_style" aria-labelledby="task_helper_button_creat_{{$project->id}}_{{$thisProjectField->settings->name}}_add">
                        <div class="row" style="padding-right: 15px;">
                            <div  class="dropdown-item settingitem col-12"  data-value = '0' data-update='EmptyOrNot'  data-field-id = '{{$thisProjectField->id}}'>
                                Can be empty
                            </div>
                        </div>
                        <div class="row" style="padding-right: 15px;">
                            <div  class="dropdown-item settingitem col-12"  data-value = '1' data-update='EmptyOrNot' data-field-id = '{{$thisProjectField->id}}'>
                                Cannot be empty
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
        <hr class="col-10">
        <div class="row col-auto">
            <div class="col-auto">  
                <button type="button" class="btn btn-outline-primary btn-sm AddValue" id='AddValue{{$thisProjectField->id}}'  data-toggle="modal" data-target="#addMember"><span class="projects_count">Add Value</span></button>
            </div>
            <div class="modal fade modal-mini modal-primary" id="addMember" data-route="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Add Value</h4>  
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                        </div>
                        <div class="modal-body">
                            <div class="row col-12 m-1">
                                <span class="col-4">Name</span><input class="offset-1 col-7" id="NameOfSetting" type="text">
                            </div>
                            <div class="row col-12 m-1">
                                <span class="col-4">Description</span><textarea class="offset-1 col-7" type="text" id="DescriptionOfSetting" cols="30" rows="3"></textarea>
                            </div>
                            <div class="row col-12 m-1">
                                <span class="col-4">Color</span>
                                <input class="offset-1 col-7 SettingColor" id="ColorOfSetting" type="color" value="#ffffff">
                            </div>
                            <input data-field-project-id="{{$thisProjectField->id}}" id="FieldProjectId" type="hidden" >
                            <input data-field-id="{{$thisProjectField->settings->id}}" id="FieldId" type="hidden" >
                            <input data-field-creat="false" id="FieldCreatTrue" type="hidden" >
                        </div>
                        <div class="modal-footer justify-content-center">   
                            <button type="button" class="btn btn-success btn-sm SaveSettingInField" id='SaveSettingInField{{$thisProjectField->id}}' data-this-id="{{$NewEditItem}}" data-field-name="{{$thisProjectField->settings->name}}" >save</button>
                            <button type="button" class="btn btn-link close"  data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-auto" >
            <div class="col-12">
                <div class="dropdown">
                <button class="btn-outline-primary btn-sm dropdown-toggle  SetFileds" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Copy values from
                    </button>
            
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if(isset($ProjectFields))
                            @foreach($ProjectFields as $ProjectField)
                            <li class="dropdown-item fild_true field_open_copy{{$NewEditItem}}"data-add-remove="true" data-id="{{$ProjectField->setting_id}}" data-name="{{$ProjectField->settings->name}}" data-creat="true" data-setting-id="{{$thisProjectField->settings->id}}">
                                    <span>{{$ProjectField->settings->name}}
                                    </span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span style="color: #0000008c;">
                                    {{$ProjectField->projects->name}}
                                    </span>
                            </li>  
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="row col-12 fildsetiing setting_">
            @if($thisProjectField->settings->properties !== '[]')
                @foreach(json_decode($thisProjectField->settings->properties) as $j => $setProprtie)
                <div class="row col-10 SettingValuesBox">
                    <div class="SettingValues col-auto">
                        <div class="SpanOfValues value_edit_{{$thisProjectField->settings->id}}_{{$j}}" data-field-name='{{$thisProjectField->settings->name}}'data-field-id = '{{$thisProjectField->settings->id}}' data-project-id="{{$thisProjectField->id}}" data-color='{{$setProprtie->color}}' data-item-id='{{$j}}' id="value{{$thisProjectField->id}}{{$setProprtie->id}}" style="background-color:{{$setProprtie->color}};">{{$setProprtie->name}}
                        </div>
                    </div>
                    <div class="value_edit_box">
                        <button type="button" class="yt-primary-icon-action value_edit" data-item-id='{{$NewEditItem}}' data-field-id ='{{$thisProjectField->settings->id}}' data-item='{{$j}}' data-value='edit'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M14.55 4.6l-3.18-3.19a1.29 1.29 0 0 0-.88-.35 1.33 1.33 0 0 0-.94.39L2.28 8.72a1.29 1.29 0 0 0-.37.72L1 15l5.58-.93a1.29 1.29 0 0 0 .72-.37l7.26-7.26a1.31 1.31 0 0 0-.01-1.84zM10.2 2.78l3 3-6.26 6.32-3-3zM2.92 11.9l.26-1.59 2.5 2.5-1.57.26z"></path></svg></button>
                        &nbsp;&nbsp;
                        <button  type="button" class="yt-primary-icon-action value_edit"data-item-id='{{$NewEditItem}}'data-field-id ='{{$thisProjectField->settings->id}}' data-item='{{$j}}' data-value='remove'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M13.63 3.65l-1.28-1.27L8 6.73 3.64 2.38 2.37 3.65l4.35 4.36-4.34 4.34 1.27 1.28L8 9.28l4.35 4.36 1.28-1.28-4.36-4.35 4.36-4.36z"></path></svg></button>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </form>
@endif