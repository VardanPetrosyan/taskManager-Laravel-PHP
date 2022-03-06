@extends('invoice._layouts.admin')
@section('page-name', 'Task Show')

@section('styles')
    <style>
        .card .card-header .add {
            border-radius: 50%;
            width: 40px;
            padding: 0;
            height: 40px;
            text-align: center;
            line-height: 40px;
        }
        .colorbox{
            text-align: center;
            border: 1px solid;
            margin: 4% 2%;
            color: white;
            font-size: larger;
            font-weight: 500;
            padding: 0;
            width: 24px;
            height: 24px;
            transition: all 1s ease 0s;
        }
        .settingname{
            align-self: center;
            padding: 0;
        }
        .settingitem,.useritem{
            cursor: pointer;
        }   
        .setting_content{
            flex-wrap: wrap-reverse
        }
        .btn-style{
           
            contain: content;
            transition: all 1s ease 0s;
            font-size: 13px;
            font-weight: 300;
            font-family: none;
        }
        .row{
            margin: 0;
        }
        .btn.btn-secondary:hover {
            background-color: #d7dede;;
            }
        .form-group{
            padding: 0;
        }
        button{
            cursor: pointer;
        }
        
    </style>
@endsection

@section('content')
@if($message = Session::get('success'))

    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="material-icons">close</i>
        </button>
        <span>{{ $message }}</span>
    </div>
