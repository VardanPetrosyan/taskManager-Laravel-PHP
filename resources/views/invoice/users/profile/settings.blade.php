@extends('invoice._layouts.user')
@section('page-title', 'Settings')

@section('styles')
    <style>
        .pass_active {
            color: #5e72e4;
        }
    </style>
@endsection

@section('content')
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <div class="card">
            <!-- Card header -->
            <div class="card-header">
                <h3 class="mb-0">Change Password</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('invoice.users.update_password', ['id' => \App\Helper\AuthHelper::user()->id]) }}" id="password-form" method="POST">
                    @csrf
                    <div class="row">
                        @if ($errors->any())
                        <div class="col-md-12" >
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                                    </div>
                                    <input class="form-control" id="old_pass" name="old_password" placeholder="Old Password" type="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text eyeBtn"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" id="new_pass" name="new_password" placeholder="New Password" type="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text eyeBtn"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" id="confirm_new_pass" name="confirm_new_password" placeholder="Confirm Password" type="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text eyeBtn"><i class="fas fa-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-primary updateBtn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-2"></div>
@endsection

@section('scripts')
    <script>
        $('.eyeBtn').click(function() {
            if(!$(this).hasClass('pass_active')) {
                $(this).addClass('pass_active');
                $(this).parent().prev().attr('type', 'text');
            } else {
                $(this).removeClass('pass_active');
                $(this).parent().prev().attr('type', 'password');
            }
        });

        $('.updateBtn').click(function () {
            let oldPass = $('#old_pass').val();
            let id = {{ \App\Helper\AuthHelper::user()->id }}
            if(oldPass != '') {
                $.ajax({
                    url: "{{ route('invoice.users.check_old_password') }}",
                    type: "POST",
                    dataType: 'JSON',
                    data: {
                        id: id,
                        old_pass: oldPass,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        let el = '<span style="color: red;" class="new_pass">Please enter new password</span>'
                        let no_confirme = '<span style="color: red;" class="new_pass">The password confirmation does not match</span>'
                        $('.new_pass').remove();
                        if (res.status) {
                            if ($('#new_pass').val() != '' && $('#confirm_new_pass').val() != '' && $('#new_pass').val() == $('#confirm_new_pass').val()) {
                                $('#password-form').submit();
                            } else if ($('#new_pass').val() == '' && $('#confirm_new_pass').val() == '') {
                                $('#new_pass').parent().parent().append(el)
                                $('#confirm_new_pass').parent().parent().append(el)
                            } else if ($('#new_pass').val() == '' && $('#confirm_new_pass').val() != '') {
                                $('#new_pass').parent().parent().append(el)
                            } else if ($('#new_pass').val() != '' && $('#confirm_new_pass').val() == '') {
                                $('#confirm_new_pass').parent().parent().append(el)
                            }else if($('#new_pass').val() !== $('#confirm_new_pass').val()){
            
                                $('#confirm_new_pass').parent().parent().append(no_confirme)
                            }
                        } else {
                            let el = '<span style="color: red;" class="new_pass">Old password incorrect</span>'
                            $('#old_pass').parent().parent().append(el)
                        }
                    }
                })
            } else {
                let el = '<span style="color: red;" class="new_pass">Please enter old password</span>'
                $('#old_pass').parent().parent().append(el)
            }
        });
    </script>
@endsection
