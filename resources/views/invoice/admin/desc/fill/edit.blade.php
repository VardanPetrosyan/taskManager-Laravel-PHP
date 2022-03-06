@extends('invoice._layouts.desc')
@section('page-name', 'Update Fill')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form action="{{ route('invoice.admin.desc_update_fill', ['id' => $fill->id]) }}" method="POST">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">mail_outline</i>
                            </div>
                            <h4 class="card-title">Update Fill</h4>
                        </div>
                        <div class="card-body mt-3">

                            <div class="form-group bmd-form-group @if($errors->has('name')) has-danger @endif">
                                <label for="name" class="bmd-label-floating"> Fill Name *</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') ? old('name') : $fill->name }}">
                                @if($errors->has('name'))
                                <label id="name-error" class="error" for="name">{{$errors->first('name')}}</label>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-rose">Update</button>
                        </div>
                    </div>
                    <input type="hidden" name="slug" id="slug" value="">
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <input type="hidden" id="route" data-slug="{{ route('invoice.admin.desc.url_slug') }}">
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/desc/js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('invoices/admin/desc/js/myScript.js ') }}"></script>
@endsection
