<!doctype html>
<html lang="hy">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/logo/logo.png') }}" type="image/x-icon">
    <title>Admin</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/checkbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/my-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/fastselect/fastselect.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css">



    @yield('css')


</head>
<body class="app">
<div id="admin" class="sidebar">
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <div class="peers ai-c fxw-nw">
                <div class="peer peer-greed">
                    <a class="sidebar-link td-n" href="">
                        <div class="peers ai-c fxw-nw">
                            <div class="peer">
                                <div class="logo">
                                    <span class="icon-holder">
                                        <img draggable="false" src="{{ asset('img/logo/logo.png') }}" alt="">
                                    </span>
                                    <span class="title heading"
                                          style="color:#15b50d">{{Session::get('logged_admin_name')}}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="peer">
                    <div class="mobile-toggle sidebar-toggle">
                        <a href="" class="td-n">
                            <i class="ti-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <ul class="sidebar-menu scrollable pos-r">
            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin_dashboard') }}">
                    <span class="icon-holder">
                        <i class="c-green-500 ti-dashboard"></i>
                    </span>
                    <span class="title">Վահանակ</span>
                </a>
            </li>

            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin_user_list') }}">
                    <span class="icon-holder">
                        <i class="c-indigo-500 ti-user"></i>
                    </span>
                    <span class="title">Օգտատերեր</span>
                </a>
            </li>

            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin_position') }}">
                    <span class="icon-holder">
                        <i class="c-indigo-500 ti-id-badge"></i>
                    </span>
                    <span class="title">Պաշտոն</span>
                </a>
            </li>

            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin_products') }}">
                    <span class="icon-holder">
                        <i class="c-brown-500 ti-shopping-cart-full"></i>
                    </span>
                    <span class="title">Ապրանքներ</span>
                </a>
            </li>

            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin_order_all') }}">
                    <span class="icon-holder">
                        <i class="c-indigo-500 ti-clipboard"></i>
                    </span>
                    <span class="title">Պատվերներ</span>
                </a>
            </li>

            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin_categorie_all') }}">
                    <span class="icon-holder">
                        <i class="c-purple-500  ti-layers-alt"></i>
                    </span>
                    <span class="title">Կատեգորիա</span>
                </a>
            </li>

            <li class="nav-item menu">
                <a class='sidebar-link ' id="mainFurnitures" href="{{ route('admin_furniture') }}">
                    <span class="icon-holder">
                        <i class="c-purple-500 ti-package"></i>
                    </span>
                    <span class="title">Գույք</span>
                </a>
            </li>

            <li class="nav-item hideElement menu" style="background: #88AD43">
                <a class='sidebar-link' href="{{ route('admin_furniture_ordered') }}">
                    <span class="icon-holder">
                        <i class="c-purple-500 ti-pencil-alt"></i>
                    </span>
                    <span class="title">Պատվիրված Գույք</span>
                </a>
            </li>

            <li class="nav-item hideElement menu" style="background: #88AD43">
                <a class='sidebar-link' href="{{ route('admin_furniture_history') }}">
                    <span class="icon-holder">
                        <i class="c-purple-500 ti-book"></i>
                    </span>
                    <span class="title">Գույքի պատմություն</span>
                </a>
            </li>


            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin_categories_structure') }}">
                    <span class="icon-holder">
                        <i class="c-purple-500 ti-home"></i>
                    </span>
                    <span class="title">Բաժիններ </span>
                </a>
            </li>
            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin_categories_structure_archive') }}">
                    <span class="icon-holder">
                        <i class="c-purple-500 ti-harddrives"></i>
                    </span>
                    <span class="title">Արխիվ</span>
                </a>
            </li>


            <li class="nav-item">
                <a class='sidebar-link' href="{{ route('admin_logout') }}">
                    <span class="icon-holder">
                        <i class="fas fa-sign-out-alt" style="transform: rotate(180deg);"></i>
                    </span>
                    <span class="title">Դուրս գալ</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="page-container">

    <main class='main-content bgc-grey-100'>
        <div id='mainContent'>
            @yield('content')
        </div>
    </main>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/jquery-ui-1.12.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        }
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();


        $('.hideElement').hide();


        $('.menu ').hover(
            function () {
                $('.hideElement').show();
            },

            function () {

                $('.hideElement').hide();
            }
        );
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script type="text/javascript" src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ asset('js/jquery.tabledit.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/dropdown/script.js') }}"></script>

@yield('js')

@yield('script')
</body>
</html>
