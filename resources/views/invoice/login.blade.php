@extends('invoice._layouts.login')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto" id="render">
            <form class="form" action="{{ route('invoice.login') }}" method="post" id="inviteForm">
                @csrf
                <div class="card card-login card-hidden">
                    <div class="card-header card-header-rose text-center">
                        <h4 class="card-title">Login</h4>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="material-icons">email</i>
                                                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group bmd-form-group">
                                    <label for="email" class="bmd-label-floating">Email...</label>
                                    <input type="email" class="form-control" id="email" name="email" aria-required="true" required>
                                </div>
                                @if($errors->has('email'))
                                    <span class="invalid-feedback">
                                                <b style="color:red;"> {{ $errors->first('email') }} </b>
                                            </span>
                                @endif
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="material-icons">lock_outline</i>
                                                </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group bmd-form-group">
                                    <label for="password" class="bmd-label-floating">Password...</label>
                                    <input type="password" class="form-control" id="password" name="password" aria-required="true" required>
                                </div>
                                @if($errors->has('password'))
                                    <span class="invalid-feedback">
                                                <b style="color:red;"> {{ $errors->first('password') }} </b>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <span style="color: red; display: none" class="error-message"></span>
                        </div>
                        <div class="bmd-form-group text-center mt-4 ml-4">
                            <a href="javascript:;" class="forgetPasswordBtn">Forgot password?</a>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="button" class="btn btn-rose btn-link btn-lg" id="btn-login">Lets Go</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection