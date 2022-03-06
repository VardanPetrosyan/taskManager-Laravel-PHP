@extends('_layouts.admin')
@section('content')
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-12'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h4 class="lh-1 margined-header">Ավարտված Պատվերներ</h4>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="bdwT-0" style="width: 250px">Օգտատերի անուն</th>
                                        <th class="bdwT-0" style="width: 250px;">Ապրանքի անուն</th>
                                        <th class="bdwT-0">Քանակ</th>
                                        <th class="bdwT-0">Կարգավիճակ</th>
                                        <th class="bdwT-0">Կարգավորում</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            @php
                                                if($order->status == \App\Models\Orders::STATUS_CANCELED_BY_CUSTOMER){
                                                    $status = 'Մերժվել է հաճախորդի կողմից';
                                                }elseif($order->status == \App\Models\Orders::STATUS_COMPLETE) {
                                                    $status = 'Ավարտված';
                                                }elseif($order->status == \App\Models\Orders::STATUS_CANCELED_BY_ADMIN) {
                                                    $status = 'Մերժվել է ադմինի կողմից';
                                                }elseif($order->status == \App\Models\Orders::STATUS_PENDING) {
                                                    $status = 'Ընթացքում է';
                                                }elseif($order->status == \App\Models\Orders::STATUS_ARCHIVE) {
                                                    $status = 'Արխիվ';
                                                }
                                            @endphp
                                            <td class="fw-600" style="width: 160px;">{{ $order->userName }}</td>
                                            <td class="fw-600">{{ $order->productName }}</td>
                                            <td class="fw-600">{{ $order->count }}</td>
                                            <td class="fw-600">{{ $status }}</td>
                                            <td class="fw-600">
                                                <a title="Edit" class="btn btn-primary btn-sm" href="{{ route('admin_order_status_edit', ['id' => $order->id]) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw float-right">
                                {{--{{ $questions->links() }}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
