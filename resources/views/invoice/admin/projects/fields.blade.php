@extends('invoice._layouts.admin')
@section('page-name', 'Edit Project')

@section('styles')
    <link rel="stylesheet" href="{{ asset('invoices/admin/css/myStyle.css') }}">
    <style>
        .checkbox {
  --background: #fff;
  --border: #D1D6EE;
  --border-hover: #BBC1E1;
  --border-active: #1E2235;
  --tick: #fff;
  position: relative;
}
.checkbox input,
.checkbox svg {
  width: 21px;
  height: 21px;
  display: block;
}
.checkbox input {
  -webkit-appearance: none;
  -moz-appearance: none;
  position: relative;
  outline: none;
  background: var(--background);
  border: none;
  margin: 0;
  padding: 0;
  cursor: pointer;
  border-radius: 4px;
  transition: box-shadow 0.3s;
  box-shadow: inset 0 0 0 var(--s, 1px) var(--b, var(--border));
}
.checkbox input:hover {
  --s: 2px;
  --b: var(--border-hover);
}
.checkbox input:checked {
  --b: var(--border-active);
}
.checkbox svg {
  pointer-events: none;
  fill: none;
  stroke-width: 2px;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke: var(--stroke, var(--border-active));
  position: absolute;
  top: 0;
  left: 0;
  width: 21px;
  height: 21px;
  transform: scale(var(--scale, 1)) translateZ(0);
}
.checkbox.path input:checked {
  --s: 2px;
  transition-delay: 0.4s;
}
.checkbox.path input:checked + svg {
  --a: 16.1 86.12;
  --o: 102.22;
}
.checkbox.path svg {
  stroke-dasharray: var(--a, 86.12);
  stroke-dashoffset: var(--o, 86.12);
  transition: stroke-dasharray 0.6s, stroke-dashoffset 0.6s;
}
.checkbox.bounce {
  --stroke: var(--tick);
}
.checkbox.bounce input:checked {
  --s: 11px;
}
.checkbox.bounce input:checked + svg {
  animation: bounce 0.4s linear forwards 0.2s;
}
.checkbox.bounce svg {
  --scale: 0;
}

