<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ադմին Մուտք</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
</head>
<style>
    #login {
    padding-top: 50px
    }
    #login .form-wrap {
        width: 30%;
        margin: 0 auto;
    }
    #login h1 {
        color: #1fa67b;
        font-size: 18px;
        text-align: center;
        font-weight: bold;
        padding-bottom: 20px;
    }
    #login .form-group {
        margin-bottom: 25px;
    }
    #login .checkbox {
        margin-bottom: 20px;
        position: relative;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        -o-user-select: none;
        user-select: none;
    }
    #login .checkbox.show:before {
        content: '\e013';
        color: #1fa67b;
        font-size: 17px;
        margin: 1px 0 0 3px;
        position: absolute;
        pointer-events: none;
        font-family: 'Glyphicons Halflings';
    }
    #login .checkbox .character-checkbox {
        width: 25px;
        height: 25px;
        cursor: pointer;
        border-radius: 3px;
        border: 1px solid #ccc;
        vertical-align: middle;
        display: inline-block;
    }
    #login .checkbox .label {
        color: #6d6d6d;
        font-size: 13px;
        font-weight: normal;
    }
    #login .btn.btn-custom {
        font-size: 14px;
        margin-bottom: 20px;
    }
    #login .forget {
        font-size: 13px;
        text-align: center;
        display: block;
    }

    /*    --------------------------------------------------
        :: Inputs & Buttons
        -------------------------------------------------- */
    .form-control {
        color: #212121;
    }
    .btn-custom {
        color: #fff;
        background-color: #1fa67b;
    }
    .btn-custom:hover,
    .btn-custom:focus {
        color: #fff;
    }

    /*    --------------------------------------------------
        :: Footer
        -------------------------------------------------- */
    #footer {
        color: #6d6d6d;
        font-size: 12px;
        text-align: center;
    }
    #footer p {
        margin-bottom: 0;
    }
    #footer a {
        color: inherit;
    }

    .eye {
        position: absolute;
        top: 8px;        
        right: 17px;
        font-size: 19px;
    }

    .none {
        display: none;
    }
</style>
<body>
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-wrap">
                    <h1>Մուտք գործեք էլ հասցեի միջոցով</h1>
                        <form role="form" action="{{ route('admin_login') }}" method="post" id="login-form" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="sr-only">Էլ հասցե</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Էլ հասցե">
                                @if($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <b style="color:red;"> {{ $errors->first('email') }} </b>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group" style="position: relative;">
                                <label for="key" class="sr-only">Գաղտնաբառ</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Գաղտնաբառ">
                                <i class="fas fa-eye eye" id="show-eye"></i>
                                <i class="fas fa-eye-slash eye none" id="hide-eye"></i>
                                @if($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <b style="color:red;"> {{ $errors->first('password') }} </b>
                                    </span>
                                @endif
                            </div>
                            <hr>
                            <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Log in">
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>

    <script type="text/javascript">

        $(".eye").on('click', function(){
            var key_attr = $('#key').attr('type');
            
            if(key_attr != 'text') {
                $('#hide-eye').removeClass('none');
                $('#key').attr('type', 'text');
                
            } else {
                
                $('#show-eye').removeClass('none');
                $('#hide-eye').addClass('none');
                $('#key').attr('type', 'password');
                
            }
            
        })
    </script>
</body>
</html>