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
    <style>
        .dropdown-menu.show,
        .dropdown-menu.show > .inner.show {
            max-height: 400px !important;
        }

        .fixed-plugin a.rotation i {
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
    </style>
    @yield('styles')
</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-color="rose" data-background-color="black"
         data-image="{{ asset('invoices/admin/img/fixed-plugin/sidebar-1.jpg') }}">
        <div class="logo">
            <a href="{{ route('invoice.admin.desc') }}" class="simple-text logo-mini">
                GS
            </a>
            <a href="{{ route('invoice.admin.desc') }}" class="simple-text logo-normal">
                Grasexan
            </a>
        </div>
        <div class="sidebar-wrapper">
            <div class="user">
                <div class="photo">
                    <img src="{{ asset(\App\Helper\AuthHelper::user()->img) }}"/>
                </div>
                <div class="user-info">
                    <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            <span>{{ \App\Helper\AuthHelper::user()->name }}
                                <b class="caret"></b>
                            </span>
                    </a>
                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('invoice.admin.users_edit', ['id' => \App\Helper\AuthHelper::user()->id]) }}">
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
                <li class="nav-item @if(request()->is('invoice/admin/desc')) active @endif">
                    <a class="nav-link" href="{{ route('invoice.admin.desc') }}">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="after"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#navData"
                       aria-expanded="@if(request()->is('invoice/admin/desc/*/*') && request()->route('field_slug'))true @else false @endif">
                        <i class="material-icons">view_day</i>
                        <p> Data
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if(request()->is('invoice/admin/desc/*/*') && request()->route('field_slug'))show @endif" id="navData">
                        <ul class="nav">
                        @foreach($descSidebarFill as $fill)
                            @if(count($fill['field']))
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#{{$fill['slug']}}"
                                aria-expanded="@if(request()->is('invoice/admin/desc/fill/*'))true @else false @endif">
                                    <i class="material-icons">text_snippet</i>
                                    <p> {{$fill['fill_name']}}
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <div class="collapse @if(request()->is('invoice/admin/desc/'.$fill['slug'].'/*') && request()->route('field_slug'))show @endif"
                                    id="{{$fill['slug']}}">
                                    <ul class="nav">
                                        @foreach($fill['field'] as $field)
                                            <li id="navField{{$field->id}}" class="nav-item  @if(request()->is('invoice/admin/desc/'.$fill['slug'].'/'.$field->slug)) active @endif">
                                                <a class="nav-link" href="{{ route('invoice.admin.desc.fill.field_data',['slug'=>$fill['slug'],'field_slug'=>$field->slug]) }}">
                                                    <span class="sidebar-mini">
                                                        @php
                                                            $str = '';
                                                            foreach (explode(' ', $field->name) as $word){
                                                                $str .= mb_substr($word, 0, 1);
                                                            }
                                                            echo $str;
                                                        @endphp
                                                    </span>
                                                    <span class="sidebar-normal">{{$field->name}}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('invoice.admin.desc.fill_fields', ['slug'=>$fill['slug']]) }}">
                                    <i class="material-icons">text_snippet</i>
                                    <p>{{ $fill['fill_name'] }}</p>
                                </a>
                            </li>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="after"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#navPayment"
                       aria-expanded="@if(request()->is('invoice/admin/desc/payment/*'))true @else false @endif">
                        <i class="material-icons">paid</i>
                        <p> Payment
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if(request()->is('invoice/admin/desc/payment/*'))show @endif" id="navPayment">
                        <ul class="nav">
                            <li class="nav-item  @if(request()->is('invoice/admin/desc/payment/payment-history')) active @endif">
                                <a class="nav-link" href="#">
                                    <span class="sidebar-mini">PH</span>
                                    <span class="sidebar-normal">Payment History</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="after"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#fill"
                       aria-expanded="@if(request()->is('invoice/admin/desc/fill/*'))true @else false @endif">
                        <i class="material-icons">apps</i>
                        <p> Fill
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse @if(request()->is('invoice/admin/desc/fill/*'))show @endif" id="fill">
                        <ul class="nav">
                            <li class="nav-item  @if(request()->is('invoice/admin/desc/fill/all')) active @endif">
                                <a class="nav-link" href="{{ route('invoice.admin.desc_all_fill') }}">
                                    <span class="sidebar-mini">AF</span>
                                    <span class="sidebar-normal">All Fill</span>
                                </a>
                            </li>
                            <li class="nav-item  @if(request()->is('invoice/admin/desc/fill/create')) active @endif">
                                <a class="nav-link" href="{{ route('invoice.admin.desc_create_fill') }}">
                                    <span class="sidebar-mini">CF</span>
                                    <span class="sidebar-normal">Create Fill</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="after"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('invoice.admin.dashboard') }}">
                        <i class="material-icons">laptop</i>
                        <p>Admin Panel</p>
                    </a>
                </li>
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
                </div>
                <a class="navbar-brand" href="javascript:;">@yield('page-name')</a>
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
                                <a class="dropdown-item"
                                   href="{{ route('invoice.admin.users_edit', ['id' => \App\Helper\AuthHelper::user()->id]) }}">Profile</a>
                                <a class="dropdown-item" href="{{ route('invoice.admin.settings') }}">Settings</a>
                                <a class="dropdown-item" href="{{ route('invoice.admin.dashboard') }}">Admin Panel</a>
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
</body>
<!--   Core JS Files   -->
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
