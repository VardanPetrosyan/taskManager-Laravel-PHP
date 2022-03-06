@extends('invoice._layouts.desc')
@section('page-name', 'Update Field')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form action="{{ route('invoice.admin.desc.fill_update_field', ['slug'=>request()->route('slug'),'id' => $field->id]) }}" method="POST">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">mail_outline</i>
                            </div>
                            <h4 class="card-title">Update Field</h4>
                        </div>
                        <div class="card-body mt-3">
                            <div class="form-group bmd-form-group @if($errors->has('name')) has-danger @endif">
                                <label for="name" class="bmd-label-floating"> Field Name *</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') ? old('name') : $field->name }}">
                                @if($errors->has('name'))
                                    <label id="name-error" class="error" for="name">{{$errors->first('name')}}</label>
                                @endif
                            </div>
                            <div class="form-group bmd-form-group @if($errors->has('unit')) has-danger @endif">
                                <label for="unit" class="bmd-label-floating">Unit Name *</label>
                                <input id="unit" type="text" class="form-control" name="unit" value="{{ old('unit') ? old('unit') : $field->unit}}">
                                @if($errors->has('unit'))
                                    <label id="unit-error" class="error" for="unit">{{$errors->first('unit')}}</label>
                                @endif
                            </div>
                            @if($field->add_prop)
                            <div class="form-group bmd-form-group @if($errors->has('property')) has-danger @endif">
                                <label for="property" class="bmd-label-floating"> Property Name *</label>
                                <input id="property" type="text" class="form-control" name="property" value="{{ old('property') ? old('property') : $field->add_prop}}">
                                @if($errors->has('property'))
                                    <label id="property-error" class="error" for="property">{{$errors->first('property')}}</label>
                                @endif
                            </div>
                            @endif
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
    <input type="hidden" id="route" data-slug="{{ route('invoice.admin.desc.url_field_slug') }}">
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/desc/js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('invoices/admin/desc/js/myScript.js ') }}"></script>
@endsection
