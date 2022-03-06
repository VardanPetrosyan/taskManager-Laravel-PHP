<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('invoices/images/logo.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('invoices/images/logo.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>
        Office
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport'/>
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('invoices/admin/css/material-dashboard.min.css') }}" rel="stylesheet"/>
</head>
<style>
    .reg-in {
        margin-left: -20px;
    }
</style>


<body class="off-canvas-sidebar">

<div class="wrapper wrapper-full-page">
    <div class="page-header register-page header-filter" filter-color="black"
         style="background-image: url(<?php echo e(asset('invoices/images/register.jpg')); ?>)">
        <div class="container">
            <div class="row">
                <div class="col-md-10 ml-auto mr-auto">
                    <div class="card card-signup">
                        <h2 class="card-title text-center">Register</h2>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mr-auto">
                                    <form class="form" method="POST" id="inviteForm" action="<?php echo e(route('invoice.register.user')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="material-icons">face</i>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-11">
                                                    <div class="bmd-form-group reg-in">
                                                        <label for="name" class="bmd-label-floating"> Full Name *</label>
                                                        <input type="text" class="form-control" id="name" name="name" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="material-icons">mail</i>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-11">
                                                    <div class="bmd-form-group reg-in">
                                                        <label for="email" class="bmd-label-floating"> Email Address *</label>
                                                        <input type="text" class="form-control disabled" id="email"  value="<?php echo e($user->email); ?>" name="email" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="material-icons">lock_outline</i>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-11">
                                                    <div class="bmd-form-group reg-in">
                                                        <label for="password" class="bmd-label-floating"> Password *</label>
                                                        <input type="password" name="password" id="password" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="material-icons">lock_outline</i>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-11">
                                                    <div class="bmd-form-group reg-in">
                                                        <label for="confirm_password" class="bmd-label-floating"> Confirm Password *</label>
                                                        <input type="password" name="password_confirmation" id="confirm_password" class="form-control" equalTo="#password" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-round mt-4">Registration</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div >
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>
                            <div class="alert alert-danger">{{ $error }}</div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
<!--   Core JS Files   -->

<script src="{{ asset('invoices/admin/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/core/popper.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/core/bootstrap-material-design.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('invoices/admin/js/plugins/jquery.validate.min.js') }}"></script>

<script src="{{ asset('invoices/admin/js/material-dashboard.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
<script>
    let val =  $('#email').val() 
    $('#email').on('input',function(){
        $('#email').val(val)
    })
</script>
</body>

</html>