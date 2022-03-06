@extends('invoice._layouts.admin')
@section('page-name', 'New Task')
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
            margin: 4%;
            color: white;
            font-size: larger;
            font-weight: 500;
            padding: 0;
            transition: all 1s ease 0s;
        }
        .settingname{
            padding: 0;
            align-self: center;
        }
        .settingitem,.useritem{
            cursor: pointer;
        }
        .btn-style{
            transition: all 1s ease 0s;
            padding: 10px 8px;
            contain: content;
            height: 42px;
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
        .empty-danger{
            font-size: 10px;
            color: red;
            background-color: white;
            border: 0.5px solid #0000005c;
            padding: 1px;
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
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-5 col-5">
                    <select class="selectpicker" id="newTaskBtn"  data-size="4" data-style="btn btn-primary btn-round everythingBtn" >
                        {{-- <option value="0">Select Project</option> --}}
                        @forelse($projects as $project)
                        <option value="{{ $project->id }}" data-setting-id="{{$project->id}}" @if($proj_id == $project->id) selected @endif>{{ $project->name }}</option>
                        @endforeach
                    </select>
                    <span class="req_span" style="color: red; display: none;">Required</span>
            </div>
            <script>
                $(document).ready(function(){
                    $('#newTaskBtn').val(false).trigger( "change" );
                })
            </script>
        </div>
        <form action="{{ route('invoice.admin.task_store') }}" method="POST"  id="editForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-8 col-md-7 col-sm-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-{{ $sidebar->filters }}">
                            <div class="card-icon">
                                <i class="material-icons">wysiwyg</i>
                            </div>
                            <h4 class="card-title">New Task</h4>
                        </div>
                        <div class="card-body">
                                @csrf
                                <input type="hidden" name="project_id" class="project_id" value="{{ $proj_id }}">
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Task Number*</label>
                                            <input type="text" name="task_number" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Title*</label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Description*</label>
                                            <textarea name="description" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Date*</label>
                                            <input name="date" class="form-control datepicker" value="{{ date('d').'/'.date('m').'/'.date('Y') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group row">
                                            <label class="bmd-label-floating " for="spentTime">Spent Time*  <span class="standard" style="display: none; color: red;">Standard` 1h:1m, 1h, 1m</span></label>
                                            <input name="time" type="text" class="form-control"  id="spentTime" required>
                                        </div>
                                    </div>
                                    <script>
                                       
                                    </script>
                                </div>
                                <button type="button" class="btn btn-{{ $sidebar->filters }} pull-right addTaskBtn">Add Task</button>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 col-sm-12">
                    <div class="card">
                        <div class="card-header card-header-icon card-header-{{ $sidebar->filters }}">
                            <div class="card-icon" style="padding: 5px;">
                                <i class="material-icons">build</i>
                            </div>
                            <h4 class="card-title">Settings</h4>
                        </div>
                        <div class="card-body setting">
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<input type="hidden" name="route" id="route" value="{{route('invoice.admin.task_create_post')}}">
@endsection

@section('scripts')
    <script>
        
       $('.selectpicker').on('change',function(){
        let route = $('#route').val();
        let id =$(this).children("option:selected").val();
        let userText ='';
        let  text = '';
        $.ajax({
            type: "POST",
            url: route,
            data: {id:id,post:true,_token:'{{csrf_token()}}'},
            success: function(data) {
                if(data){
                    $('.setting').html('')

                    console.log(data)
                    if(data.Users){
                    userText += `<div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 settingname" id="user">
                                    Users:
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9  ">
                                    <div class="dropdown  ">
                                        <button style="contain: content;" class="btn btn-secondary dropdown-toggle col-12"  type="button" id="dropdownUser{{$users[0]->name}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        
                                            <span class="Unassigned">
                                                Unassigned
                                            </span>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 200%">
                                        ` 
                                        for(let i= 0 ;i<data.Users.length;i++){
                                            userText +=  ` 
                                                    <div  class="dropdown-item useritem d-flex p-1 row col-12">
                                                            <span class="col-1">
                                                            <input data-user-name="${data.Users[i].name}" class="user_id" type="checkbox" name="users[]" value="${data.Users[i].id}">
                                                            </span>
                                                            <span class="col-5">
                                                            ${data.Users[i].name}
                                                            </span> 
                                                            <span style="opacity: 0.6;" class="col-5">
                                                                ${data.Users[i].email}
                                                            </span>
                                                    </div>`
                                           
                                        }
                            userText += `</div>
                                    </div>
                                </div>
                            </div>`
                        $('.setting').append(userText)
                        }
                    if(data.projfields.length>0){
                        for(let i =0;i<data.projfields.length;i++){
                        if(JSON.parse(data.projfields[i].settings.properties).length>0){
                            text +=` <div class="row setfield_div">
                                        <div class="col-lg-3 col-md-3 col-sm-3 settingname" id="${data.projfields[i].settings.id}">
                                            ${data.projfields[i].settings.name}:
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <div class="dropdown  ">
                                        ` 
                            if(data.projfields[i].Default == null && data.projfields[i].EmptyOrNot !== 1){
                                console.log(data.projfields[i]);
                                
                                if(data.projfields[i].EmptyOrNot == 0 && data.projfields[i].EmptyValue == null){
                                    text +=    `<button  class="  btn  btn-secondary btn-style dropdown-toggle col-12" type="button" id="dropdownSetting${data.projfields[i].settings.name}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Not:${data.projfields[i].settings.name}   
                                                </button>
                                                <div class="dropdown-menu control" aria-labelledby="dropdownMenuButton">
                                            `  
                                    text += `   <div class="row" >
                                                    <label for="${data.projfields[i].settings.name}n0" class="dropdown-item settingitem col-9" value="" >
                                                    <div >
                                                        Not:${data.projfields[i].settings.name} 
                                                    </div>
                                                    </label>
                                                </div>  
                                                <input type="radio" class="d-none form-control" 
                                                id="${data.projfields[i].settings.name}n0" name="setting[${data.projfields[i].settings.id}]" value="null" checked>
                                                `
                                }else{

                                    text +=    `<button  class="  btn  btn-secondary btn-style dropdown-toggle col-12" type="button" id="dropdownSetting${data.projfields[i].settings.name}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ${data.projfields[i].EmptyValue}   
                                                </button>
                                                <div class="dropdown-menu control" aria-labelledby="dropdownMenuButton">
                                            `  
                                    text += `   
                                            <div class="row" >
                                            <label for="${data.projfields[i].settings.name}n0" class="dropdown-item settingitem col-9" value="" >
                                            <div >
                                                ${data.projfields[i].EmptyValue}   
                                            </div>
                                            </label>
                                        </div>  
                                        <input type="radio" class="d-none form-control" 
                                        id="${data.projfields[i].settings.name}n0" name="setting[${data.projfields[i].settings.id}]" value="null" checked>
                                        `
                                }
                                
                            }else if(data.projfields[i].Default == null && data.projfields[i].EmptyOrNot == 1){
                                if(data.projfields[i].EmptyValue == null){
                                    text +=    `<button  class="  btn  btn-secondary btn-style dropdown-toggle col-12" type="button" id="dropdownSetting${data.projfields[i].settings.name}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Not:${data.projfields[i].settings.name}   
                                                </button>
                                                <div class="dropdown-menu control" aria-labelledby="dropdownMenuButton">
                                            `  
                                }else{

                                    text +=    `<button  class="  btn  btn-secondary btn-style dropdown-toggle col-12" type="button" id="dropdownSetting${data.projfields[i].settings.name}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ${data.projfields[i].EmptyValue}:<span class="empty-danger">Required</span>
                                                </button>
                                                <div class="dropdown-menu control" aria-labelledby="dropdownMenuButton">
                                            `  
                                } 
                            }else {
                                text +=    `<button  class="  btn  btn-secondary btn-style dropdown-toggle col-12" type="button" id="dropdownSetting${data.projfields[i].settings.name}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        ${JSON.parse(data.projfields[i].Default).name}   
                                            </button>
                                            <div class="dropdown-menu control" aria-labelledby="dropdownMenuButton">
                                            `  
                            }
                                for(let j = 0;j<JSON.parse(data.projfields[i].settings.properties).length;j++){
                                    text += `   
                                                <div class="row" >
                                                    <label for="${data.projfields[i].settings.name}n${JSON.parse(data.projfields[i].settings.properties)[j].id}" class="dropdown-item settingitem col-9" value=""  onclick="selectsetting($(this),'${data.projfields[i].settings.name}','${JSON.parse(data.projfields[i].settings.properties)[j].color}','${JSON.parse(data.projfields[i].settings.properties)[j].name[0].toUpperCase()}')">
                                                    <div >
                                                        ${JSON.parse(data.projfields[i].settings.properties)[j].name}
                                                    </div>
                                                    </label>
                                                    <div  class="colorbox col " style="background-color:${JSON.parse(data.projfields[i].settings.properties)[j].color};">
                                                        ${JSON.parse(data.projfields[i].settings.properties)[j].name[0].toUpperCase()}
                                                    </div> 
                                                </div>  
                                            `;
                                            if(data.projfields[i].Default !== null){
                                                if(JSON.parse(data.projfields[i].settings.properties)[j].id == JSON.parse(data.projfields[i].Default).id ){
                                                    text += `<input type="radio" class="d-none form-control" 
                                                            id="${data.projfields[i].settings.name}n${JSON.parse(data.projfields[i].settings.properties)[j].id}" name="setting[${data.projfields[i].settings.id}]" value="${JSON.parse(data.projfields[i].settings.properties)[j].id}" checked>
                                                        `;
                                                }else{
                                                text += `<input type="radio" class="d-none form-control" 
                                                        id="${data.projfields[i].settings.name}n${JSON.parse(data.projfields[i].settings.properties)[j].id}" name="setting[${data.projfields[i].settings.id}]" value="${JSON.parse(data.projfields[i].settings.properties)[j].id}">
                                                    `;
                                                }
                                            }else{
                                                text += `<input type="radio" class="d-none form-control" 
                                                        id="${data.projfields[i].settings.name}n${JSON.parse(data.projfields[i].settings.properties)[j].id}" name="setting[${data.projfields[i].settings.id}]" value="${JSON.parse(data.projfields[i].settings.properties)[j].id}">
                                                    `;
                                            }
                                }
                                            
                                        text += `</div>
                                            <span class="d-none">This Item Cannot Be Empty</span>

                                        </div>
                                    </div>
                                    
                                </div>
                                `;
                                
                        }
                        $('.setfield_div').remove()
                        $('.setting').append(text)
                        }
                    }
                    
                }
            }
        })
       })
    </script>
    
    <script>
        function selectsetting(item,name,color,value){
            
            $(`#task_helper_img_creat_${name}`).css({'background-color':color})
            $(`#task_helper_img_creat_${name}`).html(value)
            $(`#dropdownSetting${name}`).html(item.html())
        }
    </script>
    <script>
        md.initFormExtendedDatetimepickers();
    </script>
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
@endsection