@keyframes bounce {
  50% {
    transform: scale(1.2);
  }
  75% {
    transform: scale(0.9);
  }
  100% {
    transform: scale(1);
  }
}
        .box_filds *{
            margin: 0;
            padding: 0;
        }
        .box_filds{
            height: max-content;
        }
        .box_filds, .box_filds_settings{
            border: 1px solid #0000004d;
            padding: 0;
        }
        
        .box_filds th{
            padding: 0!important;
            height: max-content;
        }
        .box_filds tr{
            margin: 0;
            width: 100%;
        }
        .box_filds p{
            margin: 0;
            font-size: 13px;
        }
        .btn-style{
            background: none!important;
            color: #0f5b99!important;
            box-shadow: none!important;
        }
        .toggle-on,.toggle-off{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .settingitem{
            cursor: pointer;
        }
        .ul-box-of-edit_buttons,.li-box-of-edit_buttons{
            list-style: none;
            display: flex;
        }
        .li-box-of-edit_buttons{
            margin-left:5px; 
        }
        svg{
            width: 15px;
        }
        .btn-edit{
            width: 100%;
            border: 0.6px solid  #0000004d;
        }
        .btn-group{
            margin: 0;
        }
        .btn{
            margin: 0;
        }
        .ring-sidebar__title {
            margin: 0;
            padding-left: 32px;
            color: #1f2326;
            color: var(--ring-heading-color);
            vertical-align: middle;
            font-size: 24px;
            font-weight: normal;
            line-height: 28px;
        }
        .form-control,.dropdown-item{
            cursor: pointer;
        }
        .dropdown-menu.show, .dropdown-menu.show > .inner.show{
            max-height: 250px!important;
            overflow-y:scroll;
            overflow-x:hidden; 
        }
        .box_filds_settings>.row>.row{
            margin: 10px;
        }
        textarea { 
        max-height: 150px!important;
        resize:vertical; 
        }
        .SettingColor{
            border: 0;
            padding: 0;
            outline: none;
        }
        .SettingValuesBox{
            padding: 5px;
        }
        .SettingValuesBox:hover{
            transition: 0.4s;
            background-color:#ebf6ff;
            cursor: pointer;
        }
        .SpanOfValues{
        color: black;
        padding: 5px;
        max-width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
        float: left;
        }
        .table-responsive {
            overflow:visible;
        }
        .dropbox1{
            max-height: 190px!important;
            overflow-y: auto;
        }
        .add_fild_tr{
            background-color: #ebf6ff;
            cursor: pointer;
        }
        .span_alert{
            border: 0.5px solid #00000073;
            padding: 3px;
            font-size: 10px;
            color: red;
            background-color: #ffffff;
            font-weight: bold;
        }
        svg{
            fill: #b8d1e5;
            transition: 0.2s;
        }
        svg:hover{
            fill: #ff008c;
            cursor: pointer;
        } 
        .yt-primary-icon-action{
            height: min-content;
            width: min-content;
            padding: 0;
            background-color: #0000;
            border: 0;
            outline: none!important;
        }
        .SettingValuesBox{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
       
        <div class="scrolling-wrapper btn-groupe">
            <a href="{{ route('invoice.admin.project_edit', ['id' => Request::route()->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0"><button class="card test btn "><p>Setting</p></button></a>
            <a href="{{ route('invoice.admin.project_team', ['id' => Request::route()->id]) }}" rel="tooltip" class="dropdown-item btn btn-info btn-link pl-0"><button class="card test btn"><p>Team</p></button></a>
            <a href="{{ route('invoice.admin.project_fields', ['id' => Request::route()->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0"><button class="card test btn active"><p>Fields</p></button></a>        
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon card-header-{{ $sidebar->filters }}">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Edit {{$project->name}} Fields
                        </h4>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row">
                            <ul class="btn-group-sm ul-box-of-edit_buttons">
                                <li class="li-box-of-edit_buttons">
                                    <button class="btn btn-primary add_fild" id="add_fild">
                                        <span>Add field to project</span>
                                    </button>  
                                    
                                </li>
                                <li class="li-box-of-edit_buttons">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary btn-edit ">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M14.55 4.6l-3.18-3.19a1.29 1.29 0 0 0-.88-.35 1.33 1.33 0 0 0-.94.39L2.28 8.72a1.29 1.29 0 0 0-.37.72L1 15l5.58-.93a1.29 1.29 0 0 0 .72-.37l7.26-7.26a1.31 1.31 0 0 0-.01-1.84zM10.2 2.78l3 3-6.26 6.32-3-3zM2.92 11.9l.26-1.59 2.5 2.5-1.57.26z"></path></svg>
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-edit btn-field-remove">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M10.86 13.27a.4.4 0 0 1-.39.33H5.53a.4.4 0 0 1-.39-.29L3.87 5H2.46l1.3 8.53A1.8 1.8 0 0 0 5.53 15h4.94a1.8 1.8 0 0 0 1.77-1.47L13.54 5h-1.41zM13.1 2.2H11A1.39 1.39 0 0 0 9.61 1H6.39A1.39 1.39 0 0 0 5 2.2H2.9a.9.9 0 0 0-.9.9V4h12v-.9a.9.9 0 0 0-.9-.9z"></path></svg>
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-edit">
                                            <span>Replace</span>
                                        </button>
                                      </div>
                                </li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-12" >
                                @csrf
                                <input type="hidden" name="old_logo" value="{{ $project->logo }}">
                                <div class="row">   
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 text-center box_filds">
                                        <div class="table-responsive">
                                            <table class="table align-items-center table-flush">
                                                <thead class="thead-light">
                                                <tr class="row">
                                                <th scope="col"  class="col-1"><p>#</p></th>
                                                <th scope="col"  class="col-3"><p>Field in Project</p></th>
                                                <th scope="col"  class="col-4">
                                                    <p>Default Value(s)</p>
                                                </th>
                                                <th scope="col" class="col-4"><p>Empty Value</p></th>
                                                </tr>
                                                </thead>
                                                <tbody class="list col-12 row" id="FieldsContent">
                                                    
                                                    @if(isset($ProjectFields)) 
                                                        @foreach($ProjectFields as $ProjectField)
                                                        @if($project ->id == $ProjectField->project_id) 
                                                            <tr  class="row FiledItem" data-make="edit" data-field-name = '{{$ProjectField->settings->name}}'data-field-id="{{$ProjectField->settings->id}}"  data-field-default-name="@if($ProjectField->Default !== NULL){{json_decode($ProjectField->Default)->name}}@else{{'null'}}@endif"
                                                                data-field-empty-value="{{$ProjectField->EmptyValue}}"data-field-empty="{{$ProjectField->EmptyOrNot}}" data-field-proprti="@if($ProjectField->settings->properties !== '[]'){{$ProjectField->settings->properties}}@else{{'null'}}@endif" data-field-project-id="{{$ProjectField->id}}">
                                                                <td scope="col"  class="col-1">
                                                                    <label class="checkbox path">
                                                                        <input type="checkbox" class="field-checkbox" data-value='{{$ProjectField->settings->id}}'>
                                                                        <svg viewBox="0 0 21 21">
                                                                            <path d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186"></path>
                                                                        </svg>
                                                                    </label>
                                                                </td>
                                                                <td scope="col"  class="col-3">
                                                                    <p>{{$ProjectField->settings->name}}</p> 
                                                                </td >
                                                                <td scope="col"  class="col-4">
                                                                    <div class="dropdown  form-group m-0">
                                                                        @forelse($TasksHelper as $i =>$this_setting)  
                                                                            @if($this_setting->id == $ProjectField->setting_id ) 
                                                                            @if(isset(json_decode($ProjectField->Default)->name))
                                                                                <button class=" btn-style btn  dropdown-toggle col-12 form-control default_button_update_{{$ProjectField->id}}"  id='task_helper_button_creat_{{$project->id}}_{{$this_setting->name}}' type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                {{json_decode($ProjectField->Default)->name}}    
                                                                                </button>
                                                                                @else
                                                                                <button class=" btn-style btn  dropdown-toggle col-12 form-control default_button_update_{{$ProjectField->id}}" id='task_helper_button_creat_{{$project->id}}_{{$this_setting->name}}'  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                   No Value    
                                                                                </button>
                                                                            @endif
                                                                            <div  style="margin: 0; "class="dropdown-menu dropbox1  col-12 form-group drop_set_style default_value{{$ProjectField->id}}" aria-labelledby="task_helper_button_creat_{{$project->id}}_{{$this_setting->name}}">
                                                                                
                                                                                <div class="row novalue" style="padding-right: 15px;
                                                                                @if($ProjectField->EmptyOrNot == 1 && isset($this_setting->properties)) 
                                                                                {{'display:none;'}}
                                                                                @endif
                                                                                ">
                                                                                    <div class="dropdown-item settingitem col-12 " data-value="0"  data-update="Default" data-field-id="{{$ProjectField->id}}"  >
                                                                                            No Value
                                                                                    </div>
                                                                                </div>  
                                                                                @if(isset($this_setting->properties))
                                                                                @forelse(json_decode($this_setting->properties) as $properti)
                                                                                <div class="row" style="padding-right: 15px;">
                                                                                    <div data-value="{{$properti->id}}" data-update="Default" data-field-id="{{$ProjectField->id}}" class="dropdown-item settingitem col-12" id="{{$this_setting->name}}_{{$i}}_{{$properti->id}}"  >
                                                                                            {{$properti->name}}
                                                                                    </div>
                                                                                </div>  
                                                                                    @empty
                                                                                @endforelse 
                                                                                @else
                                                                                <div class="row" style="padding-right: 15px;">
                                                                                    <p  class="settingitem col-12" >
                                                                                        No options found
                                                                                    </p>
                                                                                </div> 
                                                                                @endif
                                                                            </div>
                                                                            @endif
                                                                            @empty
                                                                            <div class="col-12">
                                                                                |empty|
                                                                            </div>
                                                                        @endforelse
                                                                    </div>
                                                                    {{-- <p style="background-color: {{json_decode($ProjectField->Default)->color}}">{{json_decode($ProjectField->Default)->name}}</p>  --}}
                                                                </td>
                                                                <td scope="col"  class="col-4 emptyBoxinTr_{{$ProjectField->id}}">
                                                                    @if($ProjectField->EmptyOrNot == '0' && $ProjectField->EmptyValue == NULL)
                                                                        {{'Not:'.$project->name}}
                                                                    @elseif($ProjectField->EmptyOrNot == '0' && $ProjectField->EmptyValue !== NULL) 
                                                                        {{"$ProjectField->EmptyValue"}}
                                                                    @else
                                                                        {{'Cannot be empty '}}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                   
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 box_filds_settings" id="filds_settings" tabindex='0'>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>  
    <input type="hidden" id="route" data-route-project-field-creat="{{ route('invoice.admin.project_fields_creat', ['id' => Request::route()->id]) }}"
                                    data-route-project-field-search="{{ route('invoice.admin.project_fields_search', ['id' => Request::route()->id]) }}">
    <input type="hidden" id="route_task" data-route-update="{{ route('invoice.admin.project_fields_update', ['id' => Request::route()->id]) }}"
                                        data-route-setting-add="{{ route('invoice.admin.setting_store') }}"
                                        data-route-delete="{{ route('invoice.admin.setting_field_delete') }}"
                                        data-route-setting-update="{{ route('invoice.admin.setting_update', ['id' => "#ID#"]) }}"
                                        data-route-setting-delete="{{ route('invoice.admin.setting_delete', ['id' => "#ID#"]) }}"
                                        data-route-setting-item="{{ route('invoice.admin.project_fields_items',['id' => Request::route()->id])}}">
@endsection
@section('scripts')
<script src="{{ asset('invoices/admin/js/plugins/bootstrap-notify.js') }}"></script>
<script src="{{ asset('invoices/admin/js/fieldScripts.js') }}"></script>

    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
@endsection


