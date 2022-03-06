@extends('invoice._layouts.admin')
@section('page-name', 'Settings')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="editForm" action="{{ route('invoice.admin.update_password', ['id' => \App\Helper\AuthHelper::user()->id]) }}" method="POST" novalidate="novalidate">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">mail_outline</i>
                            </div>
                            <h4 class="card-title">Update Password</h4>
                        </div>
                        <div class="card-body ">
                            <div class="form-group bmd-form-group">
                                <label for="old_pass" class="bmd-label-floating"> Old Password *</label>
                                <input type="password" class="form-control" id="old_pass" required="true" aria-required="true">
                            </div>
                            <div class="form-group bmd-form-group">
                                <label for="new_pass" class="bmd-label-floating"> Password *</label>
                                <input type="password" class="form-control" id="new_pass" required="true" name="password" aria-required="true">
                            </div>
                            <div class="form-group bmd-form-group">
                                <label for="conf_new_pass" class="bmd-label-floating"> Confirm Password *</label>
                                <input type="password" class="form-control" id="conf_new_pass" required="true" equalto="#new_pass" name="password_confirmation" aria-required="true">
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="button" class="btn btn-rose updatePasswordBtn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="hidden" id="route" data-check-password="{{ route('invoice.admin.check_password') }}" data-user-id="{{ \App\Helper\AuthHelper::user()->id }}">
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
@endsection