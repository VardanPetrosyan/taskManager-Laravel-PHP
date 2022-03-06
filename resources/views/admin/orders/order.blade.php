@extends('_layouts.admin')
@section('content')
    <style>
        .fstMultipleMode .fstControls {
            width: 35rem !important;
        }

        .fstMultipleMode .fstQueryInput {
            font-size: 1.1em !important;
        }

        .order-select {
            width: 100%;
            position: absolute;
            top: 24px;
            right: -45px;
        }

        #example_info {
            width: 447px !important;
            opacity: 0;
        }

        #example_length {
            position: relative;
            top: 11px;
        }

        #example_filter input {
            position: relative;
            top: 9px;
        }

        @media screen and (max-width: 1349px) {
            .fstMultipleMode .fstControls {
                width: 30rem !important;
            }
        }

        @media screen and (min-width: 875px) and (max-width: 1106px) {
            .fstMultipleMode .fstControls {
                width: 25rem !important;
            }
        }

        @media screen and (max-width: 875px) {
            .fstMultipleMode .fstControls {
                width: 21rem !important;
            }
        }

        @media screen and (max-width: 750px) {
            .fstMultipleMode .fstControls {
                width: 19rem !important;
            }
        }

        @media screen and (max-width: 666px) {
            .fstMultipleMode .fstControls {
                width: 16rem !important;
            }
        }

        @media screen and (max-width: 1189px) {
            .order-select {
                right: -15px;
            }

            .fstMultipleMode .fstQueryInput {
                font-size: 0.9em !important;
            }
        }

        @media screen and (max-width: 874px) {

            .fstMultipleMode .fstQueryInput {
                font-size: 0.9em !important;
            }

            .time {
                float: left !important;
            }
        }

        @media screen and (max-width: 575px) {
            .fstMultipleMode .fstControls {
                width: 53rem !important;
            }
        }

        .hr {
            margin: 5px 0;
        }

        .accordion-group {
            margin-bottom: 10px;
            border-radius: 0;
        }

        .accordion-toggle {
            background: rgb(248, 251, 252);

        }

        .accordion-toggle:hover {
            text-decoration: none;

        }

        .accordion-heading .accordion-toggle {
            display: block;
            padding: 8px 15px;
        }


        .selectStyle {
            width: 46%;
            float: left;
            margin-right: 8%;
        }


        .accordion-group {
            margin-bottom: 20px;
        }
    </style>

    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-12'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <div class="row">
                                <div class="row" style="width: 100% !important">

                                    <div class="col-sm-6" style="text-align: center;">
                                        <p><b>Օգտատեր</b></p>
                                        <select class="userSelect" multiple name="filterByUser[]" id="user"
                                                style="height: 48px;">
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-6" style="text-align: center;">
                                        <p><b>Ժամանակահատված</b></p>
                                        <input type="text" name="filterByDate" id="filter-date"
                                               style="height: 48px; border-radius: 0px"
                                               class="form-control">
                                    </div>

                                    {{--<div class="col-sm-4" style="position: relative !important;">--}}
                                    {{--<label for="filter-status" id="order-type" style="float: right;" class="time">Պատվերների տեսակ</label>--}}
                                    {{--<div class="order-select">--}}
                                    {{--<select name="filterByStatus[]" multiple id="filter-status" class="statusSelect">--}}
                                    {{--<option value="orders">Պատվերներ</option>--}}
                                    {{--<option value="claim-orders">Պահանջագրով պատվերներ</option>--}}
                                    {{--</select>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid">
                            <ul class="nav nav-tabs">
                                <li class="nav-item orderTabs ">
                                    <a class="nav-link active" data-value="orders" href="#" >Պատվերներ</a>
                                </li>
                                <li class="nav-item orderTabs">
                                    <a class="nav-link" data-value="claim-orders" href="#">Պահանջագրով Պատվերներ</a>
                                </li>
                            </ul>
                        </div>


                        <div class="layer w-200">
                            <div class="peers ai-sb fxw-nw">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Օգտատերի անուն</th>
                                        <th>Պատվերի ժամկետ</th>
                                        <th>Ավելին</th>
                                    </tr>
                                    </thead>
                                    {{--@dd($orderDetails)--}}
                                    <tbody id="order-info">


                                    @foreach($orderDetails as $order)

                                        @if( $order->isseen == 0)
                                            <tr  style="background-color:skyblue" data-row-order-id="{{ $order->id }}">
                                                <td style="width: 250px;">{{ $order->id }}</td>
                                                <td style="width: 250px;">{{ $order->userName }}</td>
                                                <td style="width: 250px;">{{$order->created_at}}
                                                    - {{$order->date_while }}</td>
                                                <td><a href="{{ route('admin_order_detail', ['id' => $order->id]) }}"
                                                       class="btn btn-dark">Տեսնել ավելին</a></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    @foreach($orderDetails as $order)

                                        @if( $order->isseen != 0)

                                            <tr  data-row-order-id="{{ $order->id }}">
                                                <td style="width: 250px;">{{ $order->id }}</td>
                                                <td style="width: 250px;">{{ $order->userName }}</td>
                                                <td style="width: 250px;">{{$order->created_at}}
                                                    - {{$order->date_while }}</td>
                                                <td>
                                                    <a href="{{ route('admin_order_detail', ['id' => $order->id]) }}"
                                                       class="btn btn-dark">Տեսնել ավելին</a></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div style="float:left">
                                <a id="download" href="{{ route('admin_order_excel') }}" class="btn btn-info"
                                   target="_blank">Արտահանել հաշվետվություն</a>
                            </div>

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


    <div class="container" style="min-height: 250px">

    </div>
    <input type="hidden" class="route" value="{{route("admin_order_filter")}}">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="modal" id="modalEditOrder" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="top: unset !important">
                <div class="modal-header">
                    <h5 class="modal-title">Կարգավորել</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin_order_status_update')}}" method="post" id="edit-form">
                        @csrf
                        <input type="hidden" name="order_id" id="data-order-id"/>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <span class="control-label">Քանակ (<span id="data-unit-name"></span>)</span>
                                    <input type="text" name="count" id="data-quantity" class="form-control h-75">
                                </div>
                                <div class="col-sm-6">
                                    <span class="control-label">Կարգավիճակ</span>
                                    <select name="status" id="data-status" class="form-control h-75">
                                        <option value="{{ \App\Models\Orders::STATUS_CANCELED_BY_ADMIN }}">Մերժվել է
                                            ադմինի կողմից
                                        </option>
                                        <option value="{{ \App\Models\Orders::STATUS_PENDING }}">Ընթացքում է</option>
                                        <option value="{{ \App\Models\Orders::STATUS_COMPLETE }}">Ավարտված</option>
                                        <option value="{{ \App\Models\Orders::STATUS_CANCELED_BY_CUSTOMER }}">Մերժվել է
                                            հաճախորդի կողմից
                                        </option>
                                        <option value="{{ \App\Models\Orders::STATUS_ARCHIVE }}">Արխիվ</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-success float-right" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@stop
@section('script')
{{--    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>--}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset('admin/js/fastselect/script.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/fastselect/standalone.min.js') }}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            setTimeout(function () {
                $("#user").on('change', ajax);
                $("#filter-date").on('change', ajax);
            }, 500);

            $('.orderTabs').on('click', function () {
                $('.orderTabs').children().removeClass('active');
                $(this).children().eq(0).addClass('active');
                ajax();

            });


            $('#download').attr('href', 'order/excel?user_Id=' + $("#user").val());
        });

        function ajax() {
            var type = [$('.orderTabs .active').data('value')];
            var user = $("#user").val();
            var date = $("#filter-date").val();
            var data = {'type': type, 'user': user, 'date': date, _token: "{{ csrf_token() }}"};
            // console.log('date:', date);
            $.ajax({
                url: "{{ route('admin_order_filter') }}",
                method: "POST",
                dataType: 'json',
                data: data,
                success: function (response) {
                    var html = "";
                    @if(!isset($order))
                    response.forEach(function (item, i) {
                        html += "<tr  data-row-order-id=" + item.id + ">";
                        html += "<td>" + item.id + "</td>";
                        html += "<td>" + item.userName + "</td>";
                        html += "<td>" + item.created_at + "-" + item.date_while + "</td>";
                        {{--html += "    <td><a href='{{ route('admin_order_detail', ['id' => "+item.id+"]) }}' class='btn btn-dark'>Տեսնել ավելին</a></td>";--}}
                            html += "</tr>";
                    });
                    @else
                    response.forEach(function (item, i) {
                        // console.log(item);
                        if (item.isseen == 0) {
                            html += "<tr style='background-color:skyblue'  data-row-order-id=" + item.id + ">";
                        } else {
                            html += "<tr  data-row-order-id=" + item.id + ">";
                        }
                        html += "<td>" + item.id + "</td>";
                        html += "<td>" + item.userName + "</td>";
                        html += "<td>" + item.created_at + "-" + item.date_while + "</td>";
                        html += "<td><a href='order/details/" + item.id + "' class='btn btn-dark'>Տեսնել ավելին</a></td>";
                        html += "</tr>";
                    });
//                        console.log('order/excel?user_Id='+user);

                    $('#download').attr('href', 'order/excel?user_Id=' + user + '&orderTab=' + $('.orderTabs .active').data('value') + '&orderDate=' + date);

                    @endif

                    $("#order-info").html(html);

                }
            });
        }

        // $(document).ready(function() {

        {{--$("#filter-status").on('change', function(event) {--}}
        {{--var type = $(this).val();--}}
        {{--var data = {type: type, _token:"{{ csrf_token() }}"};--}}
        {{--$.ajax({--}}
        {{--url: "{{ route('admin_order_ordinary') }}",--}}
        {{--method: "POST",--}}
        {{--dataType: "json",--}}
        {{--data: data,--}}
        {{--success: function (response) {--}}
        {{--console.log(response);--}}
        {{--var html = "";--}}
        {{--@if(!isset($order))--}}
        {{--response.forEach(function (item, i) {--}}
        {{--html += "<tr>";--}}
        {{--html += "    <td>" + item.id + "</td>";--}}
        {{--html += "    <td>" + item.userName + "</td>";--}}
        {{--html += "    <td>" + item.created_at + "</td>";--}}
        {{--html += "    <td><a href='{{ route('admin_order_detail', ['id' => $order->id]) }}' class='btn btn-dark'>Տեսնել ավելին</a></td>";--}}
        {{--html += "</tr>";--}}
        {{--});--}}
        {{--@else--}}
        {{--response.forEach(function (item, i) {--}}
        {{--html += "<tr>";--}}
        {{--html += "    <td>" + item.id + "</td>";--}}
        {{--html += "    <td>" + item.userName + "</td>";--}}
        {{--html += "    <td>" + item.created_at + "</td>";--}}
        {{--html += "    <td><a href='{{ route('admin_order_detail', ['id' => $order->id]) }}' class='btn btn-dark'>Տեսնել ավելին</a></td>";--}}
        {{--html += "</tr>";--}}
        {{--});--}}
        {{--@endif--}}


        {{--$("#order-info").html(html);--}}
        {{--}--}}
        {{--});--}}
        {{--})--}}
        {{--});--}}
        $(function () {
            $('input[name="filterByDate"]').daterangepicker();

            $(".fstQueryInput").attr('placeholder', 'Ընտրել տարբերակ');
        });
        $("#avatar").on('change', function () {
            $(this).prev().removeClass('none');
        });

        $(document).ready(function () {
            $('#example').DataTable({
                "order": [[ 0, "desc" ]],
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
        });

        $('.userSelect').fastselect();
        $('.statusSelect').fastselect();

        var lastEditOrderId = null;
        $(".button-show-modal").on("click", function (event) {
            $("#data-status").val($(this).attr("data-status"));
            $("#data-order-id").val($(this).attr("data-order-id"));
            $("#data-quantity").val($(this).attr("data-quantity"));
            $("#data-unit-name").text($(this).attr("data-unit-name"));

            lastEditOrderId = parseInt($(this).attr("data-order-id"));
            $("#modalEditOrder").modal("show");
        });

        $("#modalEditOrder").on("hide.bs.modal", function (event) {
            $("#data-status").val("");
            $("#data-order-id").val("");
            $("#data-quantity").val("");
            $("#data-unit-name").text("");
        });

        $("#edit-form").on("submit", function (event) {
            // console.log();

            event.preventDefault();

            $.ajax({
                url: $(this).attr("action"),
                method: $(this).attr("method"),
                data: $(this).serialize(),
            }).done(function (response) {
                const tr = $("tr[data-row-order-id='" + lastEditOrderId + "']");
                tr.find("[data-name='status']").text(
                    $("#data-status").find("option:selected").get(0).label
                );
                tr.find("[data-name='count']").text(
                    $("#data-quantity").val()
                );
                console.log($("#data-quantity").val());
                $("#modalEditOrder").modal("hide");
            });
        });

        $(window).on('load', function () {
            $(".fstResultItem").on('click', function () {
                $(".fstChoiceRemove").text('x');
            })

            // $("#example_filter").children().html("Որոնել։ <input type='search' class='form-control input-sm' placeholder='' aria-controls=example'>");

        });

    </script>
@stop
