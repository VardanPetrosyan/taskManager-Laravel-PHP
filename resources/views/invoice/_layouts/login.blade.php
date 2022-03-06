<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invoice Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport'/>
    <!-- Extra details for Live View on GitHub Pages -->
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('invoices/admin/css/material-dashboard.min.css') }}" rel="stylesheet"/>
</head>

<body>
<div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black"
         style="background-image: url({{ asset('invoices/admin/img/login.jpg') }});
                 background-size: cover;
                 background-position: top center;">
        <div class="container">
            @yield('content')

        </div>
    </div>
</div>
<!--   Core JS Files   -->
<script src="{{ asset('invoices/admin/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/core/popper.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/core/bootstrap-material-design.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/jquery.validate.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/bootstrap-notify.js') }}"></script>

<script src="{{ asset('invoices/admin/js/material-dashboard.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
@if($message = Session::get('message'))
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
@if($message = Session::get('error'))
    <script>
        $.notify({
                icon: "add_alert",
                message: "{{ $message }}"
            },
            {
                type: "danger",
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
<script>

    $(document).bind('click keydown', '#btn-login', function (e) {
        let email = $('#email').val();
        let pass = $('#password').val();
        if(e.type == 'click' && $(e.target).attr('id') == 'btn-login' || e.keyCode == 13){
            $.ajax({
                url: "{{ route('invoice.check_user') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    email: email,
                    pass: pass,
                    _token: "{{ csrf_token() }}",
                },
                success: function (res) {
                    if(res.type) {
                        $('#inviteForm').submit();
                    }else {
                        $('.error-message').show();
                        $('.error-message').html(res.mess);
                    }
                }
            })
        }
    })
    setTimeout(function() {
        $('.card').removeClass('card-hidden');
    }, 700);

    $('.forgetPasswordBtn').click(function () {
        let email = $('#email').val();
        $.ajax({
            url: "{{ route('invoice.get.forget-password') }}",
            dataType: "JSON",
            data: {
                email: email
            },
            success: function(res) {
                if(res.status) {
                    $('#render').empty().append(res.html);
                }
            }
        })
    });

    $(document).on('click', '#forget_email', function () {
        $(this).parent().addClass('is-focused')
    });

    $(document).mouseup(function (e) {
        if($('#forget_email').val() == '') {
            if ($('#forget_email').parent().hasClass("is-focused")) {

                if (!$('#forget_email').is(e.target) && $('#forget_email').has(e.target).length === 0) {
                    $('#forget_email').parent().removeClass('is-focused')
                }
            }
        }
    });
</script>
</body>
</html>