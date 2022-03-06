@extends('invoice._layouts.user')
@section('page-title', 'My profile')

@section('content')
    <div class="row col-12">
        <div class="col-xl-4 order-xl-2">
                <div class="card card-profile">
                    <div style="background-image: url('{{ asset('invoices/user/img/bg-img.jpg') }}'); height: 255px; background-size: cover; background-position: top;"></div>
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="{{ asset($user->img) }}" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    </div>
                    <div class="card-body pt-4">
                        <div class="text-center">
                            <h5 class="h3">
                                {{ \App\Helper\AuthHelper::user()->name }}
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center">
                                    <div>
                                        <span class="heading">{{ $projectUserCount }}</span>
                                        <span class="description">Projects</span>
                                    </div>
                                    <div>
                                        <span class="heading">{{ $tasksCount }}</span>
                                        <span class="description">Tasks</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="row col-12">
            <div class="card col-12">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit profile </h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="javascript:;" class="btn btn-sm btn-primary editBtn">Edit</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ route('invoice.users.profile_update', ['id' => \App\Helper\AuthHelper::user()->id]) }}"
                        id="profile-form"
                        class="needs-validation">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Username</label>
                                        <input type="text" id="input-username" class="form-control" name="username"
                                            value="{{ \App\Helper\AuthHelper::user()->name }}" disabled required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please enter task number.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend2">@</span>
                                            </div>
                                            <input type="email" class="form-control" name="email" id="input-email"
                                                value="{{ \App\Helper\AuthHelper::user()->email }}" disabled required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter task number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-right">
                                    <button class="btn btn-sm btn-primary updateBtn" style="display: none">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            <div class="row col-12">
                @if ($errors->any())
                    <div class="col-12" >
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
@endsection

@section('scripts')
    <script>
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                } else {
                    console.log(form.checkValidity())
                }
                form.classList.add('was-validated');
            }, false);
        });

        $('.editBtn').click(function () {
            $('.updateBtn').show();
            $('.form-control').removeAttr('disabled')
            $(this).hide();
        });
    </script>
@endsection