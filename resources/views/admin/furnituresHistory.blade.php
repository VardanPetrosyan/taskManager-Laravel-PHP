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


    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-12'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="lh-1 margined-header">

                                    </h4>

                                </div>

                                <div class="col-sm-6">
                                    <form action="{{route('admin_furniture_history')}}" method="get">
                                        <div class="col-sm-6" style="text-align: center;">
                                            <input type="text" name="filterByDate" id="filter-date"
                                                   style="height: 29px; border-radius: 5px"
                                                   class="form-control">
                                        </div>
                                        <div class="col-sm-3">
                                            <select name="UsersView" id="UsersView" class="form-control float-right"
                                                    style="width: 175px; height: 33px;">
                                                <option value="" selected hidden>Պատասխանատու</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="filter" class="float-right ml-3">
                                                <input type="submit" value="Տեսնել" id="filter" class="btn btn-dark">
                                            </label>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="layer w-200">
                            <div class="peers ai-sb fxw-nw">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Անուն</th>
                                        <th>Տիպ</th>
                                        <th>Նկարագր.</th>
                                        <th>Պատասխանատու</th>
                                        <th>Բաժին</th>
                                        <th>Պատվիրող Բաժին</th>
                                        <th>Քանակ</th>
                                        <th>Օր</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($history as $product)

                                        <tr>
                                            <td class="fw-600">{{ $product->name }}</td>
                                            <td class="fw-600">{{ $product->typeName }}</td>
                                            <td class="fw-600">{{ $product->description }}</td>
                                            <td class="fw-600">{{ $product->user['name'] }}</td>
                                            <td class="fw-600">{{ $product->categoryStructure['category'] }}</td>
                                            @if($product->receiver_categoryStructure_id  != 0)
                                                <td class="fw-600">{{ $product->receiver['category']  }}</td>
                                            @else
                                                <td class="fw-600"></td>
                                            @endif

                                            <td class="fw-600">{{ $product->count }}</td>
                                            <td class="fw-600">{{ $product->created_at }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <a id="download" href="{{ route('export_furnitures_history') }}" class="btn btn-info" style="background:#5CB85C;border:#5CB85C"
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset('admin/js/fastselect/script.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/fastselect/standalone.min.js') }}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $('input[name="filterByDate"]').daterangepicker();

            $(".fstQueryInput").attr('placeholder', 'Ընտրել տարբերակ');
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
        $("#avatar").on('change', function () {
            $(this).prev().removeClass('none');
        });
        $(document).ready(function () {
            $('#UsersView').select2();
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
