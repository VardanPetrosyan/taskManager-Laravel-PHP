@extends('_layouts.admin')
@section('content')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script
		src="https://code.jquery.com/jquery-3.3.1.js"
		integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
		crossorigin="anonymous"></script>
{{--<script>--}}
    {{--$.ajaxSetup({--}}
        {{--headers: {--}}
            {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),--}}
        {{--},--}}
    {{--});--}}
{{--</script>--}}
<style>
	#myTable_info {
		opacity: 0;
	}
	.checked{
		background:  #5cb85c;
	}
</style>
 <div class="row gap-20 masonry pos-r">
    <div class="masonry-item w-100">
        <div class="row gap-20">
            <div class='col-md-12'>
                <div class="layers bd bgc-white p-20">
                	<div class="layer w-100 mB-10">
                        <h4 class="lh-1 margined-header">{{ $userName }} -ի կատարած պատվերները</h4>
                    </div>
                    <div class="layer w-100 mB-10">
                        <div class="row">
							 <div class="peers ai-sb fxw-nw">
	                            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
	                                <thead>
	                                    <tr>
	                                        <th>Օգտատերի անուն</th>
	                                        <th>Շահագործող</th>
	                                        <th>Կրթական օբյեկտ</th>
	                                        <th>Ապրանքի անուն</th>
	                                        <th>Քանակ</th>
	                                        <th>Հաստատված քանակ</th>
	                                        <th>Միավոր</th>
	                                        <th>Կարգավիճակ</th>
	                                        <th>Պահպանել</th>

	                                    </tr>
	                                </thead>
	                                <tbody>
										@foreach($object as $obj)
											@foreach($obj as $order)
											@php
                                                if($order->status == \App\Models\Orders::STATUS_CANCELED_BY_CUSTOMER){
                                                    $status = 'Մերժվել է հաճախորդի կողմից';
                                                }elseif($order->status == \App\Models\Orders::STATUS_COMPLETE) {
                                                    $status = 'Ավարտված';
                                                }elseif($order->status == \App\Models\Orders::STATUS_CANCELED_BY_ADMIN) {
                                                    $status = 'Մերժվել է ադմինի կողմից';
                                                }elseif($order->status == \App\Models\Orders::STATUS_PENDING) {
                                                    $status = 'Ընթացքում է';
                                                }elseif($order->status == \App\Models\Orders::STATUS_APPROVE) {
                                                    $status = 'Հաստատված';
                                                }elseif($order->status == \App\Models\Orders::STATUS_ARCHIVE) {
                                                    $status = 'Արխիվ';
                                                }
                                            @endphp
											@if($status == 'Հաստատված')
												<tr class="approvedtr">
												@else
												<tr class="nochecked">
											@endif
													<script>
														$(function () {
															$(document).on('click','.nochecked',function(){
                                                                $(this).addClass('checked');
                                                                $(this).removeClass('nochecked');
                                                                $(this).css('background','#a4f3a4');
															})
															$(document).on('click','.checked',function(){
                                                                $(this).addClass('nochecked');
                                                                $(this).removeClass('checked');
                                                                $(this).css('background','#fff');
															})
                                                        })
													</script>
													{{--@dd($order->id)--}}
													<input class="orderId" value="{{$order->id}}" type="hidden">
													<input class="orderCount" value="{{$order->count}}" type="hidden">
													<td>{{ $order->userName }}</td>
													<td>{{ $order->exploiter }}</td>
													@if($order->categoryStructure_id == 16)
														<td>{{ $order->edu_obj }}</td>
													@else
														<td>{{ $order->schoolName }}</td>
													@endif
													<td>{{ $order->productName }}</td>
													<form action="{{ route('admin_order_approve', ['id' => $order->id]) }}">
														<td><input type="number" name="count_approve" class="form-control" value="{{ $order->count }}" min="0" max="{{ $order->count }}"></td>
														<td>{{ $order->approved }}</td>
														<td>{{ $order->unit }}</td>
														<td>
															<select name="status_approve" id="" class="selsave form-control h-50">
																<option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Ընթացքում է</option>
																<option value="canceled_by_admin" {{ $order->status == 'canceled_by_admin' ? 'selected' : '' }}>Մերժվել է ադմինի կողմից</option>
																<option value="canceled_by_customer" {{ $order->status == 'canceled_by_customer' ? 'selected' : '' }}>Մերժվել է հաճախորդի կողմից</option>
																<option value="complete" {{ $order->status == 'complete' ? 'selected' : '' }}>Ավարտված</option>
																<option value="archive" {{ $order->status == 'archive' ? 'selected' : '' }}>Արխիվ</option>
																<option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>Հաստատված</option>
															</select>
														</td>
														<td><input type="submit" value="Պահպանել" class="btn btn-success savebut"></td>
													</form>
												</tr>
											@endforeach
										@endforeach

	                                </tbody>
	                            </table>
	                        </div>
                        </div>
						<button id="checkAll" class="btn btn-success">Նշել Բոլորը</button>
						<button id="approveCheckeds" class="btn btn-success">Հաստատել Նշվածները</button>
						<script>
                            $(function () {
                                $(document).on('click','#checkAll',function(){
                                    $('.nochecked').addClass('checked');
                                    $('.nochecked').css('background','#a4f3a4');
                                    $('.nochecked').remove('nochecked');
								});

								$(document).on('click','.savebut',function(e){
                                    e.stopPropagation();
								});
								$(document).on('click','.selsave',function(e){
                                    e.stopPropagation();
								});

                                $(document).on('click','#approveCheckeds',function(){
                                    var approves = [];
                                    // console.log($('.checked').length);
                                    for(let i = 0 ; i<$('.checked').length ; i++){
                                        var obj = {
                                            orderId: $('.checked').eq(i).children('.orderId').val(),
                                            count: $('.checked').eq(i).children('.orderCount').val(),
                                        }
                                        approves.push(obj);
									}


                                    var formData = new FormData();

                                    for(let i = 0;i<approves.length ; i++){
                                        formData.append( 'orderId_'+i ,approves[i].orderId);
                                        formData.append( 'count_'+i ,approves[i].count);
									}
                                    console.log(formData);
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                        },
										url: '/admin/order/approveorders',
                                        method:'post',
                                        processData: false,
                                        contentType: false,
                                        cache: false,
										dataType: 'json',
                                        data: formData,
										success: function(res){
											location.reload();
                                        },
										error:function(err){
                                        	console.log(err);
										}
									})
                                })
                            })
						</script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
	$(function(){
		$(document).ready(function() {
	        $('#myTable').DataTable({
	        	initComplete: function () {
                    const textNodeSearch = $("#myTable_filter").children().contents().filter(function() {
                        return this.nodeType == 3; // Node.TEXT_NODE;
                    }).get(0);

                    textNodeSearch.data =
                    textNodeSearch.nodeValue =
                    textNodeSearch.textContent =
                    textNodeSearch.wholeText =
                        "Որոնել";

                    const textItems = $("#myTable_length").children().contents().filter(function() {
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
	})
</script>
@stop
