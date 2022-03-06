@extends('invoice._layouts.admin')
@section('page-name', 'Create Project')
@section('styles')
    <link rel="stylesheet" href="{{ asset('invoices/admin/css/myStyle.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form id="projectForm" action="{{ route('invoice.admin.project_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-{{ $sidebar->filters }} card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">assignment</i>
                            </div>
                            <h4 class="card-title">Create Project</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <h4 class="title">Logo</h4>
                                            <div class="preview">
                                                <label for="image" class="preview_image">
                                                    <span>Drag & Drop your files or <a href="javascript:;">Browse</a></span>
                                                    <img src="" alt="">
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
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-7 col-md-7 col-sm-7 mt-5">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="project_name" class="bmd-label-floating">Project Name *</label>
                                                <input type="text" class="form-control" id="project_name" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="project_id" class="bmd-label-floating">Project ID *</label>
                                                <input type="text" class="form-control" id="project_id" name="abbreviation" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="project_number" class="bmd-label-floating">Start Number *</label>
                                                <input type="text" class="form-control" id="project_number" name="start_abbreviation_number" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="project_description" class="bmd-label-floating">Description</label>
                                                <textarea name="description" id="project_description" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="button" class="btn btn-{{ $sidebar->filters }} createBtn">Create</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
    <script src="{{ asset('invoices/admin/js/imageUpload.js') }}"></script>
    <script>
        let count = 0;
        $('.createBtn').click(function () {
            count++;
            if(count == 1) {
                $('#projectForm').submit();
            }
        })
    </script>
@endsection