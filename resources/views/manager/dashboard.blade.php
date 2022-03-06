@extends('_layouts.manager')
@section('content')

<div class="row gap-20 masonry pos-r">
    <div class="container">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <h3 class="mT-100">
                    <span class="icon-holder">
                        <i class="c-indigo-500 ti-clipboard"></i>
                    </span>
                    Պատվերներ
                </h3>
            </div>
            <div class="row gap-20">
                <div class='col-md-4'>
                    <a href="{{ route('manager_orders') }}" class="dashboard-href">
                        <div class="layers bd bgc-white p-20 border-color-8">
                            <div class="layer w-100 mB-10">
                                <h5 class="lh-1 float-left">Ընդհանուր</h5>
                            </div>
                            <div class="layer w-100">
                                <div class="peers ai-sb fxw-nw">
                                    <div class="peer peer-greed">
                                        <span id="sparklinedash"></span>
                                    </div>
                                    <div class="peer">
                                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500 count">
                                            {{ number_format($orderTotal, 0, '', ' ') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class='col-md-4'>
                    <a href="{{ route('manager_order_canceled_by_customer') }}" class="dashboard-href">
                        <div class="layers bd bgc-white p-20 border-color-9">
                            <div class="layer w-100 mB-10">
                                <h5 class="lh-1">Մերժվել է հաճախորդի կողմից</h5>
                            </div>
                            <div class="layer w-100">
                                <div class="peers ai-sb fxw-nw">
                                    <div class="peer peer-greed">
                                        <span id="sparklinedash2"></span>
                                    </div>
                                    <div class="peer">
                                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-green-50 c-green-500 count">
                                            {{ number_format($orderCanceledByCustomer, 0, '', ' ') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class='col-md-4'>
                    <a href="{{ route('manager_order_canceled_by_admin') }}" class="dashboard-href">
                        <div class="layers bd bgc-white p-20 border-color-10">
                            <div class="layer w-100 mB-10">
                                <h5 class="lh-1">Մերժվել է ադմինի կողմից</h5>
                            </div>
                            <div class="layer w-100">
                                <div class="peers ai-sb fxw-nw">
                                    <div class="peer peer-greed">
                                        <span id="sparklinedash3"></span>
                                    </div>
                                    <div class="peer">
                                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500 count">
                                            {{ number_format($orderCanceledByAdmin, 0, '', ' ') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row gap-20">
                <div class='col-md-4'>
                    <a href="{{ route('manager_order_complete') }}" class="dashboard-href">
                        <div class="layers bd bgc-white p-20 border-color-11">
                            <div class="layer w-100 mB-10">
                                <h5 class="lh-1">Ավարտված</h5>
                            </div>
                            <div class="layer w-100">
                                <div class="peers ai-sb fxw-nw">
                                    <div class="peer peer-greed">
                                        <span id="sparklinedash3"></span>
                                    </div>
                                    <div class="peer">
                                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-purple-50 c-purple-500 count">
                                            {{ number_format($orderComplete, 0, '', ' ') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class='col-md-4'>
                    <a href="{{ route('manager_order_pending') }}" class="dashboard-href">
                        <div class="layers bd bgc-white p-20 border-color-12">
                            <div class="layer w-100 mB-10">
                                <h5 class="lh-1">Ընթացքում է</h5>
                            </div>
                            <div class="layer w-100">
                                <div class="peers ai-sb fxw-nw">
                                    <div class="peer peer-greed">
                                        <span id="sparklinedash3"></span>
                                    </div>
                                    <div class="peer">
                                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-red-50 c-red-500 count">
                                            {{ number_format($orderPending, 0, '', ' ') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class='col-md-4'>
                    <a href="{{ route('manager_order_archive') }}" class="dashboard-href">
                        <div class="layers bd bgc-white p-20 border-color-13">
                            <div class="layer w-100 mB-10">
                                <h5 class="lh-1">Արխիվ</h5>
                            </div>
                            <div class="layer w-100">
                                <div class="peers ai-sb fxw-nw">
                                    <div class="peer peer-greed">
                                        <span id="sparklinedash3"></span>
                                    </div>
                                    <div class="peer">
                                        <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 bgc-grey-300 c-gray-500 count">
                                            {{ number_format($orderArchive, 0, '', ' ') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
    



@stop