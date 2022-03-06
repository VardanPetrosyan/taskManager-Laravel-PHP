@extends('invoice._layouts.desc')
@section('page-name', 'Create Fill')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form action="{{ route('invoice.admin.desc_store_fill') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">mail_outline</i>
                            </div>
                            <h4 class="card-title">Create Fill</h4>
                        </div>
                        <div class="card-body mt-3">
                            <div class="form-group bmd-form-group @if($errors->has('name')) has-danger @endif">
                                <label for="name" class="bmd-label-floating"> Fill Name *</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                                @if($errors->has('name'))
                                    <label id="name-error" class="error" for="name">{{$errors->first('name')}}</label>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-rose">Create</button>
                        </div>
                    </div>
                    <input type="hidden" name="slug" id="slug" value="">
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    

    <input type="hidden" id="route" data-slug="{{ route('invoice.admin.desc.url_slug') }}">
    @if(!empty($question))
        <input type="hidden" id="restoreFill"
               data-question="{{ $question }}"
               data-id="{{ $id }}"
               data-restore-route="{{ route('invoice.admin.desc.fill.restore') }}"
               data-create-route="{{ route('invoice.admin.desc.fill.force_delete_create') }}"
               data-reload-route="{{ route('invoice.admin.desc_all_fill') }}">
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/desc/js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('invoices/admin/desc/js/myScript.js ') }}"></script>
    @if(!empty($question))
        <script>
            $(function () {
                document.getElementById('restoreFill').click();
            })
        </script>
    @endif
@endsection