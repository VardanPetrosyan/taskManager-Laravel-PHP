@extends('invoice._layouts.admin')
@section('page-name', 'Edit User Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('invoices/admin/css/myStyle.css') }}">
    <style>
        .card .card-header .add {
            border-radius: 50%;
            width: 40px;
            padding: 0;
            height: 40px;
            text-align: center;
            line-height: 40px;
        }
        .disable {
            pointer-events: none;

        }
        .removeUserInProject {
            display: none;
        }
    </style>
@endsection

@section('content')
    @if($message = Session::get('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
            <span>{{ $message }}</span>
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 mt-4">
                <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addMember">Projects: &nbsp;&nbsp;&nbsp;<span class="projects_count">{{ count($projects) }}</span></button>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header card-header-icon card-header-{{ $sidebar->filters }} d-flex justify-content-between align-items-center">
                        <div style="width: 200px;">
                            <div class="card-icon">
                                <i class="material-icons">perm_identity</i>
                            </div>
                            <h4 class="card-title">Edit Profile
                            </h4>
                        </div>
                        <div>
                            <div class="card-icon add">
                                <a href="javascript:;" class="text-white taskEditBtn"><i class="material-icons">edit</i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('invoice.admin.users_update', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data" id="editForm">
                            @csrf
                            <div class="row">
                                <div class="col-xl-3 col-lg-5 col-md-5 col-sm-5 text-center">
                                    <div class="preview disabled">
                                        <label for="image" class="preview_image">
                                            <span>Drag & Drop your files or <a href="javascript:;">Browse</a></span>
                                            <img src="{{ asset($user->img) }}" style="display: block" alt="">
                                            <div></div>
                                        </label>
                                        <div class="image_action">
                                            <button class="image_x" type="button">
                                                <i class="material-icons">delete_outline</i>
                                            </button>
                                        </div>
                                        <input type="file" class="d-none" name="image" id="image" accept="image/x-png,image/jpeg">
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-7 col-md-7 col-sm-7">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Username *</label>
                                            <input type="text" name="name" class="form-control"
                                                   value="{{ $user->name }}" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-5">
                                        <div class="form-group">
                                            <label class="bmd-label-floating">Email address *</label>
                                            <input type="email" name="email" class="form-control"
                                                   value="{{ $user->email }}" disabled required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-{{ $sidebar->filters }} pull-right d-none profileUpdateBtn">Update Profile</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
    <div class="modal fade modal-mini modal-primary" id="addMember" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-small">
            <div class="modal-content">
                <div class="modal-header">
                    <span>All Projects</span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-search">
                        @foreach($projects as $project)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" data-id="{{ $project->project_id }}">
                                    <img src="{{ asset($project->projects->logo) }}" alt="" width="30" style="margin-left: 5px; margin-right: 5px">
                                    <a href="{{ route('invoice.admin.project_show', ['id' => $project->project_id]) }}">{{ $project->projects->name }}</a>
                                    <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-sm removeUserInProject">Remove</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="route" data-route-removeUserInProject="{{ route('invoice.admin.user_in_project') }}">
    <input type="hidden" id="user_id" data-id="{{ $user->id }}">
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
    <script src="{{ asset('invoices/admin/js/imageUpload.js') }}"></script>
@endsection