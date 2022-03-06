<!DOCTYPE html>
<html lang="en" class="{{ $sidebar->filters }}">
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('invoices/images/logo.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('invoices/images/logo.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Office</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport'/>
    <!-- Extra details for Live View on GitHub Pages -->
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('invoices/admin/css/material-dashboard.min.css') }}" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;
    
        var pusher = new Pusher('65ecbb864034865ef567', {
        cluster: 'ap2'
         });
    
        var channel = pusher.subscribe('my-channel');
        channel.bind('StatusEdit', function(data) {
            let updataData = JSON.parse(JSON.parse(JSON.stringify(data)).send)
        if(updataData.update == "status"){
            if(updataData.data.setting != undefined){
                $(`#task_helper_img_creat_${updataData.data.task_id}_${updataData.data.setting_id}`).css({'background-color':JSON.parse(updataData.data.setting).color})
                $(`#task_helper_button_creat_${updataData.data.task_id}_${updataData.data.setting_id}`).css({'border-color':JSON.parse(updataData.data.setting).color})
                $(`#task_helper_img_creat_${updataData.data.task_id}_${updataData.data.setting_id}`).html(`<p>${JSON.parse(updataData.data.setting).name}</p>`)
                $(`#task_helper_button_creat_${updataData.data.task_id}_${updataData.data.setting_id}`).html(JSON.parse(updataData.data.setting).name)
            }else{
                $(`#task_helper_img_creat_${updataData.data.task_id}_${updataData.data.setting_id}`).css({'background-color':'black'})
                $(`#task_helper_button_creat_${updataData.data.task_id}_${updataData.data.setting_id}`).css({'border-color':'black'})
                $(`#task_helper_img_creat_${updataData.data.task_id}_${updataData.data.setting_id}`).html(`<p>R</p>`)
                $(`#task_helper_button_creat_${updataData.data.task_id}_${updataData.data.setting_id}`).html('relode')
            }
            
        }
        });
    </script>
    <style>
        .dropdown-menu.show,
        .dropdown-menu.show > .inner.show{
            max-height: 400px!important;
        }
        .fixed-plugin a.rotation i{
            animation: rotation 3s infinite linear;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
        .scrolling-wrapper {
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
        padding: 0px 85px;
        display: flex;
        justify-content: flex-start;
        width: max-content;
        height: max-content;
    
        }
        .test {
        display: inline-block;
            width: 100px;
            height: 40px;
            margin: 10px 5px;
            text-align: center;
            
        }
        .test:hover{
            background-color: #de2567;
        }
        .test:active{
            background-color: #de2567;
        }
        .scrolling-wrapper.btn-groupe>a{
            
            padding: 0;
            margin: 0;
            width: max-content;
            height: max-content;
        }
        .scrolling-wrapper.btn-groupe>a>button{
            border-radius: 0;
            margin: 0;
            box-shadow: none;
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
    @yield('styles')
</head>

<body class="@if($sidebar->mini == 'true') sidebar-mini @endif">
<div class="wrapper ">
    <div class="sidebar" data-color="{{ $sidebar->filters }}" data-background-color="{{ $sidebar->background }}"
         @if($sidebar->is_image == 'true') data-image="{{ asset($sidebar->image) }}" @endif data-ref-img="{{ asset($sidebar->image) }}">
        <div class="logo">
            <a href="{{ route('invoice.admin.dashboard') }}" class="simple-text logo-mini">
                BO
            </a>
            <a href="{{ route('invoice.admin.dashboard') }}" class="simple-text logo-normal">
                Office
            </a>
        </div>
        <div class="sidebar-wrapper">
            <div class="user">
                <div class="photo">

                    <img src="{{ asset(\App\Helper\AuthHelper::user()->img) }}"/>
                </div>
                <div class="user-info">
                    <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                {{ \App\Helper\AuthHelper::user()->name }}
                <b class="caret"></b>
              </span>
                    </a>
                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('invoice.admin.users_edit', ['id' => \App\Helper\AuthHelper::user()->id]) }}">
                                    <span class="sidebar-mini"> MP </span>
                                    <span class="sidebar-normal"> My Profile </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('invoice.admin.settings') }}">
                                    <span class="sidebar-mini"> S </span>
                                    <span class="sidebar-normal"> Settings </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item @if(request()->is('invoice/admin')) active @endif ">
                    <a class="nav-link" href="{{ route('invoice.admin.dashboard') }}">
                        <i class="material-icons">dashboard</i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#tasks" aria-expanded="@if(request()->is('invoice/admin/tasks*'))true @else false @endif">
                        <i class="material-icons">text_snippet</i>
                        <p> Tasks
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if(request()->is('invoice/admin/tasks*')) show @endif" id="tasks">
                        <ul class="nav">
                            <li class="nav-item @if(request()->is('invoice/admin/tasks')) active @endif">
                                <a class="nav-link"  href="{{ route('invoice.admin.task')}}">
                                    <span class="sidebar-mini"> AT </span>
                                    <span class="sidebar-normal"> All Tasks </span>
                                </a>
                            </li>
                            <li class="nav-item @if(request()->is('invoice/admin/tasks/create')) active @endif">
                                <a class="nav-link" href="{{ route('invoice.admin.task_create') }}">
                                    <span class="sidebar-mini"> CT </span>
                                    <span class="sidebar-normal"> Create Tasks </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#project" aria-expanded="@if(request()->is('invoice/admin/project*'))true @else false @endif">
                        <i class="material-icons">work_outline</i>
                        <p> Projects
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if(request()->is('invoice/admin/project*')) show @endif" id="project">
                        <ul class="nav">
                            <li class="nav-item @if(request()->is('invoice/admin/project')) active @endif">
                                <a class="nav-link"  href="{{ route('invoice.admin.project')}}">
                                    <span class="sidebar-mini"> AP </span>
                                    <span class="sidebar-normal"> All Projects </span>
                                </a>
                            </li>
                            <li class="nav-item @if(request()->is('invoice/admin/project/create')) active @endif">
                                <a class="nav-link" href="{{ route('invoice.admin.project_create') }}">
                                    <span class="sidebar-mini"> CP </span>
                                    <span class="sidebar-normal"> Create Projects </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="@if(request()->is('invoice/admin/users*'))true @else false @endif">
                        <i class="material-icons">people</i>
                        <p> Users
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if(request()->is('invoice/admin/users*')) show @endif" id="users">
                        <ul class="nav">
                            <li class="nav-item @if(request()->is('invoice/admin/users')) active @endif">
                                <a class="nav-link"  href="{{ route('invoice.admin.users')}}">
                                    <span class="sidebar-mini"> AU </span>
                                    <span class="sidebar-normal"> All Users </span>
                                </a>
                            </li>
                            <li class="nav-item @if(request()->is('invoice/admin/users/create')) active @endif">
                                <a class="nav-link" href="{{ route('invoice.admin.users_create') }}">
                                    <span class="sidebar-mini"> CU </span>
                                    <span class="sidebar-normal"> Create Users </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item @if(request()->is('invoice/admin/reports')) active @endif ">
                    <a class="nav-link" href="{{ route('invoice.admin.reports') }}">
                        <i class="material-icons">article</i>
                        <p> Reports </p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('invoice/admin/currency')) active @endif ">
                    <a class="nav-link" href="{{ route('invoice.admin.currency') }}">
                        <i class="material-icons">euro</i>
                        <p> Currency </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#setings" aria-expanded="@if(request()->is('invoice/admin/settings*'))true @else false @endif">
                        <i class="material-icons">build</i>
                        <p> Settings
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if(request()->is('invoice/admin/settings*')) show @endif" id="setings">
                        <ul class="nav">
                            <li class="nav-item @if(request()->is('invoice/admin/settings')) active @endif">
                                <a class="nav-link"  href="{{ route('invoice.admin.settings')}}">
                                    <span class="sidebar-mini"> AS </span>
                                    <span class="sidebar-normal"> All Settings </span>
                                </a>
                            </li>
                            <li class="nav-item @if(request()->is('invoice/admin/settings/create')) active @endif">
                                <a class="nav-link" href="{{ route('invoice.admin.setting_create') }}">
                                    <span class="sidebar-mini"> CS </span>
                                    <span class="sidebar-normal"> Create Setting </span>
                                </a>
                            </li>
                            {{-- <li class="nav-item @if(request()->is('invoice/admin/settings/create')) active @endif">
                                <a class="nav-link" href="{{ route('invoice.admin.setting_create') }}">
                                    <span class="sidebar-mini"> NCS </span>
                                    <span class="sidebar-normal">New Create Setting </span>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </li>
                {{-- <li class="nav-item @if(request()->is('invoice/admin/settings')) active @endif ">
                    <a class="nav-link" href="{{ route('invoice.admin.settings') }}">
                        <i class="material-icons">build</i>
                        <p> Settings </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <div class="after"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('invoice.admin.desc') }}">
                        <i class="material-icons">laptop</i>
                        <p> Grasexan </p>
                    </a>
                </li>
{{--                <li class="nav-item @if(request()->is('invoice/admin/invoice')) active @endif ">--}}
{{--                    <a class="nav-link" href="{{ route('invoice.admin.invoice') }}">--}}
{{--                        <i class="material-icons">pending_actions</i>--}}
{{--                        <p> Invoice </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                            <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <a class="navbar-brand" href="javascript:;">@yield('page-name')</a>
                    @if(request()->is('invoice/admin/tasks/*'))
                        <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-just-icon btn-round btn-{{ $sidebar->filters }}">
                            <i class="material-icons">keyboard_backspace</i>
                        </a>
                    @endif
                    @if(request()->is('invoice/admin/settings/*'))
                        <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-just-icon btn-round btn-{{ $sidebar->filters }}">
                            <i class="material-icons">keyboard_backspace</i>
                        </a>
                    @endif
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav">
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink"--}}
{{--                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                <i class="material-icons">notifications</i>--}}
{{--                                <span class="notification">5</span>--}}
{{--                                <p class="d-lg-none d-md-block">--}}
{{--                                    Some Actions--}}
{{--                                </p>--}}
{{--                            </a>--}}
{{--                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">--}}
{{--                                <a class="dropdown-item" href="#">Mike John responded to your email</a>--}}
{{--                                <a class="dropdown-item" href="#">You have 5 new tasks</a>--}}
{{--                                <a class="dropdown-item" href="#">You're now friend with Andrew</a>--}}
{{--                                <a class="dropdown-item" href="#">Another Notification</a>--}}
{{--                                <a class="dropdown-item" href="#">Another One</a>--}}
{{--                            </div>--}}
{{--                        </li>--}}
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">person</i>
                                <p class="d-lg-none d-md-block">
                                    Account
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                <a class="dropdown-item" href="{{ route('invoice.admin.users_edit', ['id' => \App\Helper\AuthHelper::user()->id]) }}">Profile</a>
                                <a class="dropdown-item" href="{{ route('invoice.admin.settings') }}">Settings</a>
                                <a class="dropdown-item" href="{{ route('invoice.admin.desc') }}">Grasexan</a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('invoice.auth.logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" style="width: 94%; cursor:pointer;" href="#">Log out
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="content">
            @yield('content')
        </div>
    </div>
</div>

<div class="fixed-plugin">
    <div class="dropdown show-dropdown">
        <a href="#" class="rotation" data-toggle="dropdown">
            <i class="fa fa-cog fa-2x"> </i>
        </a>
        <ul class="dropdown-menu">
            <li class="header-title"> Sidebar Filters</li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger active-color">
                    <div class="badge-colors ml-auto mr-auto">
                        <span class="badge filter badge-purple @if($sidebar->filters == "purple") active @endif" data-color="purple"></span>
                        <span class="badge filter badge-azure @if($sidebar->filters == "azure") active @endif" data-color="azure"></span>
                        <span class="badge filter badge-green @if($sidebar->filters == "green") active @endif" data-color="green"></span>
                        <span class="badge filter badge-warning @if($sidebar->filters == "orange") active @endif" data-color="orange"></span>
                        <span class="badge filter badge-danger @if($sidebar->filters == "danger") active @endif" data-color="danger"></span>
                        <span class="badge filter badge-rose @if($sidebar->filters == "rose") active @endif" data-color="rose"></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="header-title">Sidebar Background</li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="ml-auto mr-auto">
                        <span class="badge filter badge-black  @if($sidebar->background == "black") active @endif" data-background-color="black"></span>
                        <span class="badge filter badge-white @if($sidebar->background == "white") active @endif" data-background-color="white"></span>
                        <span class="badge filter badge-red @if($sidebar->background == "red") active @endif" data-background-color="red"></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Sidebar Mini</p>
                    <label class="ml-auto">
                        <div class="togglebutton switch-sidebar-mini">
                            <label>
                                <input type="checkbox" @if($sidebar->mini == 'true') checked @endif>
                                <span class="toggle"></span>
                            </label>
                        </div>
                    </label>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger">
                    <p>Sidebar Images</p>
                    <label class="switch-mini ml-auto">
                        <div class="togglebutton switch-sidebar-image">
                            <label>
                                <input type="checkbox"  @if($sidebar->is_image == 'true') checked @endif>
                                <span class="toggle"></span>
                            </label>
                        </div>
                    </label>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="header-title">Images</li>
            <li class="@if($sidebar->image == 'invoices/admin/img/fixed-plugin/sidebar-1.jpg') active @endif">
                {{-- <a class="img-holder switch-trigger" href="javascript:void(0)" data-img="invoices/admin/img/fixed-plugin/sidebar-1.jpg">
                    <img src="{{ asset('invoices/admin/img/fixed-plugin/sidebar-1.jpg') }}" alt="" data-src="{{ asset('invoices/admin/img/fixed-plugin/sidebar-1.jpg') }}">
                </a> --}}
            </li>
            <li class="@if($sidebar->image == 'invoices/admin/img/fixed-plugin/sidebar-2.jpg') active @endif">
                {{-- <a class="img-holder switch-trigger" href="javascript:void(0)" data-img="invoices/admin/img/fixed-plugin/sidebar-2.jpg">
                    <img src="{{ asset('invoices/admin/img/fixed-plugin/sidebar-2.jpg') }}" alt="" data-src="{{ asset('invoices/admin/img/fixed-plugin/sidebar-2.jpg') }}">
                </a> --}}
            </li>
            <li class="@if($sidebar->image == 'invoices/admin/img/fixed-plugin/sidebar-3.jpg') active @endif">
                {{-- <a class="img-holder switch-trigger" href="javascript:void(0)" data-img="invoices/admin/img/fixed-plugin/sidebar-3.jpg">
                    <img src="{{ asset('invoices/admin/img/fixed-plugin/sidebar-3.jpg') }}" alt="" data-src="{{ asset('invoices/admin/img/fixed-plugin/sidebar-3.jpg') }}">
                </a> --}}
            </li>
            <li class="@if($sidebar->image == 'invoices/admin/img/fixed-plugin/sidebar-4.jpg') active @endif">
                {{-- <a class="img-holder switch-trigger" href="javascript:void(0)" data-img="invoices/admin/img/fixed-plugin/sidebar-4.jpg">
                    <img src="{{ asset('invoices/admin/img/fixed-plugin/sidebar-4.jpg') }}" alt="" data-src="{{ asset('invoices/admin/img/fixed-plugin/sidebar-4.jpg') }}">
                </a> --}}
            </li>
        </ul>
    </div>
</div>

<input type="hidden" id="sidebar_route" data-route-sidebarUpdate="{{ route('invoice.admin.sidebar_update') }}">
<!--   Core JS Files   -->
<script>
     $(document).on('click','.user_id',function(){
            let classname 
            let comma;
            if($(this)[0].checked){
                classname = $(this).data('userName')
                classname = classname.replace(' ','_')
                $(this).parent().parent().parent().prev().find('.Unassigned').remove();
                
                $(this).parent().parent().parent().prev().append(`<span class="comma ${classname}">${classname}</span>`)
            }else if(!$(this)[0].checked){
                classname = $(this).data('userName')
                classname = classname.replace(' ','_')
                $(this).parent().parent().parent().prev().find(`.${classname}`).remove()
                if($(this).parent().parent().parent().prev().find(`span`).length == 0){
                    $(this).parent().parent().parent().prev().html('<span class="Unassigned">Unassigned</span>')
                }
            }
        })
</script>
@if(\Request::is('invoice/admin/users'))
<script>
       
       
     let j = 0;
     let user_arr = [];
    function has_or_not_task(input,tasks_count,user_name){
        if(input[0].checked){
           if(j == 0){
               j++
            $('#user_has_tasks').html('')
           }
           $('#user_has_tasks').append(
               `<div class="border-1" id = 'user_${input[0].value}'>
               <h3><span>${user_name}</span> has ${tasks_count} task</h3>
               <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3 settingname" id="user">
                        Assign:
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9  ">
                        <div class="dropdown  ">
                            <button class="btn btn-secondary dropdown-toggle col-12"  type="button" id="dropdownUser{{$users[0]->name}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            
                                Unassigned  
                            </button>
                            <div class="dropdown-menu remove_user_div_parent" aria-labelledby="dropdownMenuButton" style="width: 200%" data-id="{{$i}}" id="chekbox_div_${input[0].value}">
                            @forelse($users as $i => $user)
                                <div  class="dropdown-item useritem d-flex p-1 row col-12 remove_user_div remove_{{$user->id}}" >
                                        <span class="col-1">
                                        <input data-id="{{ $user->id }}"  class="remove_user " type="checkbox" onclick="assign($(this),'${input[0].value}','{{$user->id}}')" name="{{ $user->id }}" value="${input[0].value}">
                                        </span>
                                        <span class="col-5">
                                            {{$user->name}} 
                                        </span> 
                                        <span style="opacity: 0.6;" class="col-5">
                                            {{$user->email}} 
                                        </span>
                                </div>
                            @empty
                                <p>empty</p>
                            @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                </div>`
            )
            user_arr.push(input[0].value,)
            for(let i=0; i<user_arr.length;i++){
                $(`.remove_${user_arr[i]}`).remove()
            }
        } else if(j > 0){
            $(`#user_${input[0].value}`).remove()
        }else{
            $('#user_has_tasks').html(` Tasks empty `)
        }
    }
    function assign(input,remove_user,assign_user){
        // let route = $('#route').data('route-remove');
        // if(input[0].checked){
        //     $.ajax({
        //             type:'POST',
        //             url:    route,
        //             dataType: "json",
        //             data: {remove:remove_user,assign:assign_user,,_token:'{{csrf_token()}}'},
        //             success:function(data) {
        //                 alert(data)
        //             }
        //         });
        //     console.log(`remove ${remove_user} assign ${assign_user}`)

        // }
    }
</script>
@endif
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
    function selectuser(item,id,user_id){
        route = $('#route_task').data('route-update');
        route = route.replace('#ID#', id);
        let classname;
        if(item[0].checked){
            $.ajax({
                    type: 'POST',
                    url:   route,
                    dataType: "json",
                    data: {task_id:id,add_user:user_id,_token:'{{csrf_token()}}'},
                    success:function(data) {
                        console.log('aa')
                    }
                });
        classname = item.data('userName')
        classname = classname.replace(' ','_')
        item.parent().parent().parent().prev().find('.Unassigned').remove();
        item.parent().parent().parent().prev().append(`<span class="comma ${classname}">${classname}</span>`)
        }else{
            $.ajax({
                    type: 'POST',
                    url:   route,
                    dataType: "json",
                    data: {task_id:id,remove_user:user_id,_token:'{{csrf_token()}}'},
                    success:function(data) {
                        console.log('aa')
                    }
                });
        classname = item.data('userName')
        classname = classname.replace(' ','_')
        item.parent().parent().parent().prev().find(`.${classname}`).remove()

            if(item.parent().parent().parent().prev().find(`span`).length == 0){
                item.parent().parent().parent().prev().html('<span class="Unassigned">Unassigned</span>')
            }
        }
        
    }
    @if(isset($tasks))
    $('#delete_task').on('click',function(){
        let route = $('#route_task').data('route-remove');
        let tasks_id = [];
        let checkbox = $('.img_content')
        let count_tasks = {{count($tasks)}};
        let remove_issues = 0;

        for(let i = 0; i < checkbox.length; i++){
            if(checkbox[i].checked){
                tasks_id.push(checkbox[i].value)
                $(`#${checkbox[i].id}`).parent().parent().parent().parent().parent().remove()
                remove_issues++
            }
            
        }
        $('#issues').html(`Matches ${count_tasks - remove_issues}  issues`)
        $("#howe_issues").html('')
        $.ajax({
                    type: 'POST',
                    url:   route,
                    dataType: "json",
                    data: {id:tasks_id ,_token:'{{csrf_token()}}'},
                    success:function(data) {
                        if(data){
                            $("#success").show();
                            $("#success").removeClass('fadeOutUp') 
                            $("#success").addClass('fadeInDown');
                            setTimeout(function() { 
                                $("#success").removeClass('fadeInDown') 
                                $("#success").addClass('fadeOutUp') 
                            }, 2500);
                        }
                        
                    }
                });
            issue = 0
        

    })
    @endif
</script>
    <script>
        let last_id = false;
        let i = 0
        let issue = 0;
        let checked_or_not = false;
        $( ".task_tr" ).on('click',function() {
            let this_id = $( this )[0].id;
            if(i == 0){
                if( checked_or_not == false){
                $(`#${last_id}`).css({
                "background-color": 'white',
                "border-left": 'none',
                })
                $(`#${last_id}_check`).css({
                    "display": 'none',
                })
                $(`.${last_id}_img`).css({
                    "display": 'block',
                })
                }
                $(`#${this_id}`).css({
                "background-color": '#ebf6ff',
                "border-left": '3px solid',
                })
                $(`#${this_id}_check`).css({
                    "display": 'flex',
                })
                $(`.${this_id}_img`).css({
                    "display": 'none',
                })
                i++
                last_id = this_id;
                checked_or_not = false;
                if($(`#${last_id}_checkbox`)[0].checked  == true){
                    checked_or_not = true
                }
                

            }else{
                if(checked_or_not == false){
                $(`#${last_id}`).css({
                "background-color": 'white',
                "border-left": 'none',
                })
                $(`#${last_id}_check`).css({
                    "display": 'none',
                })
                $(`.${last_id}_img`).css({
                    "display": 'block',
                })
                
                }
                $(`#${this_id}`).css({
                "background-color": '#ebf6ff',
                "border-left": '3px solid',
                })
                $(`#${this_id}_check`).css({
                    "display": 'flex',
                })
                $(`.${this_id}_img`).css({
                    "display": 'none',
                })
                i = 0
                last_id = this_id;
                checked_or_not = false;
                if($(`#${last_id}_checkbox`)[0].checked  == true){
                    checked_or_not = true
                }

            } 
        }
        );
        $( ".img_content" ).on('click',function() {
            let this_item = $( this )[0];
            let null_cheked = $('#issues').html();
            if(this_item.checked){
                if(issue == 0){
                    $('#user_has_tasks').html('')
                }
                issue++
                $('#removeBtnUser').removeClass('disabled')
                $('#user_has_tasks').append(
                   `<div class="border-1" id = 'task_${$(this).val()}'>
                    <h3><span>No:</span> ${$(this).data('name')} </h3>
                    </div>`
                )
                $("#howe_issues").html(`${issue} of `)
                $("#howe_issues").css('opacity','1')
            }else if(issue > 0){
                issue--
                $(`#task_${$(this).val()}`).remove()
                if(issue == 0){
                    $("#howe_issues").css('opacity','0')
                    $("#howe_issues").html('')
                    $('#user_has_tasks').html(` Tasks empty `)
                    $('#removeBtnUser').addClass('disabled')
                }else{
                    $("#howe_issues").html(`${issue} of`) 
                }  
            }
        }
        );
    </script>

<script>
    
    <!-- Dialog show event handler -->
    $('#confirmDelete').on('show.bs.modal', function (e) {  
        $message = $(e.relatedTarget).attr('data-message');
        $(this).find('.modal-body p').text($message);
        $title = $(e.relatedTarget).attr('data-title');
        $(this).find('.modal-title').text($title);

        // Pass form reference to modal for submission on yes/ok
        var form = $(e.relatedTarget).closest('form');
        $(this).find('.modal-footer #confirm').data('form', form);
    });
    <!-- Form confirm (yes/ok) handler, submits form -->
    $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
        $('.removeBtnUser_test').click()
        // $(this).data('form').submit();
    });
    $('.removeBtnUser').on('click',function(){
        $("#confirmDelete").modal('show');
    })
    $(document).on('mouseup', function(e) {
            let container = $("#confirmDelete");
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                container.modal('hide');
            }
        });
</script>

<script src="{{ asset('invoices/admin/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/core/popper.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/core/bootstrap-material-design.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/jasny-bootstrap.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/jquery.validate.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/sweetalert2.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/moment.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/bootstrap-selectpicker.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/bootstrap-notify.js') }}"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('invoices/admin/js/material-dashboard.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('invoices/admin/js/fixedPlugin.js') }}"></script>
@if($message = Session::get('success'))
    <script>
        $.notify({
                icon: "add_alert",
                message: "{{ $message }}"
            },
            {
                type: "success",
                timer: 2e2,
                placement:
                    {
                        from: 'bottom',
                        align: 'right'
                    }
            },

        );
    </script>
    

@endif
@yield('scripts')
</body>

</html>