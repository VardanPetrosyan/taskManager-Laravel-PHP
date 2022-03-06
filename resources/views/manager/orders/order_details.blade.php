@extends('_layouts.manager')
@section('content')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<style>
	#myTable_info {
		opacity: 0;
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
	                                        <th>Ապրանքի անուն</th>
	                                        <th>Քանակ</th>
	                                        <th>Հաստատված քանակ</th>
	                                        <th>Միավոր</th>
											<th>Կրթական օբյեկտ</th>
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
												<tr>

													<td>{{ $order->userName }}</td>
													<td>{{ $order->productName }}</td>

													<form action="{{ route('manager_order_approve', ['id' => $order->id]) }}">
														<td><input type="number" name="count_approve" class="form-control" min="0" max="{{ $order->count }}" value="{{ $order->count }}"></td>
														<td>{{ $order->approved }}</td>
														<td>{{ $order->unit }}</td>
														<td>{{$order->categoryStructureName}}</td>
														<td>
															<select name="status_approve" id="" class="form-control h-50">
																<option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Ընթացքում է</option>
																<option value="canceled_by_admin" {{ $order->status == 'canceled_by_admin' ? 'selected' : '' }}>Մերժվել է ադմինի կողմից</option>
																<option value="canceled_by_customer" {{ $order->status == 'canceled_by_customer' ? 'selected' : '' }}>Մերժվել է հաճախորդի կողմից</option>
																<option value="complete" {{ $order->status == 'complete' ? 'selected' : '' }}>Ավարտված</option>
																<option value="archive" {{ $order->status == 'archive' ? 'selected' : '' }}>Արխիվ</option>
																<option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>Հաստատված</option>
															</select>
														</td>
														<td><input type="submit" value="Պահպանել" class="btn btn-success"></td>
													</form>
												</tr>
											@endforeach
										@endforeach
	                                </tbody>
	                            </table>
	                        </div>
                        </div>
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
