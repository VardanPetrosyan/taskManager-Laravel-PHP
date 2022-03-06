@extends('_layouts.admin')
@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 45px;
            height: 27px;
            left: 99px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 2px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(18px);
            -ms-transform: translateX(18px);
            transform: translateX(18px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .without {
            display: block;
            width: 107px;
            position: relative;
            right: 98px;
            top: 3px;
        }

        #example_info {
            opacity: 0;
        }

        #example_filter > label > input {
            position: relative;
            top: 6px;
        }

        #example_length {
            position: relative;
            top: 11px;
        }

        #example_wrapper > .row:nth-child(3) {
            width: 100% !important;
        }

        .dataTables_wrapper {
            overflow: unset;
        }

        #example_wrapper > .row:nth-child(2) > .col-sm-12 {
            padding-left: 0 !important;
        }


    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h4 class="lh-1 margined-header">Ավելացնել Նոր Գույք</h4>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <form method="post" action="{{ route('admin_furniture_create') }}"
                                      enctype="multipart/form-data" style="width: 100%">
                                    @csrf
                                    {{--                                    <div class="form-group">--}}
                                    {{--                                        <div class="form-group">--}}
                                    <div class="row form-group">
                                        {{--                                                <div class="col-sm-12">--}}
                                        {{--                                                    --}}{{--<label class="col-sm-12 control-label label-to-choose" style="float:left;" for="avatar">--}}
                                        {{--                                                        --}}{{--Նկար--}}
                                        {{--                                                        --}}{{--<i class="fas fa-check selected-icon none"></i>--}}

                                        {{--                                                    --}}{{--</label>--}}
                                        {{--                                                    <label class="form-control product-img" style="height: 170px">--}}
                                        {{--                                                        <input type="file" id="avatar" name="image" class="file-aupload" style="display: none;">--}}
                                        {{--                                                        <img src="{{asset("/assets/images/photo_default_2.png")}}" />--}}
                                        {{--                                                    </label>--}}
                                        {{--                                                    <label for="without" class="switch">--}}
                                        {{--                                                        <span class="without">Առանց նկար</span>--}}
                                        {{--                                                        <input type="checkbox" id="without" name="without_image" value="without">--}}
                                        {{--                                                        <span class="slider round"></span>--}}
                                        {{--                                                    </label>--}}
                                        {{--                                                    <br>--}}
                                        {{--                                                </div>--}}
                                        <div class="col-sm-12">
                                            <label class="category">Անվանում</label>
                                            <input type="text" class="form-control" name="name">
                                            @if($errors->has('name'))
                                                <p class="alert alert-danger p-3">
                                                    {{ $errors->first('name') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    {{--                                        </div>--}}
                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            <label class="category">Կոդ</label>
                                            <input type="text" class="form-control" name="code">
                                            @if($errors->has('code'))
                                                <p class="alert alert-danger p-3">
                                                    {{ $errors->first('code') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            <label for="category">Կատեգորիա</label>

                                            <select name="category" id="category" class="form-control h-75">
                                                <option value="null" selected hidden>Ընտրել կատեգորիա</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('category'))
                                                <p class="alert alert-danger p-3">
                                                    {{ $errors->first('category') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>


                                    {{--                                        <div class="row mt-5">--}}
                                    {{--                                            <div class="col-sm-12">--}}
                                    {{--                                                <label for="price">Արժեք</label>--}}
                                    {{--                                                <input type="number" class="form-control" name="price" id="price">--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}

                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            <label for="count">Օգտագործվող քանակ</label>
                                            <input type="number" min="1" id="count" name="count" class="form-control">
                                            @if($errors->has('count'))
                                                <p class="alert alert-danger p-3">
                                                    {{ $errors->first('count') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            <label for="count">Չօգտագործվող քանակ</label>
                                            <input type="number" min="1" id="countUnnecessary" name="countUnnecessary"
                                                   class="form-control">
                                            @if($errors->has('countUnnecessary'))
                                                <p class="alert alert-danger p-3">
                                                    {{ $errors->first('countUnnecessary') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>


                                    <div id="categoryChange" class="row form-group ">
                                        <div class="select_box col-sm-12">
                                            <label for="categoriesStructure">Բաժին</label>
                                            <select name="categoriesStructure" id="categoriesStructure"
                                                    class="form-control categoryStructureSelect">
                                                <option value="" selected hidden>Ընտրել բաժին</option>
                                                @foreach($categoriesStructure as $categoryStructure)
                                                    <option value="{{ $categoryStructure->id }}">{{ $categoryStructure->category }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('categoriesStructure'))
                                                <p class="alert alert-danger p-3">
                                                    {{ $errors->first('categoriesStructure') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            <label for="responsible">Պատասխանատու</label>

                                            <select name="responsible" id="responsible" class="form-control h-75">
                                                <option value="" selected hidden>Ընտրել պատասխանատու</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}
                                                        ({{$user->schoolName }},{{$user->positionName}})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('responsible'))
                                                <p class="alert alert-danger p-3">
                                                    {{ $errors->first('responsible') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{--                                        <div class="row mt-3">--}}
                                    {{--                                            <div class="col-sm-12">--}}
                                    {{--                                                <div class="form-group">--}}
                                    {{--                                                    <label for="code">Կոդ</label>--}}
                                    {{--                                                    <input type="text" name="code" id="code" class="form-control h-50">--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}

                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            <label for="description">Նկարագիր</label>
                                            <textarea id="description" name="description"
                                                      class="form-control"></textarea>
                                            @if($errors->has('description'))
                                                <p class="alert alert-danger p-3">
                                                    {{ $errors->first('description') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{--                                    </div>--}}

                                    <div class="form-group ">
                                        <hr/>
                                        @include('flash::message')

                                        <input type="submit" value="Հաստատել" class="btn btn-success float-right">


                                    </div>


                                </form>

                            </div>
                        </div>
                        <div class="layer w-100">
                            <form action="{{ route('upload_furniture') }}" style="width: 100%"
                                  enctype="multipart/form-data" method="post">
                                @csrf
                                <hr/>
                                <p><a href="{{asset('assets/images/upload/ԳույքՆմուշը.xlsx')}}" download>Ներբեռնել Հայտի
                                        Օրինակ</a></p>
                                <p><a href="{{ route('download_id_furniture')}}"
                                      style="background: #343A40;color:white">ID-ների ցուցակ (Պատասխանատու,Կառույց)</a>
                                </p>
                                <p><a href="{{ route('download_id_category_furniture')}}"
                                      style="background: #343A40;color:white">ID-ների ցուցակ (Կատեգորիա)</a></p>
                                {{--<p><a href="{{asset('assets/images/upload/id-ner.xlsx')}}" download>Ներբեռնել ID-ների Աղյուսակ</a></p>--}}
                                <label style="display: block; border: 1px solid; height: 100px; margin-top: 20px; text-align: center;   background: #7c8695;">
                                    <input type="file" name="file" style="display:none;">
                                    <i class="fa fa-cloud-upload" style="font-size: 105px; color: black"></i>
                                </label>
                                @include('flash::message')

                                <input type="submit" value="Հաստատել" class="btn btn-success float-right mt-3">
                            </form>
                        </div>
                    </div>
                </div>

                <div class='col-md-9'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h4 class="lh-1 margined-header">
                                        @if(Request::get('filter') == 'reserve')
                                            Պատվիրված
                                        @elseif(Request::get('filter') == 'active')
                                            Ակտիվ
                                        @elseif(Request::get('filter') == 'passive')
                                            Պասիվ
                                        @else
                                            Ամբողջ գույքը
                                        @endif
                                    </h4>
                                </div>
                                <div class="col-sm-8">
                                    <form action="{{ route('admin_furniture')}}" method="get">
                                        <div class="col-sm-4">
                                            <select class="form-control float-right" name="filter" id="filter"
                                                    style="width: 175px; height: 28px">
                                                <option value="all">Ամբողջ գույքը</option>
                                                <option value="in_use" {{ 'in_use' == Request::get('filter') ? 'selected' : '' }}>
                                                    Օգտագործվում է
                                                </option>
                                                <option value="unnecessary" {{ 'unnecessary' == Request::get('filter') ? 'selected' : '' }}>
                                                    Չի օգտագործվում
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="UsersView" id="UsersView" class="form-control"
                                                    style="width: 175px; height: 33px;">
                                                <option value="" selected hidden>Պատասխանատու</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            {{--                                            <select name="UsersView"--}}
                                            {{--                                                    class="form-control"--}}
                                            {{--                                                    style="width: 175px; height: 33px;">--}}
                                            {{--                                                <option value="" selected hidden>Պատասխանատու</option>--}}
                                            {{--                                                @foreach($users as $user)--}}
                                            {{--                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
                                            {{--                                                @endforeach--}}
                                            {{--                                            </select>--}}
                                        </div>
                                        <div class="col-sm-3">
                                            <div id="categoryChangeView" class="row form-group ">
                                                <div class="select_box_view col-sm-12">
                                                    <select name="categoriesStructureView" id="csfilter"
                                                            class="form-control categoryStructureSelectView"
                                                            style="width: 175px; height: 28px;">
                                                        <option value="" selected hidden>Բաժին</option>
                                                        @foreach($categoriesStructure as $categoryStructure)
                                                            <option value="{{ $categoryStructure->id }}">{{ $categoryStructure->category }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="filter" class="float-right ml-3">
                                                <input type="submit" value="Տեսնել" id="filter" class="btn btn-dark">
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Կոդ</th>
                                        <th>Անվանում</th>
                                        <th>Կատեգորիա</th>
                                        <th>Բաժին</th>
                                        <th>Պատասխանատու</th>
                                        <th>Քանակ</th>
                                        <th>Կարգավիճակ</th>
                                        <th>Կարգավորում</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($furnitures as $product)
                                        @if($product->status == 'unnecessary')
                                            <tr style="background-color: #fbc8cd;">
                                        @else
                                            <tr>
                                                @endif

                                                {{--                                            @if(!is_null($product->image))--}}
                                                {{--                                                <td class="fw-600"><img src="{{ asset('img/products/'.$product->image) }}" alt="Logo" style="width: 110px; height: 110px;"></td>--}}
                                                {{--                                            @else--}}
                                                {{--                                                <td></td>--}}
                                                {{--                                            @endif--}}
                                                <td class="fw-600">{{ $product->code }}</td>
                                                <td class="fw-600">{{ $product->name }}</td>
                                                <td class="fw-600">{{ $product->categoryName }}</td>
                                                <td class="fw-600">{{ $product->schoolName }}</td>
                                                <td class="fw-600">{{ $product->username }}</td>
                                                <td class="fw-600">{{ $product->count }} հատ</td>
                                                @php
                                                    if($product->status == 'in_use'){
                                                        $status = 'Օգտագործվում է';
                                                    } elseif($product->status == 'unnecessary') {
                                                        $status = 'Չի օգտագործվում';
                                                    }
                                                @endphp
                                                <td class="fw-600">{{ $status }}</td>
                                                <td class="text-center">
                                                    <a title="Փոփոխել" class="btn btn-primary btn-sm"
                                                       href="{{ route('admin_furniture_edit', ['id' => $product->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @if($product->status != 'unnecessary')
                                                    <!-- Button trigger modal -->
                                                        <button type="button" title="Փոխել կարգավիճակը"
                                                                class="btn btn-danger btn-sm" data-toggle="modal"
                                                                data-target="#changeStatusModal{{$product->id}}">
                                                            <i class="far fa-star"></i>
                                                        </button>

                                                    @else
                                                        <button type="button" title="Փոխել կարգավիճակը"
                                                                class="btn btn-success btn-sm" data-toggle="modal"
                                                                data-target="#changeStatusModal{{$product->id}}">
                                                            <i class="far fa-star"></i>
                                                        </button>
                                                    @endif
                                                <!-- Modal -->
                                                    <div class="modal fade" id="changeStatusModal{{$product->id}}"
                                                         tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form id="changeStatusForm{{$product->id}}"
                                                                      action="{{ route('admin_furniture_changeStatus') }}"
                                                                      method="post">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Փոխե՞լ {{ $product->name }}-ի Կարգավիճակը </h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @if($product->status == 'in_use')
                                                                        <h6 style="text-align: left;">Օգտագործվում
                                                                            է </h6>
                                                                    @else
                                                                        <h6 style="text-align: left;">Չի
                                                                            օգտագործվում</h6>
                                                                    @endif
                                                                    <form id="changeStatusForm{{$product->id}}"
                                                                          action="{{ route('admin_furniture_changeStatus') }}"
                                                                          method="post">
                                                                        @csrf
                                                                        <div>
                                                                            <label for="count">Քանակ</label>
                                                                            <input type="hidden" name="furId"
                                                                                   value="{{$product->id}}">
                                                                            <input value="{{ $product->count }}"
                                                                                   max="{{ $product->count }}" min="1"
                                                                                   type="number" class="form-control"
                                                                                   style="width: 50px" name="count"
                                                                                   id="count">
                                                                            <span>հատ</span>
                                                                        </div>

                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Չեղարկել
                                                                    </button>
                                                                    {{--<button type="button" class="btn btn-danger">Ջնջել</button>--}}

                                                                    <button class="btn btn-success"
                                                                            >
                                                                        Հաստատել
                                                                    </button>

                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--                                                    moving--}}
                                                    {{--                                                    moving--}}
                                                    {{--                                                    moving--}}
                                                    {{--                                                    moving--}}
                                                    <a title="ՏԵղափոխել" class="btn btn-warning btn-sm"
                                                       href="{{ route('admin_furniture_transfer', ['id' => $product->id]) }}">
                                                        <i class="fa fa-random"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                {{--dasdasdasdsa--}}
                                                <!-- Button trigger modal -->
                                                    <button type="button" title="Ջնջել" class="btn btn-danger btn-sm"
                                                            data-toggle="modal" data-target="#delModal{{$product->id}}">
                                                        <i class="far fa-times-circle"></i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="delModal{{$product->id}}" tabindex="-1"
                                                         role="dialog" aria-labelledby="exampleModalLabel"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Ջնջե՞լ {{ $product->name }}</h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="delForm{{$product->id}}"
                                                                          action="{{ route('admin_furniture_delete') }}"
                                                                          method="post">
                                                                        @csrf
                                                                        <div>
                                                                            <label for="count">Քանակ</label>
                                                                            <input type="hidden" name="furId"
                                                                                   value="{{$product->id}}">
                                                                            <input value="{{ $product->count }}"
                                                                                   max="{{ $product->count }}" min="1"
                                                                                   type="number" class="form-control"
                                                                                   style="width: 50px" name="count"
                                                                                   id="count">
                                                                            <span>հատ</span>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Չեղարկել
                                                                    </button>
                                                                    {{--<button type="button" class="btn btn-danger">Ջնջել</button>--}}
                                                                    <a title="Delete" class="btn btn-danger"
                                                                       onclick="document.getElementById('delForm{{$product->id}}').submit()">Ջնջել</a>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <a id="download" href="{{ route('export_furnitures') }}" class="btn btn-info"
                               style="background:#5CB85C;border:#5CB85C"
                               target="_blank">Արտահանել ցանկը Excel</a>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw float-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#csfilter').select2();
        });
        $(document).ready(function () {
            $('#responsible').select2();
        });
        $(document).ready(function () {
            $('#UsersView').select2();
        });
        $(document).ready(function () {
            $('#filter').select2();
        });
        $(document).on('change', '.categoryStructureSelect', function (e) {
            $(this).parents('.select_box').nextAll().remove();
            let changeId = e.target.value;
            $(`#test_${changeId}`).remove();

            $.get('/admin/changeSelect/' + changeId, function (data) {
                if (data.length !== 0) {
                    $('#categoryChange').append(`<div id="test_${changeId}" class="select_box col-sm-12"></div>`);
                    $(`#test_${changeId}`).append(`<label for="${changeId}_sel"><b>Ենթաբաժին</b></label>`);
                    $(`#test_${changeId}`).append(`<select id="${changeId}_sel" name="categoriesStructure" class="form-control categoryStructureSelect"></select>`);
                    $(`#${changeId}_sel`).append(`<option value='${changeId}' selected hidden>Ընտրել ենթաբաժին</option>`);
                    for (let category of data) {
                        $(`#${changeId}_sel`).append(`<option value="${category.id}">${category.category}</option>`);
                    }
                }
            });
        });
        $(document).on('change', '.categoryStructureSelectView', function (e) {
            $(this).parents('.select_box_view').nextAll().remove();
            let changeId = e.target.value;
            $(`#testView_${changeId}`).remove();

            $.get('/admin/changeSelect/' + changeId, function (data) {
                if (data.length !== 0) {
                    $('#categoryChangeView').append(`<div id="testView_${changeId}" class="select_box col-sm-12"></div>`);
                    $(`#testView_${changeId}`).append(`<label for="${changeId}_selView"><b>Ենթաբաժին</b></label>`);
                    $(`#testView_${changeId}`).append(`<select id="${changeId}_selView" name="categoriesStructureView" class="form-control categoryStructureSelectView"></select>`);
                    $(`#${changeId}_selView`).append(`<option value='${changeId}' selected hidden>Ընտրել ենթաբաժին</option>`);
                    for (let category of data) {
                        $(`#${changeId}_selView`).append(`<option value="${category.id}">${category.category}</option>`);
                    }
                }
            });
        });

        $('#example').DataTable({
            "order": [],
            initComplete: function () {
                const textNodeSearch = $("#example_filter").children().contents().filter(function () {
                    return this.nodeType == 3; // Node.TEXT_NODE;
                }).get(0);

                textNodeSearch.data =
                    textNodeSearch.nodeValue =
                        textNodeSearch.textContent =
                            textNodeSearch.wholeText =
                                "Որոնել";

                const textItems = $("#example_length").children().contents().filter(function () {
                    return this.nodeType == 3; // Node.TEXT_NODE;
                });

                const textNodeShow = textItems.get(0);

                textNodeShow.data =
                    textNodeShow.nodeValue =
                        textNodeShow.textContent =
                            textNodeShow.wholeText =
                                "Ցուցադրել";


                const textNodeItems = textItems.get(1);

                textNodeItems.data =
                    textNodeItems.nodeValue =
                        textNodeItems.textContent =
                            textNodeItems.wholeText =
                                "";
            }
        });
        $("#avatar").on('change', function () {
            $(this).prev().removeClass('none');
        });

        $('file-aupload').onchange(function (event) {
            alert();
            console.log(event);
        });


    </script>
@stop
