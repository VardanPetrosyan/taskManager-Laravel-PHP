@extends('invoice._layouts.desc')
@section('page-name', $fill->name)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{ route('invoice.admin.desc.fill_store_field',['slug' => request()->route('slug')]) }}" method="POST"  id="fillValidation"    novalidate="novalidate">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">mail_outline</i>
                            </div>
                            <h4 class="card-title">Create Field</h4>
                        </div>
                        <div class="card-body mt-3">
                            <div class="form-group bmd-form-group @if($errors->has('name')) has-danger @endif">
                                <label for="name" class="bmd-label-floating">Field Name *</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" aria-required="true">
                                @if($errors->has('name'))
                                    <label id="name-error" class="error" for="name">{{$errors->first('name')}}</label>
                                @endif
                            </div>
                            <div class="form-group bmd-form-group @if($errors->has('unit')) has-danger @endif">
                                <label for="unit" class="bmd-label-floating">Unit Name *</label>
                                <input id="unit" type="text" class="form-control" name="unit" value="{{ old('unit') }}" aria-required="true">
                                @if($errors->has('unit'))
                                    <label id="unit-error" class="error" for="name">{{$errors->first('unit')}}</label>
                                @endif
                            </div>
                            <div class="form-group bmd-form-group property @if($errors->has('property')) has-danger @endif" style="display: @if($errors->has('property') || old('property')) block @else none @endif">
                                <label for="property" class="bmd-label-floating"> Property Name *</label>
                                <input id="property" type="text" class="form-control" name="property" value="{{ old('property') }}" aria-required="true">
                                @if($errors->has('property'))
                                    <label id="property-error" class="error" for="name">{{$errors->first('property')}}</label>
                                @endif
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    Additional Property
                                    <input id="checkAddProp" class="form-check-input" type="checkbox" name="add_prop" @if($errors->has('property') || old('property')) checked @endif>
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-rose">Create</button>
                        </div>
                    </div>
                    <input type="hidden" name="slug" id="slug" value="">
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <input type="hidden" id="route" data-slug="{{ route('invoice.admin.desc.url_field_slug') }}">
    @if(!empty($question))
        <input type="hidden" id="restoreField"
            data-question="{{ $question }}"
            data-id="{{ $id }}"
            data-unit="{{ $input['unit'] }}"
            data-property="{{ $input['property'] }}"
            data-restore-route="{{ route('invoice.admin.desc.fill.restore') }}"
            data-create-route="{{ route('invoice.admin.desc.fill.force_delete_create') }}"
            data-reload-route="{{ route('invoice.admin.desc.fill_fields',['slug'=>$fill->slug]) }}">
    @endif
    @endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/desc/js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('invoices/admin/desc/js/myScript.js ') }}"></script>
    @if(!empty($question))
    <script>
        $(function(){
            document.getElementById('restoreField').click();
        })
    </script>
    @endif
    
@endsection