@endif
    <div class="container-fluid">

        <div class="row">
            {{-- <div class="col-md-12 row d-flex justify-content-around">
                <div class="card card-profile col-12">
                    <div class="card-avatar">
                        <a href="javascript:;">
                            <img class="img" src="{{ asset($task->users->img) }}" />
                        </a>
                    </div>
                    <div class="card-body">
                        <div>
                            <h4 class="card-title">{{ $task->users->name }}</h4>
                            <p class="card-description">

                                {{ $task->task_number }}
                            </p>
                        </div>
                        <div>
                            
                        </div>
                    </div>
                </div>
                
            </div> --}}
            <div class="card col-12 " >
                <div class="d-flex justify-content-end card-header card-header-icon card-header-{{ $sidebar->filters }}">
                    <div>
                        <a href="javascript:;" class="text-white taskEditBtn">
                        <div class="card-icon add justify-content-center align-items-center" style="
                        display:flex;
                        margin:10px;
                        margin-bottom:0;
                        ">
                            <i class="material-icons">edit</i>
                        </div>
                    </a>
                    </div>
                </div>
                <div class="card-body ">
                    Project:
                    &nbsp;&nbsp;&nbsp;
                    <span>
                        <select class="selectpicker" data-style="select-with-transition" tabindex="-98" id="selectProject">
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" @if($project->id == $task->project_id) selected @endif>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </span>
                    <br>
                    Task 
                    <a href="#" ><span>{{ $task->task_number }}</span></a> 
                    Created by:
                    <span class="card-title">{{ $task->users->name }}</span>
                    In
                    <span>{{$task->created_at}}</span>
                    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                    @if(!empty($task->settings->toArray()))
                        @if($task->settings->last()->updated_at != $task->created_at)
                            Update by:
                            <span>{{$task->settings->last()->users->name}}</span>
                            In
                            <span>{{$task->settings->last()->updated_at}}</span>
                        @endif
                    @endif
                    <div class="col-md-12 row d-flex justify-content-around setting_content" >
                        <div class="col-12 d-flex justify-content-center">
                            <button type="button" class="btn btn-rose pull-right d-none updateTaskBtn">Update</button>  
                        </div>
                        <div class="card col-lg-7 col-md-12 col-sm-12">
                            <div class="card-header card-header-icon card-header-{{ $sidebar->filters }} d-flex justify-content-between align-items-center">
                                <div style="width: 200px;">
                                    <div class="card-icon">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">Task</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('invoice.admin.task_update', ['id' => $task->id]) }}" method="POST" id="editForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Title*</label>
                                                <input type="text" name="title" class="form-control" value="{{ $task->title }}" disabled required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Description*</label>
                                                <textarea name="description" class="form-control" disabled required>{{ $task->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Date*</label>
                                                <input name="date" class="form-control datepicker" value="{{ date_format(new DateTime($task->date), 'd/m/Y') }}" disabled required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Time*</label>
                                                <input name="time" class="form-control" value="{{ $task->time }}" id="spentTime" disabled required>
                                            </div>
                                        </div>
                                    </div>
                                   
                            </div>
                        </div>
                        <div class="card col-lg-4 col-md-12 col-sm-12">
                            <div class="card-header card-header-icon card-header-{{ $sidebar->filters }}">
                                <div class="card-icon" style="padding: 5px;">
                                    <i class="material-icons">build</i>
                                </div>
                                <h4 class="card-title">Settings</h4>
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 settingname" id="user">
                                        Users:
                                    </div>
                                    <div class="col-xs-9 col-lg-9 col-md-9 col-sm-9">
                                        <div class="dropdown  form-group">
                                           
                                            @if(count($task->taskUsers) > 0)
                                                    <button  class="btn btn-secondary dropdown-toggle btn-style  col-12 form-control top-0"  type="button" id="dropdownUser{{$users[0]->name}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        @foreach($task->taskUsers as $is_it)
                                                            @if($task->id == $is_it->task_id)
                                                            <span class="comma {{str_replace(' ', '_', $is_it->users->name)}}">
                                                            {{$is_it->users->name}}
                                                            </span>
                                                            @endif
                                                        @endforeach
                                                    </button>
                                                    
                                                    @else
                                                    <button class="btn btn-secondary dropdown-toggle   btn-style col-12 form-control"id="dropdownUser{{$users[0]->name}}" data-toggle="dropdown"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="Unassigned">
                                                            Unassigned
                                                        </span>
                                                    </button>
                                                @endif
                                            
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
                                               
                                            @forelse($task->projects->projectUsers as $i => $user)                                            
                                            <div value="" class="dropdown-item useritem d-flex p-1 row col-lg-12 col-md-11 col-sm-5 form-group" >
                                                <span class="col-1">
                                                    
                                                <input id="{{$user->id}}" type="checkbox" name="users[]"  data-user-name="{{$user->users->name}}"
                                                    @if(count($task->taskUsers) > 0)
                                                        @foreach($task->taskUsers as $task_)                                              
                                                            @if($task_->user_id == $user->users->id)
                                                            checked
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                value="{{$user->users->id}}" onclick="selectuser($(this),{{$task->id}},'{{$user->users->id}}')">
                                                </span>
                                                <label for="{{$user->id}}">
                                                <span class="col-5">
                                                {{$user->users->name}} 
                                                </span> 
                                                <span style="opacity: 0.6;" class="col-5">
                                                    {{$user->users->email}} 
                                                </span>
                                                </label>
                                            </div>
                                            @empty
                                                <p>empty</p>
                                            @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @forelse($task->projects->projectFields as $key => $value)
                                        <?php $setting = $value->settings ;
                                            $this_settings = $task->settings;
                                        ?> 
                                        @if(isset($setting))
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-3 settingname" id="user">
                                                {{$setting->name}}:
                                            </div>
                                            @if($setting->properties !== '[]')
                                                @if(count($task->settings)>$key)
                                                        <div class="col-xs-9 col-lg-9 col-md-9 col-sm-9 row p-0">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="dropdown  form-group ">
                                                                    @forelse($this_settings as $this_setting) 
                                                                        @if($this_setting->setting_id == $setting->id)  
                                                                            @if($this_setting->setting !== NULL)     
                                                                                <button  class=" btn-style btn btn-secondary dropdown-toggle col-12 form-control"id="task_helper_button_creat_{{$task->id}}_{{$setting->id}}"style="
                                                                                border-bottom: 5px solid; 
                                                                                border-color: {{json_decode($this_setting->setting)->color}};"   type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            
                                                                                {{json_decode($this_setting->setting)->name}}    
                                                                                </button>
                                                                            @else   
                                                                                @if($this_setting->setting == NULL && $this_setting->settings->projectFields[0]->EmptyOrNot == 1)
                                                                                    <button  class=" btn-style btn btn-secondary dropdown-toggle col-12 form-control"id="task_helper_button_creat_{{$task->id}}_{{$setting->id}}"style="
                                                                                        border-bottom: 5px solid; 
                                                                                        "   type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    
                                                                                            <span class="empty-danger">REQUIRED</span>  
                                                                                    </button>
                                                                                @elseif($this_setting->settings->projectFields[0]->EmptyValue == NULL)
                                                                                    <button  class=" btn-style btn btn-secondary dropdown-toggle col-12 form-control"id="task_helper_button_creat_{{$task->id}}_{{$setting->id}}"style="
                                                                                        border-bottom: 5px solid; 
                                                                                        "   type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    
                                                                                            NOT: {{$this_setting->name}}  
                                                                                    </button>
                                                                                
                                                                                @else 
                                                                                    <button  class=" btn-style btn btn-secondary dropdown-toggle col-12 form-control"id="task_helper_button_creat_{{$task->id}}_{{$setting->id}}"style="
                                                                                        border-bottom: 5px solid; 
                                                                                        "   type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            {{$this_setting->settings->projectFields[0]->EmptyValue}}    
                                                                                    </button>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @empty
                                                                        <div class="col-12">
                                                                            |empty|
                                                                        </div>
                                                                    @endforelse
                                                                
                                                                    <div id="dropbox" style="margin: 0; "class="dropdown-menu  col-12 form-group drop_set_style" aria-labelledby="task_helper_button_creat_{{$task->id}}_{{$setting->id}}">
                                                                        @if($setting->projectFields[0]->EmptyOrNot !== 1)
                                                                            @if($setting->projectFields[0]->EmptyValue == NULL)
                                                                                <div class="row" style="padding-right: 15px;">
                                                                                    <div  class="dropdown-item settingitem col-9" onclick="selectsetting($(this),{{$task->id}},'{{$setting->id}}')">
                                                                                        NOT: {{$this_setting->name}} 
                                                                                    </div>
                                                                                </div>  
                                                                            @else
                                                                                <div class="row" style="padding-right: 15px;">
                                                                                    <div  class="dropdown-item settingitem col-9"   onclick="selectsetting($(this),{{$task->id}},'{{$setting->id}}')">
                                                                                        {{$this_setting->settings->projectFields[0]->EmptyValue}}
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                        @forelse(json_decode($setting->properties) as $properti)
                                                                            <div class="row" style="padding-right: 15px;">
                                                                                <div  class="dropdown-item settingitem col-9" id="{{$properti->id}}"  onclick="selectsetting($(this),{{$task->id}},'{{$setting->id}}','{{$properti->color}}','{{strtoupper($properti->name[0])}}')">
                                                                                    {{$properti->name}}
                                                                                </div>
                                                                                <div  class="colorbox col " style="background-color: {{$properti->color}};">
                                                                                    {{strtoupper($properti->name[0])}}
                                                                                </div> 
                                                                            </div>  
                                                                        @empty
                                                                        <div class="row" >
                                                                            <div class="9" style="font-size: 15px;">No Options!</div>
                                                                        </div>
                                                                        @endforelse 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                @elseif(isset($task->projects->projectFields))
                                                        <div class="col-xs-9 col-lg-9 col-md-9 col-sm-9 row p-0">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="dropdown  form-group ">
                                                                    <button  class=" dropdown-toggle col-12 form-control"id="task_helper_button_creat_{{$task->id}}_{{$setting->id}}"
                                                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            No Set! 
                                                                    </button>
                                                                    <div id="dropbox" style="margin: 0; "class="dropdown-menu  col-12 form-group drop_set_style" aria-labelledby="task_helper_button_creat_{{$task->id}}_{{$setting->id}}">
                                                                        @if($setting->projectFields[0]->EmptyOrNot !== 1)
                                                                            @if($setting->projectFields[0]->EmptyValue == NULL)
                                                                                <div class="row" style="padding-right: 15px;">
                                                                                    <div  class="dropdown-item settingitem col-9" onclick="selectsetting($(this),{{$task->id}},'{{$setting->id}}')">
                                                                                        NOT: {{$setting->name}} 
                                                                                    </div>
                                                                                </div>  
                                                                            @else
                                                                                <div class="row" style="padding-right: 15px;">
                                                                                    <div  class="dropdown-item settingitem col-9"   onclick="selectsetting($(this),{{$task->id}},'{{$setting->id}}')">
                                                                                        {{$setting->settings->projectFields[0]->EmptyValue}}
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                        @forelse(json_decode($setting->properties) as $properti)
                                                                            <div class="row" style="padding-right: 15px;">
                                                                                <div  class="dropdown-item settingitem col-9" id="{{$properti->id}}"  onclick="selectsetting($(this),{{$task->id}},'{{$setting->id}}','{{$properti->color}}','{{strtoupper($properti->name[0])}}')">
                                                                                    {{$properti->name}}
                                                                                </div>
                                                                                <div  class="colorbox col " style="background-color: {{$properti->color}};">
                                                                                    {{strtoupper($properti->name[0])}}
                                                                                </div> 
                                                                            </div>  
                                                                        @empty
                                                                        <div class="row" >
                                                                            <div class="9" style="font-size: 15px;">No Options!</div>
                                                                        </div>
                                                                        @endforelse 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                @endif
                                            @endif
                                        </div>
                                        @else
                                    @endif
                                    @empty
                                    @endforelse

                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        </form>
            
    </div>
    <input type="hidden" id="route_task" data-route-update="{{ route('invoice.admin.task_update', ['id' => '#ID#']) }}">
    <input type="hidden" id="route" data-route-selectProject="{{ route('invoice.admin.task_select_project') }}">
    <input type="hidden" id="user_id" data-id="{{ $task->user_id }}">
@endsection

@section('scripts')
<script>
    function selectsetting(item,id,settingId,color,value){
        route = $('#route_task').data('route-update');
        route = route.replace('#ID#', id);
        $(`#task_helper_img_creat_${id}_${settingId}`).css({'background-color':color})
        $(`#task_helper_button_creat_${id}_${settingId}`).css({'border-color':color})
        $(`#task_helper_img_creat_${id}_${settingId}`).html(`<p>${value}</p>`)
        $(`#task_helper_button_creat_${id}_${settingId}`).html(item.html())
        $.ajax({
                    type: 'POST',
                    url:   route,
                    dataType: "json",
                    data: {task_id:id,setting:{[settingId]:item[0].id},_token:'{{csrf_token()}}'},
                    success:function(data) {
                        console.log(data)
                    }
                });
    }
    </script>
    <script>
        let task_id = "{{ $task->id }}";
    </script>
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
@endsection