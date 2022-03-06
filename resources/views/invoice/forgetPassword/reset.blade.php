@extends('invoice._layouts.login')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto" id="render">
            <form class="form" action="{{ route('invoice.post.updatePassword') }}" method="post" id="inviteForm">
                <input type="hidden" value="{{ $token }}" name="token">
                @csrf
                <div class="card card-login card-hidden">
                    <div class="card-header card-header-rose text-center">
                        <h4 class="card-title">Reset Password</h4>
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
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $email ?? old('email') }}" aria-required="true" required>
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
                                    <label for="password-confirm" class="bmd-label-floating">Confirm Password</label>
                                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" aria-required="true" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <span style="color: red; display: none" class="error-message"></span>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit" class="btn btn-rose btn-link btn-lg">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
