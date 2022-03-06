@extends('invoice._layouts.admin')
@section('page-name', 'Projects')

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
            <div class="col-lg-12 col-md-11 col-sm-11 col-11">
                <form class="navbar-form">
                    <div class="input-group no-border">
                        <input type="text" id="search" class="form-control" placeholder="Search...">
                        <button type="submit" class="btn btn-white btn-round btn-just-icon">
                            <i class="material-icons">search</i>
                            <div class="ripple-container"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-{{ $sidebar->filters }} card-header-icon d-flex justify-content-between align-items-center">
                        <div style="width: 200px;">
                            <div class="card-icon">
                                <i class="material-icons">assignment</i>
                            </div>
                            <h4 class="card-title">Projects Table</h4>
                        </div>
                        <div>
                            <div class="card-icon add" style="margin-right: -15px;">
                                <a href="{{ route('invoice.admin.project_create') }}" class="text-white">
                                    <i class="material-icons">add</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="50" class="text-center">#</th>
                                    <th width="80">Logo</th>
                                    <th width="80">ID</th>
                                    <th width="150">Name</th>
                                    <th class="text-center" style="padding-right: 100px">Users</th>
                                    <th class="text-right" width="40">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($projects as $i => $project)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>
                                            <a href="{{ route('invoice.admin.project_show', ['id' => $project->id]) }}"><img src="{{ asset($project->logo) }}" alt="" width="50"></a>
                                        </td>
                                        <td>{{ $project->abbreviation }}-{{ $project->start_abbreviation_number }}</td>
                                        <td><a href="{{ route('invoice.admin.project_show', ['id' => $project->id]) }}">{{ $project->name }}</a></td>
                                        <td class="text-center" style="padding-right: 100px">
                                            @foreach($project->projectUsers as $projUs)
                                                <img src="{{ asset($projUs->users->img) }}" alt="" class="mr-2" style="width: 40px; height: 40px; border-radius: 5px" title="{{ $projUs->users->name }}">
                                            @endforeach
                                        </td>
                                        <td>
                                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons">settings</i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                                <a href="{{ route('invoice.admin.project_team', ['id' => $project->id]) }}" rel="tooltip" class="dropdown-item btn btn-info btn-link pl-0">
                                                    <i class="material-icons">people</i>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Team
                                                </a>
                                                <a href="{{ route('invoice.admin.project_edit', ['id' => $project->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0">
                                                    <i class="material-icons">edit</i>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit
                                                </a>
                                                <a href="{{ route('invoice.admin.project_fields', ['id' =>$project->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0">
                                                    <i class="material-icons">edit</i>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fields
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('invoice.admin.project_delete', ['id' => $project->id]) }}" method="POST">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit" rel="tooltip" style="width: 98%; " class="dropdown-item btn btn-danger btn-link pl-0">
                                                        <i class="material-icons">delete_outline</i>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <h3>No project to show</h3>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{ $projects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="route" data-route-search="{{ route('invoice.admin.project_search') }}"
                                    data-route-show="{{ route('invoice.admin.project_show', ['id' => '#ID#']) }}"
                                    data-route-edit="{{ route('invoice.admin.project_edit', ['id' => '#ID#']) }}"
                                    data-route-delete="{{ route('invoice.admin.project_delete', ['id' => '#ID#']) }}"
                                    data-route-team="{{ route('invoice.admin.project_team', ['id' => '#ID#']) }}">
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
@endsection