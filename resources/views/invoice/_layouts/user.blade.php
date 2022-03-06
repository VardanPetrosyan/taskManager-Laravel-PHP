<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice - User page</title>
    <!-- Favicon -->
    <link rel="icon" href="../../assets/img/brand/favicon.png" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('invoices/user/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('invoices/user/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <!-- Page plugins -->
    <link rel="stylesheet" href="{{ asset('invoices/user/vendor/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('invoices/user/vendor/select2/dist/css/select2.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('invoices/user/vendor/sweetalert2/dist/sweetalert2.min.css') }}" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('invoices/user/css/argon.min.css') }}" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      
    @yield('styles')
    <style>
        .modal-dialog .modal-header .modal-title {
        text-align: center;
        width: 100%;
        }
        .modal-header {
            flex-wrap: wrap;
        }
        #confirmDelete {
        transition: 0.3s;
        }
        
        
        .modal.fade * {
            color: black;
        }
        .modal-title {
            margin-bottom: 0;
            line-height: 1.5;
        }

        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: .3rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, .5);
            outline: 0;
        }
        .modal-dialog {
            position: relative;
            width: auto;
            margin: auto;
            margin-top: 100px;
            pointer-events: none;
            transition: 0.3s;
        }
        .modal.fade .modal-dialog {
            transition: transform .3s ease-out;
            transform: translateY(-25%);
        }
        .modal.show .modal-dialog {
            transform: translate(0);
        }
        
        .select2.select2-container {
            width: 200px!important;
        }
        .select2-selection__arrow {
            display: block;
        }
        .select2-container .select2-selection--single,
        .select2-container--default .select2-search--dropdown .select2-search__field,
        .select2-container--default .select2-selection--multiple,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            height: 28px;
            padding: 0 0 0 10px;

        }
        
    </style>
</head>

<body>

<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  d-flex  align-items-center">
            <a class="navbar-brand" href="{{ route('invoice.home') }}">
                Logo
            </a>
            <div class=" ml-auto ">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('invoice/home')) active @endif" href="{{ route('invoice.home') }}">
                            <i class="ni ni-shop text-green"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('invoice/users/tasks*')) active @endif" href="{{ route('invoice.users.tasks') }}">
                            <i class="ni ni-collection text-orange"></i>
                            <span class="nav-link-text">Tasks</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('invoice/users/projects*')) active @endif" href="{{ route('invoice.users.projects') }}">
                            <i class="ni ni-books text-info"></i>
                            <span class="nav-link-text">Projects</span>
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">--}}
{{--                            <i class="ni ni-ungroup text-orange"></i>--}}
{{--                            <span class="nav-link-text">Examples</span>--}}
{{--                        </a>--}}
{{--                        <div class="collapse" id="navbar-examples">--}}
{{--                            <ul class="nav nav-sm flex-column">--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="../../pages/examples/pricing.html" class="nav-link">--}}
{{--                                        <span class="sidenav-mini-icon"> P </span>--}}
{{--                                        <span class="sidenav-normal"> Pricing </span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="../../pages/examples/login.html" class="nav-link">--}}
{{--                                        <span class="sidenav-mini-icon"> L </span>--}}
{{--                                        <span class="sidenav-normal"> Login </span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="../../pages/examples/register.html" class="nav-link">--}}
{{--                                        <span class="sidenav-mini-icon"> R </span>--}}
{{--                                        <span class="sidenav-normal"> Register </span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="../../pages/examples/lock.html" class="nav-link">--}}
{{--                                        <span class="sidenav-mini-icon"> L </span>--}}
{{--                                        <span class="sidenav-normal"> Lock </span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="../../pages/examples/timeline.html" class="nav-link">--}}
{{--                                        <span class="sidenav-mini-icon"> T </span>--}}
{{--                                        <span class="sidenav-normal"> Timeline </span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="../../pages/examples/profile.html" class="nav-link">--}}
{{--                                        <span class="sidenav-mini-icon"> P </span>--}}
{{--                                        <span class="sidenav-normal"> Profile </span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a href="../../pages/examples/rtl-support.html" class="nav-link">--}}
{{--                                        <span class="sidenav-mini-icon"> RP </span>--}}
{{--                                        <span class="sidenav-normal"> RTL Support </span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </li>--}}

                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Search form -->
                <div class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main" >
{{--                <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main" onclick="">--}}
                    <div class="form-group mb-0">
                        <div class="input-group input-group-alternative input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" name='search' placeholder="Search" type="text" id="search" value="{{ request()->search ?  request()->search : "" }}" autocomplete="off">
                        </div>
                    </div>
                    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
{{--                </form>--}}
                </div>
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center  ml-md-auto ">
                    <li class="nav-item d-xl-none">
                        <!-- Sidenav toggler -->
                        <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item d-sm-none">
                        <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                            <i class="ni ni-zoom-split-in"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="{{ asset(\App\Helper\AuthHelper::user()->img) }}">
                  </span>
                                <div class="media-body  ml-2  d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold">{{ \App\Helper\AuthHelper::user()->name }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu  dropdown-menu-right ">
                            <a href="{{ route('invoice.users.profile', ['id' => \App\Helper\AuthHelper::user()->id]) }}" class="dropdown-item">
                                <i class="ni ni-single-02"></i>
                                <span>My profile</span>
                            </a>
                            <a href="{{ route('invoice.users.profile_settings', ['id' => \App\Helper\AuthHelper::user()->id]) }}" class="dropdown-item">
                                <i class="ni ni-settings-gear-65"></i>
                                <span>Settings</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('invoice.auth.logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item">
                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('invoice.home') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="javascript:;" style="cursor: auto;">@yield('page-title')</a></li>
                            </ol>
                        </nav>
                    </div>
                    @if(request()->is('invoice/home') || request()->is('invoice/users/tasks') || request()->is('invoice/users/projects/*/view'))
                        <div class="col-lg-6 col-5 d-flex justify-content-end align-items-center">
                            <a href="javascript:;" class="btn btn-sm btn-neutral newTaskBtn" data-toggle="modal"
                               data-target="#modal-form">New</a>
                            @if(request()->is('invoice/home') || request()->is('invoice/users/tasks'))
                            <select class="form-control select2-hidden-accessible" id="selectProject" data-toggle="select" aria-hidden="true">
                                <option value="0">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->projects->id }}" @if(request()->request->get('projects') == $project->project_id) selected @endif>{{ $project->projects->name }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row reverse" id="colProject">
            @yield('content')
        </div>
        @yield('content-2')
    </div>
</div>

<input type="hidden" id="token" value="{{ csrf_token() }}">
<!-- Argon Scripts -->
<!-- Core -->
<script src="{{ asset('invoices/user/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('invoices/user/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('invoices/user/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('invoices/user/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('invoices/user/vendor/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('invoices/user/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
<script src="{{ asset('invoices/user/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('invoices/user/vendor/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('invoices/user/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('invoices/user/vendor/select2/dist/js/select2.min.js') }}"></script>
<!-- Argon JS -->
<script src="{{ asset('invoices/user/js/argon.min.js') }}"></script>
<script src="{{ asset('invoices/user/js/myScript.js') }}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    let userId = "{{\App\Helper\AuthHelper::user()->id}}";
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

<script>
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
            } else {
                console.log(form.checkValidity())
            }
            form.classList.add('was-validated');
        }, false);
    });

    $('.close').click(function () {
        $(this).parent().attr('style', 'display: none!important')
    });
