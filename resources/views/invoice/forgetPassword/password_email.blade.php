<form class="form" action="{{ route('invoice.post.forget-password') }}" method="post" id="inviteForm">
    @csrf
    <div class="card card-login">
        <div class="card-header card-header-rose text-center">
            <h4 class="card-title">Forget Password</h4>
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
                    <div class="form-group bmd-form-group @if($email)is-focused @endif">
                        <label for="forget_email" class="bmd-label-floating">Email...</label>
                        <input type="email" class="form-control" id="forget_email" value="{{ $email }}" name="email" aria-required="true" required>
                    </div>
                    @if($errors->has('email'))
                        <span class="invalid-feedback">
                            <b style="color:red;"> {{ $errors->first('email') }} </b>
                        </span> 
                    @endif
                </div>
            </div>
            <div class="form-group text-center">
                <span style="color: red; display: none" class="error-message"></span>
            </div>
        </div>
        <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-rose btn-link btn-lg">Send</button>
        </div>
    </div>
</form>