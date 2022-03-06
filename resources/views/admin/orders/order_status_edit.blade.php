@extends('_layouts.admin')

@section('content')
    <div class="masonry-item col-md-6 offset-md-3">
        <div class="bd bgc-white">
            <div class="layers">
                <div class="layer w-100 p-20">
                    <h4 class="lh-1">Պատվերի տվյալների կարգավորում</h4>
                </div>
                <div class="layer w-100">
                    <div class="col-md-12">
                        <form action="{{ route('admin_order_status_update') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="name">
                                                        Կարգավիճակ
                                                    </label>
                                                    <select name="status" id="status" class="form-control h-75">
                                                        <option value="{{ \App\Models\Orders::STATUS_CANCELED_BY_ADMIN }}" {{ $order->status == \App\Models\Orders::STATUS_CANCELED_BY_ADMIN ? 'selected' : '' }}>Մերժվել է ադմինի կողմից</option>
                                                        <option value="{{ \App\Models\Orders::STATUS_PENDING }}" {{ $order->status == \App\Models\Orders::STATUS_PENDING ? 'selected' : '' }}>Ընթացքում է</option>
                                                        <option value="{{ \App\Models\Orders::STATUS_COMPLETE }}" {{ $order->status == \App\Models\Orders::STATUS_COMPLETE ? 'selected' : '' }}>Ավարտված</option>
                                                        <option value="{{ \App\Models\Orders::STATUS_CANCELED_BY_CUSTOMER }}" {{ $order->status == \App\Models\Orders::STATUS_CANCELED_BY_CUSTOMER ? 'selected' : '' }}>Մերժվել է հաճախորդի կողմից</option>
                                                        <option value="{{ \App\Models\Orders::STATUS_ARCHIVE }}" {{ $order->status == \App\Models\Orders::STATUS_ARCHIVE ? 'selected' : '' }}>Արխիվ</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="count">
                                                        Քանակ ({{ $order->unitName }})                                                        
                                                    </label>
                                                    <input type="number" name="count" id="count" class="form-control h-75" value="{{ $order->count }}">        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-success float-right" value="Պահպանել">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        const openFile = function(event) {
            var input = event.target;

            var reader = new FileReader();
            reader.onload = function(){
                var dataURL = reader.result;
                var output = document.getElementById('output');
                output.src = dataURL;
                console.log(output);
            };
            reader.readAsDataURL(input.files[0]);
        };

    </script>
@stop
