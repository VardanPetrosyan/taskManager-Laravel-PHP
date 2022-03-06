@extends('invoice._layouts.admin')
@section('page-name', 'Create User')

@section('styles')
    <style>
        .nav-pills.nav-pills-warning .nav-item .nav-link.active,
        .nav-pills.nav-pills-warning .nav-item .nav-link.active:focus,
        .nav-pills.nav-pills-warning .nav-item .nav-link.active:hover {
            background-color: #e91e63;
            box-shadow: 0 4px 20px 0 rgba(0,0,0,.14), 0 7px 10px -5px rgba(233,30,99,.4);
        }
    </style>
@endsection

@section('content')

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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active p-0" data-toggle="tab" href="#add_person" role="tablist">
                            <i class="material-icons">person_add</i> Add User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-0" data-toggle="tab" href="#invite_user" role="tablist">
                            <i class="material-icons">email</i> Invite User
                        </a>
                    </li>
                </ul>
                <div class="tab-content tab-space tab-subcategories">
                    <div class="tab-pane active" id="add_person">
                        <form id="editForm" action="{{ route('invoice.admin.users_store') }}" method="POST">
                            @csrf
                            <div class="card ">
                                <div class="card-header card-header-{{ $sidebar->filters }} card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">person_add</i>
                                    </div>
                                    <h4 class="card-title">Register Form</h4>
                                </div>
                                <div class="card-body mt-3">
                                    <div class="form-group">
                                        <label for="name" class="bmd-label-floating"> Full Name *</label>
                                        <input type="text" class="form-control" name="name" id="name" required>
                                    </div>
                                    <div class="form-group email">
                                        <label for="email" class="bmd-label-floating"> Email Address *</label>
                                        <input type="email" class="form-control" name="email" id="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="bmd-label-floating"> Password *</label>
                                        <input type="password" class="form-control" id="password" required name="password">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password" class="bmd-label-floating"> Confirm Password *</label>
                                        <input type="password" class="form-control" id="confirm_password" equalTo="#password" name="password_confirmation" required >
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="button" class="btn btn-{{ $sidebar->filters }} regBtn">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="invite_user">
                        <form action="{{ route('invoice.admin.users_invite') }}" method="POST" id="inviteForm">
                            @csrf
                            <div class="card">
                                <div class="card-header card-header-{{ $sidebar->filters }} card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">mail_outline</i>
                                    </div>
                                    <h4 class="card-title">Invite User</h4>
                                </div>
                                <div class="card-body mt-3">
                                    <div class="form-group invite_email">
                                        <label for="invite_email" class="bmd-label-floating"> Email *</label>
                                        <input type="text" class="form-control" name="invite_email" id="invite_email" required>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="button" class="btn btn-{{ $sidebar->filters }} inviteBtn">Invite</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <input type="hidden" id="route" data-route-checkEmail="{{ route('invoice.admin.users_check_email') }}">
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
@endsection