</script>
@yield('scripts')
@if($message = Session::get('success'))
    <script>
        $.notify({
                icon: "ni ni-bell-55",
                message: "{{ $message }}"
            },
            {
                type: "success",
                timer: 3e3,
                placement:
                    {
                        from: 'bottom',
                        align: 'right'
                    }
            },
        );
    </script>
@endif
<script>
    @if(isset($tasks))
    $('#delete_task').on('click',function(){
        let route = "{{route('invoice.user.task_remove')}}";
        let tasks_id = [];
        let checkbox = $('.img_content')
        let count_tasks = {{count($tasks)}};
        let remove_issues = 0;
        console.log(route)
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
    
    // function selectsetting(item,id,name,color,value){
    //     route = $('#route_task').data('route-update');
    //     route = route.replace('#ID#', id);
    //     console.log(id)
    //     $(`#task_helper_img_creat_${id}_${name}`).css({'background-color':color})
    //     $(`#task_helper_button_creat_${id}_${name}`).css({'border-color':color})
    //     $(`#task_helper_img_creat_${id}_${name}`).html(`<p>${value}</p>`)
    //     $(`#task_helper_button_creat_${id}_${name}`).html(item.html())
    //     $.ajax({
    //                 type: 'POST',
    //                 url:   route,
    //                 dataType: "json",
    //                 data: {task_id:id,setting:{[name]:item[0].id},_token:'{{csrf_token()}}'},
    //                 success:function(data) {
    //                     console.log(data)
    //                 }
    //             });
    // }
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
        let classname ;
        if(item[0].checked){
            $.ajax({
                    type: 'POST',
                    url:   route,
                    dataType: "json",
                    data: {task_id:id,add_user:user_id,_token:'{{csrf_token()}}'},
                    success:function(data) {
                        console.log(data)
                    }
                });
        classname = item.data('userName'); console.log(classname)
        classname = classname.replace(' ','_')
        item.parent().parent().parent().prev().find('.Unassigned').remove();
        item.parent().parent().parent().prev().append(`<span class="${classname}">${classname},</span>`)
        }else{
            $.ajax({
                    type: 'POST',
                    url:   route,
                    dataType: "json",
                    data: {task_id:id,remove_user:user_id,_token:'{{csrf_token()}}'},
                    success:function(data) {
                        console.log(data)
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
                $('#removeBtnUser').css({'pointer-events':'all'})
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
                    $('#removeBtnUser').css({'pointer-events':'none'})
                }else{
                    $("#howe_issues").html(`${issue} of`) 
                }  
            }
        }
        );
    </script>
    
</body>
</html>