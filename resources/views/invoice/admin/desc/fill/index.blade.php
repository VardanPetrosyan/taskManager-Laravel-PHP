@extends('invoice._layouts.desc')
@section('page-name', 'All Fill')

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
                    <div class="card-header card-header-rose card-header-icon d-flex justify-content-between align-items-center">
                        <div style="width: 200px;">
                            <div class="card-icon">
                                <i class="material-icons">assignment</i>
                            </div>
                            <h4 class="card-title">All Fill</h4>
                        </div>
                        <div class="d-flex">
                            <div class="card-icon add removeBtnUser " style="background: red;display: none" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
                                <a href="javascript:;"  class="text-white" ><i class="material-icons">delete_outline</i></a>
                                <div class="removeBtnUser_test"></div>
                            </div>
                            <div class="card-icon add mb-4">
                                <a href="{{ route('invoice.admin.desc_create_fill')}}" class="text-white"><i class="material-icons">add</i></a>
                            </div>
                        </div>
{{--                        <div>--}}
{{--                            <div class="card-icon add" style="margin-right: -15px;">--}}
{{--                                <a href="{{ route('invoice.admin.desc_fill_dynamic_create', ['slug' => $fill->slug]) }}" class="text-white">--}}
{{--                                    <i class="material-icons">add</i>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="40">#</th>
                                    <th width="100%">Name</th>
                                    <th class="text-right" width="40">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($allFill as $i => $fill)
                                    <tr>
                                        <td>{{ ($allFill->currentPage()-1)*$allFill->perPage()+(++$i) }}</td>
                                        <td><a href="{{ route('invoice.admin.desc.fill_fields', ['slug' => $fill->slug]) }}">{{ $fill->name }}</a></td>
                                        <td class="text-right">
                                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">settings</i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                                <a href="{{ route('invoice.admin.desc_edit_fill', ['id' => $fill->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0" data-original-title="" title="">
                                                    <i class="material-icons ml-2">edit</i>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit
                                                </a>
                                                <a href="{{ route('invoice.admin.desc.fill_fields', ['slug' => $fill->slug])}}" rel="tooltip" class="dropdown-item btn btn-rose btn-link pl-0" data-original-title="" title="">
                                                    <i class="material-icons ml-2">edit</i>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fields
                                                </a>
                                                <div class="dropdown-divider mb-1"></div>
                                                <form action="{{ route('invoice.admin.desc_delete_fill', ['id' => $fill->id,'page'=>$allFill->currentPage(), 'page_count'=>$allFill->count()]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" rel="tooltip" style="width: 94%; " class="dropdown-item btn btn-danger btn-link pl-0" data-original-title="" title="">
                                                        <i class="material-icons ml-2">delete_outline</i>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td></td>
                                        <td>
                                            <h3>No fill to show</h3>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $allFill->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection