@extends('_layouts.manager')
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

    .hr{margin:5px 0;}
.accordion-group{margin-bottom:10px;border-radius:0;}
.accordion-toggle{
    background:rgb(248, 251, 252);
        
}

.accordion-toggle:hover{
    text-decoration: none;
    
}

.accordion-heading .accordion-toggle {
    display: block;
    padding: 8px 15px;
}



.selectStyle{
    width:46%; float: left; margin-right: 8%;
}


.accordion-group{
    margin-bottom:20px;
}
</style>
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-12'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <div class="row">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="lh-1 margined-header">Ֆիլտր</h4>
                                    </div>
                                </div>
                                <div class="row" style="width: 100% !important">

                                    <div class="col-sm-4">
                                        <label for="user">Օգտատեր</label>
                                        <select class="userSelect" multiple name="filterByUser[]" id="user">
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4" style="text-align: center;">
                                        <label for="filter-product" class="time">Ժամանակահատված</label>
                                        <input type="text" name="filterByDate" id="filter-date" style="height: 48px; border-radius: 0px; margin-bottom: 12px !important;" class="form-control">
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="layer w-100">
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
                                    <tbody id="order-info">
                                    {{--@dd($orderDetails)--}}
                                        @foreach($orderDetails as $order)
                                            <tr data-row-order-id="{{ $order->id }}">
                                                <td style="width: 250px;">{{ $order->id }}</td>
                                                <td style="width: 250px;">{{ $order->userName }}</td>
                                                <th style="width: 250px;">{{ $order->created_at }}</th>
                                                <td><a href="{{ route('manager_order_detail', ['id' => $order->id]) }}" class="btn btn-dark">Տեսնել ավելին</a></td>
                                             </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a id="download" href="{{ route('manager_order_excel') }}" class="btn btn-info" target="_blank">Ներբեռնել հաշվետվություն</a>
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
				<input type="hidden" name="order_id" id="data-order-id" />

				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<span class="control-label">Քանակ (<span id="data-unit-name"></span>)</span>
							<input type="text" name="count" id="data-quantity" class="form-control h-75">
						</div>
						<div class="col-sm-6">
							<span class="control-label">Կարգավիճակ</span>
							<select name="status" id="data-status" class="form-control h-75">
		                        <option value="{{ \App\Models\Orders::STATUS_CANCELED_BY_ADMIN }}">Մերժվել է ադմինի կողմից</option>
		                        <option value="{{ \App\Models\Orders::STATUS_PENDING }}">Ընթացքում է</option>
		                        <option value="{{ \App\Models\Orders::STATUS_COMPLETE }}">Ավարտված</option>
		                        <option value="{{ \App\Models\Orders::STATUS_CANCELED_BY_CUSTOMER }}">Մերժվել է հաճախորդի կողմից</option>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset('admin/js/fastselect/script.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/fastselect/standalone.min.js') }}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function () {
                $("#user").on('change', ajax);
                $("#filter-date").on('change', ajax);
            }, 500);


            $('#download').attr('href','excel?user_Id='+$("#user").val()+'&orderTab=1');
        });
         
        function ajax () {
            var user = $("#user").val();
            var date = $("#filter-date").val();
            var data = {'user': user, 'date': date,_token:"{{ csrf_token() }}"};
            $.ajax({
                url: "{{ route('manager_order_filter') }}",
                method: "POST",
                dataType: 'json',
                data: data,
                success: function(response) {
                    if($(".fstQueryInput").val() == '') {
                                $(".fstQueryInput").first().attr('placeholder', 'Ընտրել տարբերակ');
                            }else {
                                $(".fstQueryInput").first().removeAttr('placeholder', 'Ընտրել տարբերակ');
                            }
                    var html = "";
                    {{--@dd($order)--}}
                    @if(!isset($order))
                        response.forEach(function (item, i) {
                            html += "<tr>";
                            html += "    <td>" + item.id + "</td>";
                            html += "    <td>" + item.userName + "</td>";
                            html += "    <td>" + item.created_at + "</td>";
                            {{--html += "    <td><a href='{{ route('manager_order_detail', ['id' => $order->id]) }}' class='btn btn-dark'>Տեսնել ավելին</a></td>";--}}
                            html += "</tr>";
                        });
                    @else
                        response.forEach(function (item, i) {
                            html += "<tr>";
                            html += "    <td>" + item.id + "</td>";
                            html += "    <td>" + item.userName + "</td>";
                            html += "    <td>" + item.created_at + "</td>";
                            html += "    <td><a href='manager/details/"+item.id+"' class='btn btn-dark'>Տեսնել ավելին</a></td>";
                            html += "</tr>";
                        });

                    $('#download').attr('href','excel?user_Id='+user+'&orderTab=1');
                    $('#download').attr('href','order/excel?user_Id='+user+'&orderTab=1'+'&orderDate='+date);
                    @endif

                    $("#order-info").html(html);
                }
            });
        }

        $(document).ready(function() {
            $("#filter-status").on('change', function(event) {
                var type = $(this).val();
                var data = {type: type, _token:"{{ csrf_token() }}"};
                $.ajax({
                    url: "{{ route('manager_order_ordinary') }}",
                    method: "POST",
                    dataType: "json",
                    data: data,
                    success: function (response) {
                        var value = $(".statusSelect").val();
                        if(value == "") {
                            $(".statusSelect").attr('placeholder', 'Ընտրել տարբերակ');
                        }else {
                            $(".statusSelect").removeAttr('placeholder', 'Ընտրել տարբերակ');
                            console.log(1323);
                        }
                        var html = "";
                        @if(!isset($order))
                        response.forEach(function (item, i) {
                            html += "<tr>";
                            html += "    <td>" + item.id + "</td>";
                            html += "    <td>" + item.userName + "</td>";
                            html += "    <td>" + item.created_at + "</td>";
                            {{--html += "    <td><a href='{{ route('manager_order_detail', ['id' => $order->id]) }}' class='btn btn-dark'>Տեսնել ավելին</a></td>";--}}
                            html += "</tr>";
                        });
                        @else
                        response.forEach(function (item, i) {
                            html += "<tr>";
                            html += "    <td>" + item.id + "</td>";
                            html += "    <td>" + item.userName + "</td>";
                            html += "    <td>" + item.created_at + "</td>";
                            html += "    <td><a href='manager/details/"+item.id+"' class='btn btn-dark'>Տեսնել ավելին</a></td>";
                            html += "</tr>";
                        });

                        // $('#download').attr('href','order/excel?user_Id='+user);
                        @endif


                        $("#order-info").html(html);
                    }
                });
            })
        });

        $(function () {
            $('input[name="filterByDate"]').daterangepicker();

            $(".fstQueryInput").attr('placeholder', 'Ընտրել տարբերակ');
            $(".statusSelect").attr('placeholder', 'Ընտրել տարբերակ');
        });
        $("#avatar").on('change', function () {
            $(this).prev().removeClass('none');
        });

        $(document).ready(function() {
            $('#example').DataTable({
                initComplete: function () {
                    const textNodeSearch = $("#example_filter").children().contents().filter(function() {
                        return this.nodeType == 3; // Node.TEXT_NODE;
                    }).get(0);

                    textNodeSearch.data =
                    textNodeSearch.nodeValue =
                    textNodeSearch.textContent =
                    textNodeSearch.wholeText =
                        "Որոնել";

                    const textItems = $("#example_length").children().contents().filter(function() {
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
        } );



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

        $(window).on('load', function(){
        	$(".fstResultItem").on('click', function(){
        		$(".fstChoiceRemove").text('x');
        	})

            // $("#example_filter").children().html("Որոնել։ <input type='search' class='form-control input-sm' placeholder='' aria-controls=example'>");
            
        });

    </script>
@stop
