@extends('invoice._layouts.admin')
@section('page-name', 'All Users')

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
                            <h4 class="card-title">Users Table</h4>
                        </div>
                        <div class="d-flex">
                            <div class="card-icon add removeBtnUser " style="background: red;display: none" data-target="#confirmDelete" data-title="Delete User" data-message="Are you sure you want to delete this user ?">
                                @include('invoice._layouts.delete_confirm', ['projects'=>$projects,'task'=>$task,'settings'=>$settings,'taskuser'=>$taskuser,'taskSetting'=>$taskSetting,'users'=>$users])
                                <a href="javascript:;"  class="text-white" ><i class="material-icons">delete_outline</i></a>
                            <div class="removeBtnUser_test"></div>
                            </div>
                            <div class="card-icon add">
                                <a href="{{ route('invoice.admin.users_create') }}" class="text-white"><i class="material-icons">add</i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table"id="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th width="40"></th>
                                        <th>Avatar</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th class="text-right"  width="40">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $i => $user)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input id="form-check-input_{{$user->id}}" class="form-check-input " @if(count($user->taskUsers)>0) value="{{$user->id}}"onclick="has_or_not_task($(this),'{{count($user->taskUsers)}}','{{$user->name}}')"@endif type="checkbox" data-id="{{ $user->id }}">
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('invoice.admin.users_edit', ['id' => $user->id]) }}"><img src="{{ asset($user->img) }}" alt="" width="50"></a>
                                        </td>
                                        <td><a href="{{ route('invoice.admin.users_edit', ['id' => $user->id]) }}">{{ $user->name }}</a></td>
                                        <td>{{ $user->email }}</td>
                                        <td class="td-actions">
                                            <a  class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">settings</i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                                <a href="{{ route('invoice.admin.users_edit', ['id' => $user->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0">
                                                    <i class="material-icons">edit</i>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                {{-- <form action="{{ route('invoice.admin.users_delete', ['id' => $user->id]) }}" method="POST">
                                                    @csrf
                                                    @method("DELETE") --}}
                                                
                                                    <button  type="button" rel="tooltip" style="width: 98%;" data-user-id="{{$user->id}}" class="delete_btn dropdown-item btn btn-danger btn-link pl-0">
                                                        <i class="material-icons">delete_outline</i>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete
                                                    </button>
                                                    
                                                {{-- </form> --}}
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <h3>No people to show</h3>
                                        </td>
                                    </tr>
                                @endforelse
                                
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="route" data-route-remove="{{ route('invoice.admin.users_remove') }}">
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
@endsection
