<style>
    tr{
        padding: 0!important;
    }
    .clock{
        padding: 0;
       
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .edit,  .edit>*{
        display: inherit;
        justify-content: center;
        align-items: center;
    }
    .row{
        margin: 0;
    }
    .tasks_helper_img{
        padding: 0px 6px;
        background-color: red;
        border-radius: 3px;
        border: 0.5px solid;
        color: white;
        font-size: 20px;
        }
        .colorbox{
            text-align: center;
            color: #797070;
            font-size: larger;
            font-weight: 500;
            padding: 0;
            width: 24px;
            height: 24px;
            transition: all 0.6s ease 0s;
        }
        .dropdown-menu .dropdown-item:hover  .colorbox{
            color: #fff;
        }
        .settingname{
            align-self: center;
            padding: 0;
        }
        .settingitem,.settitem{
            cursor: pointer;
            margin: 0!important;
        }  
        .settitem{
            border: 0.5px solid #9c9696b3;
        } 
        .setting_content{
            flex-wrap: wrap-reverse
        }
        .dropdown-menu{
            background-color: #f2f2f2
        }
        .btn-style{
            contain: content;
            transition: all 1s ease 0s;
            font-size: 13px;
            font-weight: 300;
            font-family: none;
            border-radius: 0;
            height: 30px;
            border: 0;
        }
        .row{
            padding: 3px;
            margin: 0;
        }
        .btn-secondary{
            box-shadow:none;
            background-color: #0000;
        }
        .btn.btn-secondary:hover {
            background-color: #d7dede;
            }
        .form-group{
            padding: 0;
            margin: 0;
            width: 100%
        }
        
        /* .col-1 *{
            padding: 0!important;
        } */
        .task_td{
            padding: 2px 10px!important;
        }
        .task_title>div{
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
        }
        .row.col-12>div {
            display: flex;
            justify-content: center;
            align-items: start;
            padding: 0px 2px;
        }
        .imgbox{
            border-radius: 5px;
            width: auto;
            height: 25px;
            text-align: center;
            border: 1px solid;
            margin: 9% 2%;
            color: white;
            padding: 11px;
            transition: all 1s ease 0s;
        }
        .imgbox>p{
            position: absolute;
            top: 0px;
            left: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .settingname{
            align-self: center;
        }
        .settingitem,.useritem{
            cursor: pointer;
        }
        .task_tr:hover{
            background-color: #ebf6ff;
        }
        
        .task_tr{
            outline: none;
            transition: 0.1s
        }
        .task_check{
            display: none;
            height: 29px;
            width: 24px;
            justify-content: center;
            align-items: center;
        }
        .task_tr:hover .task_check{
            display: flex!important;
        }
        .task_tr:hover .task_set_img{
            display: none!important;
        }
        #howe_issues{
            opacity: 0;
            transition: 1s;
        }
        .delete_icon_btn{
            border-color: #c0c0c000!important;
            background-color: #0000!important;
            padding: 0!important;
            box-shadow: none!important;
            transition: 0.3s!important;
        }
        .material_delete{
            color:silver;
            transition: 0.3s
        }
        .material_delete:hover{
            color:black;
        }
        .badge {
            color:black!important;
        }
        .empty-danger{
            font-size: 10px;
            color: red;
            background-color: white;
            border: 0.5px solid #0000005c;
            padding: 1px;
        }
        .table-responsive{
            overflow:unset;
        }
        .dropdown-item{
            min-width: 6rem!important;
        }
        .comma:not(:first-child) {
  margin-left: -.3em;  
}

/* next 2 rules are for spacing when the first .comma is empty too */
.comma:first-child:empty ~ .comma:not(:empty) {
  margin-left: 0;  
}

.comma:first-child:empty ~ .comma:not(:empty) ~ .comma:not(:empty) {
  margin-left: -.3em;  
}

.comma:empty {
  display: none;
}

.comma:not(:first-child):before {
  content: "  ,  ";
}

.comma:not(:first-child):before {
  content: "  ,  ";
}

.comma:empty + .comma:not(:empty):before {
  content : "";
}

.comma:not(:empty) ~ .comma:empty + .comma:not(:empty):before {
  content : " , ";
}
</style>

<div class="card">
    <div class="card-header border-0 d-flex justify-content-between">
        {!! $tasks->appends(['search' => request()->search, 'projects' => request()->projects])->links() !!}
    </div>
    <div class="table-responsive">
        <table class="table align-items-center table-flush col-12 row">
            <thead class="thead-light col-12 row">
                <tr class="col-12 row">
                <th scope="col" width="150" class="col-8"><h4>Tasks</h4></th>
                <th scope="col" width="150" class="col-1 d-flex justify-content-end ">
                    <button class="removeBtnUser_test " style="display: none" type="reset" id="delete_task"></button>
                    <div class="card-icon add removeBtnUser disabled" id="removeBtnUser"  data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
                        <button class="btn btn-danger delete_icon_btn " disabled ><span class="material-icons material_delete">auto_delete</span></button>
                        @include('invoice._layouts.delete_confirm')
                    </div>
                </th>
                
                <th scope="col" width="100" class="col d-flex justify-content-end"><span id="howe_issues"> </span>&nbsp;<span id="issues">Matches {{count($tasks)}} issues</span> </th>
                </tr>
            </thead>
            <tbody class="list col-12 row">
                @if(count($projects)>0)
                    @forelse($tasks as $i =>$task)
                        <?php
                            $this_settings = [];
                            if (count($taskSetting) > 0)
                            {
                                foreach ($taskSetting as $key => $value)
                                {
                                    if ($value->task_id == $task->id)
                                    {
                                        $this_settings[] = $value;
                                    }
                                }
                            };
                        ?>  
                        <tr class="row col-12 task_tr" id="task_{{$task->id}}" tabindex="{{$i}}">
                            <td class="row col-12 task_td">
                                <div class="row col-12 task_title">
                                    <div scope="col-1">
                                        @forelse($this_settings as $this_setting)
                                            @if($this_setting->setting_id == $this_settings[0]->setting_id && json_decode($this_setting->setting) !== NULL)
                                                <div id="task_helper_img_creat_{{$task->id}}_{{$settings[0]->id}}" class="imgbox col-lg-1 col-md-1 col-sm-1 task_set_img task_{{$task->id}}_img" style="background-color: {{json_decode($this_setting->setting)->color}};">
                                                    <p>
                                                    {{strtoupper(json_decode($this_setting->setting)->name[0])}}
                                                    </p>
                                                    
                                                </div> 
                                                <div id="task_{{$task->id}}_check" class=" hidden task_check">
                                                    <input type="checkbox" class="img_content" value="{{$task->id}}" data-name="{{$task->task_number}}" id="task_{{$task->id}}_checkbox">
                                                </div>
                                                @elseif($this_setting->setting_id == $this_settings[0]->setting_id)
                                                <div class="imgbox col-lg-1 col-md-1 col-sm-1 task_set_img task_{{$task->id}}_img" style="color: black">
                                                    <p style="left:3px;">
                                                        N{{$i+1}}
                                                        </p> 
                                                </div>
                                                <div id="task_{{$task->id}}_check" class="task_check hidden " >
                                                    <input type="checkbox" class="img_content" data-name="{{$task->task_number}}" id="task_{{$task->id}}_checkbox" value="{{$task->id}}">
                                                </div>
                                            @endif
                                        @empty
                                            <div class="imgbox col-lg-1 col-md-1 col-sm-1 task_set_img task_{{$task->id}}_img" style="color: black">
                                            <p style="left:3px;">
                                                N{{$i+1}}
                                                </p> 
                                            </div>
                                            <div id="task_{{$task->id}}_check" class="task_check hidden " >
                                                <input type="checkbox" class="img_content" data-name="{{$task->task_number}}" id="task_{{$task->id}}_checkbox" value="{{$task->id}}">
                                            </div>
                                            
                                        @endforelse
                                    </div>
                                    <div class="col-1 justify-content-start ml-3">
                                        <a href="{{ route('invoice.admin.task_show', ['task' => $task->id]) }}">
                                        {{ $task->task_number }}
                                        </a>
                                    </div>
                                    <div class="col-8 justify-content-start ml-3" style="height: 50px">
                                        <a href="{{ route('invoice.admin.task_show', ['task' => $task->id]) }}">
                                        {{ $task->description }}
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-end row col" style="padding: 0;">
                                        <div class="col-8 clock">
                                            {{ $task->time }}
                                        </div>
                                        <div class="col-4 row edit">
                                        @if($task->user_id == \App\Helper\AuthHelper::user()->id)
                                            <div class="row col-12" data-toggle="tooltip" data-original-title="Edit product">
                                                            <a href="javascript:;" class="table-action editBtn"
                                                            data-id="{{ $task->id }}" data-toggle="modal" data-target="#modal-form">
                                                                <i class="fas fa-user-edit"></i>
                                                            </a>
                                                        </div>
                                            <form class="row col-12" action="{{ route('invoice.users.project_delete_task', ['id' => $task->id]) }}"
                                                method="post">
                                                @csrf
                                                    <span data-toggle="tooltip" data-original-title="Delete product">
                                                        <button type="button"
                                                                style="background: transparent; border: none; outline: none"
                                                                class="table-action table-action-delete"
                                                                data-toggle="sweet-alert" data-sweet-alert="success">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </span>
                                            </form>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-12">
                                    <div class="budget col-2">
                                        <div class="row col-12">
                                            <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
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
                                                    
                                                    
                                                    <div class="dropdown-menu  col-12 form-group drop_set_style" aria-labelledby="dropdownMenuButton" >
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
                                    </div>
                                    
                                    @forelse($task->projects->projectFields as $key => $value)
                                        <?php $setting = $value->settings ?> 
                                        @if(isset($setting))
                                            @if(count($task->settings)>$key)
                                                <div class="col-1">
                                                    <div class="row col-12">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="dropdown  form-group ">
                                                                @forelse($this_settings as $this_setting) 
                                                                    @if($this_setting->setting_id == $setting->id)  
                                                                        @if($this_setting->setting !== NULL)   
                                                                            <button class=" btn-style btn btn-secondary dropdown-toggle col-12 form-control"id="task_helper_button_creat_{{$task->id}}_{{$setting->id}}"style="
                                                                            border-bottom: 5px solid; 
                                                                            border-color: {{json_decode($this_setting->setting)->color}};"   type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        
                                                                            {{json_decode($this_setting->setting)->name}}    
                                                                            </button>
                                                                        @else   
                                                                            @if($this_setting->setting == NULL && $this_setting->settings->projectFields[0]->EmptyOrNot == 1)
                                                                                <button class=" btn-style btn btn-secondary dropdown-toggle col-12 form-control"id="task_helper_button_creat_{{$task->id}}_{{$setting->id}}"style="
                                                                                    border-bottom: 5px solid; 
                                                                                    "   type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                
                                                                                        <span class="empty-danger">REQUIRED</span>  
                                                                                </button>
                                                                            @elseif($this_setting->settings->projectFields[0]->EmptyValue == NULL)
                                                                                <button class=" btn-style btn btn-secondary dropdown-toggle col-12 form-control"id="task_helper_button_creat_{{$task->id}}_{{$setting->id}}"style="
                                                                                    border-bottom: 5px solid; 
                                                                                    "   type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                
                                                                                        NOT: {{$this_setting->name}}  
                                                                                </button>
                                                                            
                                                                            @else 
                                                                                <button class=" btn-style btn btn-secondary dropdown-toggle col-12 form-control"id="task_helper_button_creat_{{$task->id}}_{{$setting->id}}"style="
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
                                                                                    {{$setting->projectFields[0]->EmptyValue}}
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
                                                </div>
                                            @elseif(isset($task->projects->projectFields) )
                                                <div class="col-1">
                                                    <div class="row col-12">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="dropdown  form-group ">
                                                                <button class="btn-style dropdown-toggle col-12 form-control"id="task_helper_button_creat_{{$task->id}}_{{$setting->id}}"
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
                                                                                    {{$setting->projectFields[0]->EmptyValue}}
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
                                                </div>
                                            @endif
                                        @else
                                        <div class="col-1 ">
                                            |empty|
                                        </div>
                                    @endif
                                    @empty
                                    Empty
                                    @endforelse
                                    @if(count($settings)>0) 
                                    @for($i = 0; $i< 6-count($settings); $i++)
                                    <div class="col-1 ">
                                        |empty|
                                    </div>
                                    @endfor
                                    @endif
                                    
                                    <div class="budget col">
                                        {{ $task->users->name }}
                                    </div>
                                    <div class="col-2">
                                        <span class="badge badge-dot mr-4">
                                            <span class="status">{{ date_format(new DateTime($task->date), 'd/m/Y') }}</span>
                                        </span>
                                    </div>
                                </div>  
                            </td>
                        </tr>

                    @empty
                    <tr>
                        <div colspan="6"><h2>There is nothing to show</h2></div>
                    </tr>
                @endforelse
                @else
                <tr>
                    <td>
                        You have no projects!!
                    </td>
                </tr>
                
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
     aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-secondary border-0 mb-0">
                    <div class="card-header bg-transparent">
                        <div class="text-muted text-center mt-2"><small>Create Task</small>
                        </div>
                    </div>
                    <div class="card-body  px-lg-5 py-lg-5">
                        <form class="needs-validation" id="form" novalidate
                              action="{{ route('invoice.users.project_create_task')}}"
                              method="POST">
                            @csrf
                            <input type="hidden" value="{{ request()->projects }}" id="project_id" name="project_id">
                            <input type="hidden"
                                   value="{{ \App\Helper\AuthHelper::user()->id }}"
                                   name="user_id">
                            <div class="form-row text-left">
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label" for="validationCustom01">Task
                                        number</label>
                                    <input type="text" name="task_number" class="form-control"
                                           id="validationCustom01" placeholder="Task number"
                                           required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter task number.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label" for="validationCustom02">Task
                                        title</label>
                                    <input type="text" name="task_title" class="form-control"
                                           id="validationCustom02" placeholder="Task title"
                                           required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter task title.
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-control-label"
                                           for="validationCustomUsername">Description</label>
                                    <textarea name="description" id="validationCustomUsername"
                                              class="form-control" resize="none"></textarea>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="form-row text-left">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                               for="exampleDatepicker">Date</label>
                                        <input class="form-control datepicker" name="date"
                                               id="exampleDatepicker" placeholder="Enter date"
                                               type="text" data-date-format="dd/mm/yyyy"
                                               value="{{ date('d/m/Y') }}" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please enter date.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                               for="exampleTime">Time</label>
                                        <input class="form-control" name="time"
                                               placeholder="Enter time" id="exampleTime"
                                               type="text" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please enter date.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary" id="modalBtn" type="button">Add
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div data-notify="container" class="col-11 col-md-2 alert alert-success alert-with-icon animated" id="success" role="alert" data-notify-position="bottom-right" style="display: none; margin: 15px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1031; bottom: 20px; right: 20px;"><button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 50%; margin-top: -9px; z-index: 1033;"><i class="material-icons">close</i></button><i data-notify="icon" class="material-icons">add_alert</i><span data-notify="title"></span> <span data-notify="message">Task deleted successfully!</span><a href="#" target="_blank" data-notify="url"></a></div>
<input type="hidden" id="route_task" data-route-update="{{ route('invoice.admin.task_update', ['id' => '#ID#']) }}"
                                     data-route-remove="{{ route('invoice.admin.task_remove')}}">
