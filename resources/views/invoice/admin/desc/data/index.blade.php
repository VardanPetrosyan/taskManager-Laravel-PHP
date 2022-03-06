@extends('invoice._layouts.desc')
@section('page-name', $fill->name)
@section('styles')
    <link rel="stylesheet" href="{{ asset('invoices/admin/css/myStyle.css') }}">
    <style>

        .btn.select-with-transition,
        .btn.select-with-transition + .dropdown-menu {
            width: 100%;
        }

        button.bs-placeholder {
            width: 150px !important;
        }

        #addDataModal .modal-dialog {
            max-width: 520px !important;
        }

        .preview_image,
        .to_preview_image {
            max-width: 250px;
            height: 180px;
        }

        .card .card-header .add {
            border-radius: 50%;
            width: 40px;
            padding: 0;
            height: 40px;
            text-align: center;
            line-height: 40px;
        }

        .card .pay_icon {
            border-radius: 50%;
            width: 40px;
            padding: 0;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #37B42A;
            cursor: pointer;
            transition: 0.4s;
            user-select: none;
        }

        .name_dropdown .dropdown-menu {
            max-height: 280px !important;
            overflow: auto;
        }

        .img_preview_div {
            position: relative;
            margin: 3px;
        }

        .img_preview_div img {
            max-width: 160px;
            height: 60px;
        }

        .img_preview_div button {
            position: absolute;
            top: 0;
            left: 0;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
        }

        .img_preview_div .img_delete {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            outline: none;
            border: none;
            background: rgba(10, 10, 10, 0.5);
            justify-content: center;
            align-items: center;
            color: red;
            position: absolute;
            top: 2px;
            left: 3px;
            z-index: 3;
            cursor: pointer;
            transition: 0.6s;
            display: none;
        }

        .img_preview_div .img_delete i {
            font-size: 22px;
        }

        .img_preview_div:hover .img_delete {
            display: flex;
            transition: 1s;
        }

        #addDataModal label.error {
            max-width: 190px;
            width: 100%;
        }

        .card .pay_icon:hover {
            transform: scale(1.08);
            transition: 0.4s;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                {{-- <select class="selectpicker" id="selectName" data-size="4" data-style="btn btn-primary btn-round" >
                    <option value="0">Select Name</option>
                    @foreach($names as $name)
                        <option value="{{ $name->id }}" >{{ $name->name }}</option>
                    @endforeach
                </select> --}}
                <div class="form-group pb-0 my-1 bg-light">
                    @php
                        if(date('m')=='01'){
                            $date = date('Y',strtotime('-1 year')).'-12';
                        }else{
                            $date = date('Y').'-'.date('m',strtotime('-1 month'));
                        }
                    @endphp
                    <input type="month" id="dateFrom" name="date_from" class="form-control datepicker px-2" value="{{ $date }}">
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                <div class="form-group pb-0 my-1 bg-light">
                    <input type="month" id="dateTo" name="date_to" class="form-control datepicker px-2" value="{{ date('Y').'-'.date('m') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-rose card-header-icon d-flex justify-content-between align-items-center">
                        <div style="width: 260px;">
                            <div class="card-icon">
                                <i class="material-icons">assignment</i>
                            </div>
                            <h4 class="card-title">{{$field->name}}</h4>
                        </div>
                        <div>
                            <div class="card-icon add" style="margin-bottom: 20px; margin-right: 5px;">
                                <a data-toggle="modal" data-target="#addDataModal" class="text-white">
                                    <i class="material-icons">add</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-response">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Name</th>
                                            @if($field->add_prop)
                                                <th class="text-center">{{$field->add_prop}}</th>
                                            @endif
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Counter Number</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Total Payment</th>
                                            <th class="text-center">Paid</th>
                                            <th class="text-center">Debt</th>
                                            <th class="text-center">Pay</th>
                                            <th class="text-center" width="40">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($datas as $i => $data)
                                            <tr class='data' id="data{{ $data->id }}">
                                                <td class="index text-center">{{ ++$i }}</td>
                                                <td class="text-center">{{ $data->dataName->name }}</td>
                                                @if($field->add_prop)
                                                    <td class="text-center">{{ $data->addPropName->name }}</td>
                                                @endif
                                                <td class="text-center">{{ $data->date }}</td>
                                                <td class="text-center">{{ $data->counter_number}} {{$field->unit}}</td>
                                                <td class="text-center">{{ $data->unit_price }}</td>
                                                <td class="text-center">{{ $data->total_payment }}</td>
                                                <td class="data_paid text-center text-success">{{ $data->paid }}</td>
                                                <td class="data_debt text-center text-danger">{{ $data->debt }}</td>
                                                <td class="d-flex justify-content-center">
                                                    <a class="pay_icon" title="To Pay" data-id="{{$data->id}}">
                                                        <i class="material-icons text-light">attach_money</i>
                                                    </a>
                                                </td>
                                                <td class="td-actions text-center">
                                                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile"
                                                       data-toggle="dropdown"
                                                       aria-haspopup="true" aria-expanded="false">
                                                        <i class="material-icons">settings</i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right px-1"
                                                         aria-labelledby="navbarDropdownProfile">
                                                        <a href="#" class="dropdown-item btn btn-success btn-link pl-0">
                                                            <i class="material-icons ml-3">edit</i>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <button id="deleteData" type="button" style="width: 100%; "
                                                                class="dropdown-item btn btn-danger btn-link pl-0"
                                                                data-id="{{ $data->id }}">
                                                            <i class="material-icons ml-3">delete_outline</i>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="empty_data">
                                                <td colspan="8"><h3>No Data to show</h3></td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                    <div class="datas_links d-flex justify-content-center">
                                        {{ $datas->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDataModal" tabindex="-1" role="dialog" aria-labelledby="addDataModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered h-100 my-0" role="document">
            <div class="modal-content">
                <div class="modal-header py-4">
                    <!-- <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form id="addDataForm"
                          action="{{ route('invoice.admin.desc.fill.field.create_data', ['slug' => $fill->slug,'field_slug'=>$field->slug]) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card ">
                            <div class="card-header card-header-rose card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">note_add</i>
                                </div>
                                <h4 class="card-title">New Data</h4>
                            </div>
                            <div class="card-body mt-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="field_id" value="{{$field->id}}">
                                        <div class="row justify-content-between px-3 pb-1">
                                            <div class="form-group">
                                                <div class="name_dropdown">
                                                    <button type="button" class="btn btn-rose dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"><span class="pr-3">Select Name</span>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="selectName">
                                                        @foreach($names as $name)
                                                            <li id='name{{$name->id}}'
                                                                class="dropdown-item bg-rose d-flex justify-content-between py-1 pl-3 pr-2">
                                                                <span>{{$name->name}}</span>
                                                                <button class="deleteDataName btn btn-danger ml-2 py-1 px-3"
                                                                        type="button" data-id="{{$name->id}}">x
                                                                </button>
                                                            </li>
                                                        @endforeach
                                                        <li class="dropdown-divider"></li>
                                                        <li class="dropdown-item new_name" data-toggle="modal"
                                                            data-target="#addDataNameModal">Add New
                                                        </li>
                                                    </ul>
                                                </div>
                                                <input id="data_name_id" class="nameInput" type="hidden"
                                                       name="data_name_id" value="">
                                                <label id="data_name_id-error" class="error" for="data_name_id"
                                                       style="display: none;"></label>
                                                <input type="hidden" id="deleteNameRoute"
                                                       data-route="{{route('invoice.admin.desc.fill.field.delete_data_name', ['slug' => $fill->slug,'field_slug' => $field->slug])}}">
                                            </div>

                                            @if($field->add_prop)
                                                <div class="form-group">
                                                    <div class="add_prop_dropdown">
                                                        <button type="button" class="btn btn-rose dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"><span class="pr-3"
                                                                                            data-name="Select {{$field->add_prop}}">Select {{$field->add_prop}}</span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            @foreach($add_prop_names as $name)
                                                                <li id='add_prop_name{{$name->id}}'
                                                                    class="dropdown-item bg-rose d-flex justify-content-between py-1 pl-3 pr-2">
                                                                    <span>{{$name->name}}</span>
                                                                    <button class="deleteAddPropName btn btn-danger ml-2 py-1 px-3"
                                                                            type="button" data-id="{{$name->id}}">x
                                                                    </button>
                                                                </li>
                                                            @endforeach
                                                            <li class="dropdown-divider"></li>
                                                            <li class="dropdown-item new_name" data-toggle="modal"
                                                                data-target="#addAddPropNameModal">Add New
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <input class="nameInput" id="add_prop_id" type="hidden"
                                                           name="add_prop_id" value="">
                                                    <label id="add_prop_id-error" class="error" for="add_prop"
                                                           style="display: none;"></label>
                                                    <input type="hidden" id="deleteAddPropRoute"
                                                           data-route="{{route('invoice.admin.desc.fill.field.delete_add_prop_name', ['slug' => $fill->slug,'field_slug' => $field->slug])}}">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row justify-content-between px-3">
                                            <div class="form-group">
                                                <div class="d-flex flex-column">
                                                    <select class="selectpicker" data-style="select-with-transition"
                                                            name="date" id="date">
                                                        <option selected value=""> Select Month</option>
                                                        <option value="01">Հունվար</option>
                                                        <option value="02">Փետրվար</option>
                                                        <option value="03">Մարտ</option>
                                                        <option value="04">Ապրիլ</option>
                                                        <option value="05">Մայիս</option>
                                                        <option value="06">Հունիս</option>
                                                        <option value="07">Հուլիս</option>
                                                        <option value="08">Օգոստոս</option>
                                                        <option value="09">Սեպտեմբեր</option>
                                                        <option value="10">Հոկտեմբեր</option>
                                                        <option value="11">Նոյեմբեր</option>
                                                        <option value="12">Դեկտեմբեր</option>
                                                    </select>
                                                    <label id="date-error" class="error w-100" for="date"
                                                           style="display: none;"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="counter_number" class="bmd-label-floating">Counter
                                                    Number*</label>
                                                <input type="number" id="counter_number" name="counter_number"
                                                       class="form-control">
                                                <label id="counter_number-error" class="error" for="counter_number"
                                                       style="display: none;"></label>
                                            </div>

                                        </div>
                                        <div class="row justify-content-between px-3">
                                            <div class="form-group">
                                                <label for="unit_price" class="bmd-label-floating">Unit Price*</label>
                                                <input type="number" id="unit_price" name="unit_price"
                                                       class="form-control">
                                                <label id="unit_price-error" class="error" for="unit_price"
                                                       style="display: none;"></label>
                                            </div>
                                            <div class="form-group">
                                                <label for="total_payment" class="bmd-label-floating">Total
                                                    Payment*</label>
                                                <input type="number" id="total_payment" name="total_payment"
                                                       class="form-control">
                                                <label id="total_payment-error" class="error" for="total_payment"
                                                       style="display: none;"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button id="addDataBtn" type="submit" class="btn btn-rose">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDataNameModal" tabindex="-1" role="dialog" aria-labelledby="addDataNameModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered h-100 my-0" role="document">
            <div class="modal-content">
                <div class="modal-header bg-rose">
                    <h5 class="modal-title" id="addDataNameModalTitle">Add Name Option</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div class="form-group bmd-form-group">
                            <label for="data_name" class="bmd-label-floating">Name:</label>
                            <input type="text" id="data_name" class="form-control">
                            <label id="data_name-error" class="error" for="data_name" style="display: none;"></label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" id="addName" class="btn btn-success ml-2"
                            data-route="{{ route('invoice.admin.desc.fill.field.create_data_name', ['slug' => $fill->slug,'field_slug' => $field->slug]) }}">
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>
    @if($field->add_prop)
        <div class="modal fade" id="addAddPropNameModal" tabindex="-1" role="dialog"
             aria-labelledby="addAddPropNameModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered h-100 my-0" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-rose">
                        <h5 class="modal-title" id="addAddPropNameTitle">Add {{$field->add_prop}} Option</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#">
                            <div class="form-group">
                                <label for="add_prop_name" class="bmd-label-floating">Name:</label>
                                <input type="text" id="add_prop_name" class="form-control">
                                <label id="add_prop_name-error" class="error" for="add_prop_name"
                                       style="display: none;"></label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" id="addAddPropName" class="btn btn-success ml-2"
                                data-route="{{route('invoice.admin.desc.fill.field.create_add_prop_name', ['slug' => $fill->slug,'field_slug' => $field->slug])}}">
                            Add
                        </button>
                    </div>
                </div>
            </div>

        </div>
    @endif
    <div id="forAjaxModal"></div>
    <input type="hidden" id="deleteDataRoute" data-route="{{route('invoice.admin.desc.fill.field.delete_data',['slug'=>$fill->slug,'field_slug'=>$field->slug])}}">
    <input type="hidden" id="showDataRoute" data-route="{{ route('invoice.admin.desc.fill.field_data', ['slug'=>$fill->slug,'field_slug'=>$field->slug]) }}">
    <input type="hidden" id="getUnitPrice" data-route="{{ route('invoice.admin.desc.fill.field.unit_price', ['slug'=>$fill->slug,'field_slug'=>$field->slug]) }}">
    <input type="hidden" id="restore" data-route="{{ route('invoice.admin.desc.fill.restore') }}">
    <input type="hidden" id="createPayment" data-route="{{ route('invoice.admin.desc.fill.field.create_payment', ['slug'=>$fill->slug,'field_slug'=>$field->slug]) }}">
    <input type="hidden" id="filterData" data-route="{{ route('invoice.admin.desc.fill.field.filter_data', ['slug'=>$fill->slug,'field_slug'=>$field->slug]) }}">

@endsection
@section('scripts')
    <script src="{{ asset('invoices/admin/desc/js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('invoices/admin/desc/js/myScript.js ') }}"></script>
    <!-- <script src="{{ asset('invoices/admin/js/imageUpload.js') }}"></script> -->
@endsection