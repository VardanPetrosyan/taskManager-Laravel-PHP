@extends('invoice._layouts.desc')
@section('page-name', $fill->name)

@section('styles')
    <link rel="stylesheet" href="{{ asset('invoices/admin/css/myStyle.css') }}">
    <style>
        .btn.select-with-transition,
        .btn.select-with-transition + .dropdown-menu {
            width: 420px;
        }

        .preview_image,
        .to_preview_image {
            max-width: 250px;
            height: 180px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 ml-auto mr-auto">
                <ul class="nav nav-pills nav-pills-rose nav-pills-icons justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link p-0 active" data-toggle="tab" href="#from" role="tablist">
                            <i class="material-icons">add</i> Մուտք
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-0" data-toggle="tab" href="#to" role="tablist">
                            <i class="material-icons">remove</i> Ելք
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-md-8 ml-auto mr-auto">
                <div class="tab-content tab-space tab-subcategories">
                    <div class="tab-pane active" id="from">
                        <form id="fillFrom" action="{{ route('invoice.admin.desc.create_grasexans_data', ['slug' => $fill->slug]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="from_to" value="from">
                            <div class="card ">
                                <div class="card-header card-header-rose card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">person_add</i>
                                    </div>
                                    <h4 class="card-title">From</h4>
                                </div>
                                <div class="card-body mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="bmd-label mr-4">Name: </label>
                                                <select class="selectpicker" data-style="select-with-transition" name="name" id="name" required>
                                                    <option selected disabled value=""> Select Name</option>
                                                    @foreach($grasexanNames as $name)
                                                        <option value="{{ $name->id }}">{{ $name->name }}<button class="px-2">+</button></option>
                                                    @endforeach
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="amd" class="bmd-label-floating">Amd:</label>
                                                <input type="text" id="amd" name="amd" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Date*</label>
                                                <input name="date" class="form-control datepicker" value="{{ date('d').'/'.date('m').'/'.date('Y') }}" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="notes" class="bmd-label-floating">Notes:</label>
                                                <textarea name="notes" id="notes" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-rose regBtn">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="to">
                        <form id="fillTo" action="{{ route('invoice.admin.desc.create_grasexans_data', ['slug' => $fill->slug]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="from_to" value="to">
                            <div class="card ">
                                <div class="card-header card-header-rose card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">person_remove</i>
                                    </div>
                                    <h4 class="card-title">To</h4>
                                </div>
                                <div class="card-body mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="to_preview">
                                                <label for="to_image" class="to_preview_image">
                                                    <span>Drag & Drop your files or <a href="javascript:;">Browse</a></span>
                                                    <img src="" alt="">
                                                    <div></div>
                                                </label>
                                                <div class="to_image_action">
                                                    <button class="to_image_x" type="button">
                                                        <i class="material-icons">delete_outline</i>
                                                    </button>
                                                </div>
                                                <input type="file" class="d-none" name="to_image" id="to_image"accept="image/x-png,image/jpeg">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="to_name" class="bmd-label mr-4">Name: </label>
                                                <select class="selectpicker" data-style="select-with-transition" name="to_name" id="to_name" required>
                                                    <option selected value=""> Select Name</option>
                                                    @foreach($grasexanNames as $name)
                                                        <option value="{{ $name->id }}">{{ $name->name }}</option>
                                                    @endforeach
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="to_amd" class="bmd-label-floating">Amd:</label>
                                                <input type="text" id="to_amd" name="to_amd" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Date*</label>
                                                <input name="to_date" class="form-control datepicker" value="{{ date('d').'/'.date('m').'/'.date('Y') }}" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="to_notes" class="bmd-label-floating">Notes:</label>
                                                <textarea name="to_notes" id="to_notes" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-rose regBtn">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="route" data-route-grasexansName="{{ route('invoice.admin.desc.create_grasexans_name', ['slug' => $fill->slug]) }}">
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/desc/js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('invoices/admin/desc/js/myScript.js ') }}"></script>
    <script src="{{ asset('invoices/admin/js/imageUpload.js') }}"></script>
@endsection