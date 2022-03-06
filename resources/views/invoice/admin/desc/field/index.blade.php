@extends('invoice._layouts.desc')
@section('page-name', $page_name)

@section('styles')
    <style>
        .card .card-header .add {
            border-radius: 50%;
            width: 40px;
            padding: 0;
            height: 40px;
            text-align: center;
            line-height: 40px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-{{ $sidebar->filters }} card-header-icon d-flex justify-content-between align-items-center">
                        <div style="width: 200px;">
                            <div class="card-icon">
                                <i class="material-icons">assignment</i>
                            </div>
                            <h4 class="card-title">Fields Table</h4>
                        </div>
                        <div class="d-flex">
                            <div id="removeFields" class="removeField card-icon add" style="background: red;display: none">
                                <a href="javascript:;"  class="text-white" ><i class="material-icons">delete_outline</i></a>
                                <div id="deleteFields"></div>
                            </div>
                            <div class="card-icon add mb-4">
                                <a href="{{ route('invoice.admin.desc.fill_create_field', ['slug' => request()->route('slug')])}}" class="text-white"><i class="material-icons">add</i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-center" width="70">#</th>
                                    <th width="40"></th>
                                    <th>Name</th>
                                    <th class="text-right"  width="40">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($fields as $i => $field)
                                    <tr class="data" data-id = "field{{$field->id}}">
                                        <td class="index text-center">{{ ($fields->currentPage()-1)*$fields->perPage()+(++$i) }}</td>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" data-id="{{$field->id}}">
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </td> 
                                        <td><a href="{{ route('invoice.admin.desc.fill.field_data', ['slug' => request()->route('slug'),'field_slug' => $field->slug]) }}">{{ $field->name }}</a></td>
                                        <td class="td-actions">
                                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">settings</i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right px-1" aria-labelledby="navbarDropdownProfile">
                                                <a href="{{ route('invoice.admin.desc.fill_edit_field', ['slug' => request()->route('slug'), 'id' => $field->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0">
                                                    <i class="material-icons ml-3">edit</i>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit
                                                </a>
                                                <div class="dropdown-divider"></div>

                                                    <button type="button" style="width: 100%; " class="removeField dropdown-item btn btn-danger btn-link pl-0" data-id="{{$field->id}}">
                                                        <i class="material-icons ml-3">delete_outline</i>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete
                                                    </button>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <h3>No field to show</h3>
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $fields->links() }}
                            </div>

                            <form id="deleteFieldsForm" action="{{ route('invoice.admin.desc.fill_delete_field', ['slug' => request()->route('slug'),'page'=> $fields->currentPage()]) }}" method="POST">
                                @csrf 
                                <input type="hidden" class="ids" name="ids[]">
                                <input type="hidden" name="count" value="{{$fields->count()}}">
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="route" data-route-remove="{{ route('invoice.admin.desc.fill_delete_field', ['slug' => request()->route('slug')]) }}">
@endsection
@section('scripts')
    <script src="{{ asset('invoices/admin/desc/js/myScript.js ') }}"></script>
@endsection