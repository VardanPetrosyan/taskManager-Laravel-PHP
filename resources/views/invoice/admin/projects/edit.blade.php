@extends('invoice._layouts.admin')
@section('page-name', 'Edit Project')

@section('styles')
    <link rel="stylesheet" href="{{ asset('invoices/admin/css/myStyle.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="scrolling-wrapper btn-groupe">
            <a href="{{ route('invoice.admin.project_edit', ['id' => $project->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0"><button class="card test btn active"><p>Setting</p></button></a>
            <a href="{{ route('invoice.admin.project_team', ['id' => $project->id]) }}" rel="tooltip" class="dropdown-item btn btn-info btn-link pl-0"><button class="card test btn"><p>Team</p></button></a>
            <a href="{{ route('invoice.admin.project_fields', ['id' => $project->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0"><button class="card test btn"><p>Fields</p></button></a>        
          </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header card-header-icon card-header-{{ $sidebar->filters }}">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Edit Project
                        </h4>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('invoice.admin.project_update', ['id' => $project->id]) }}" method="POST" enctype="multipart/form-data" id="editForm">
                            @csrf
                            <input type="hidden" name="old_logo" value="{{ $project->logo }}">
                            <div class="row">
                                <div class="col-xl-3 col-lg-5 col-md-5 col-sm-5 text-center">
                                    <div class="preview">
                                        <label for="image" class="preview_image">
                                            <span>Drag & Drop your files or <a href="javascript:;">Browse</a></span>
                                            <img src="{{ asset($project->logo) }}" style="display: block" alt="">
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
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="project_name" class="bmd-label-floating">Project Name *</label>
                                                <input type="text" class="form-control" id="project_name" value="{{ $project->name }}" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="project_id" class="bmd-label-floating">Project ID *</label>
                                                <input type="text" class="form-control" id="project_id" name="abbreviation" value="{{ $project->abbreviation }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="project_number" class="bmd-label-floating">Start Number *</label>
                                                <input type="text" class="form-control" id="project_number" name="start_abbreviation_number" value="{{ $project->start_abbreviation_number }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="project_description" class="bmd-label-floating">Description</label>
                                                <textarea name="description" id="project_description" class="form-control">{{ $project->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-{{ $sidebar->filters }} pull-right">Update Project</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
    <script src="{{ asset('invoices/admin/js/imageUpload.js') }}"></script>
@endsection