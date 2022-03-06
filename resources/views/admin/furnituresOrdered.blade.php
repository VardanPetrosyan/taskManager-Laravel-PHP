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
                <div class='col-md-12'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="lh-1 margined-header">

                                    </h4>   
                                </div>
                                <div class="col-sm-6">
                                    <form action="{{ route('admin_furniture_ordered') }}" method="get">
                                        <label for="filter" class="float-right ml-3">
                                            <input type="submit" value="Տեսնել" id="filter" class="btn btn-dark">
                                        </label>
                                        <select class="form-control float-right" name="filter" id="filter" style="width: 175px; height: 33px;">
                                            <option value="all">Ամբողջ գույքը</option>
                                            <option value="ordered" {{ 'ordered' == Request::get('filter') ? 'selected' : '' }}>Պատվիրված</option>
                                            <option value="sended" {{ 'sended' == Request::get('filter') ? 'selected' : '' }}>Ուղարկված</option>
                                        </select>   
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
                                        <th>Կատեգորիա</th>
                                        <th>Բաժին</th>
                                        <th>Պատասխանատու</th>
                                        <th>Քանակ</th>
                                        <th>Կարգավիճակ</th>
                                        <th>Պատվիրող</th>
                                        <th>Պատվիրման օր</th>
                                        <th></th>
                                        <th>Կարգավորում</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($furnitures as $product)
                                        @if(!$product->approved && $product->status != 'sended' )
                                            <tr style="background-color: #fbc8cd;">
                                            @else
                                            <tr>
                                            @endif
                                            <td class="fw-600">{{ $product->name }}</td>
                                            <td class="fw-600">{{ $product->categoryName }}</td>
                                            <td class="fw-600">{{ $product->schoolName }}</td>
                                            <td class="fw-600">{{ $product->username }}</td>
                                            <td class="fw-600">{{ $product->count }} հատ</td>
                                                @php

                                                if($product->status == 'ordered') {
                                                    $status = 'Պատվիրված';
                                                } elseif($product->status == 'sended') {
                                                    $status = 'ՈՒղարկված';
                                                }

                                            @endphp
                                            <td class="fw-600">{{ $status }}</td>
                                            @if($product->status == 'ordered')
                                                <td class="fw-600">{{ $product->orderedCategoryStructure->category}}</td>
                                                @else
                                                <td class="fw-600">{{ $product->sendedCategoryStructure->category}}</td>
                                            @endif
                                                <td class="fw-600">{{ $product->created_at }}</td>
                                            <td class="text-center">
                                                @if(!$product->approved && $product->status != 'sended')
                                                    Չհաստատված
                                                    @else
                                                    Հաստատված
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                @if($product->status != 'sended')
                                                    @if(!$product->approved)
                                                        <form method="post" style="display: inline-block" action="{{ route('admin_furniture_approve') }}">
                                                            @csrf
                                                            <input type="hidden" name="furnId" value="{{$product->id}}">
                                                            <button type="submit"  title="Approve"  class="btn btn-success btn-sm" >
                                                                <i class="far fa-star"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="post" style="display: inline-block" action="{{ route('admin_furniture_disapprove') }}">
                                                            @csrf
                                                            <input type="hidden" name="furnId" value="{{$product->id}}">
                                                            <button type="submit"  title="DisApprove"  class="btn btn-warning btn-sm" >
                                                                <i class="far fa-star"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                        <form method="post" style="display: inline-block" action="{{ route('admin_furniture_cancelorder') }}">
                                                            @csrf
                                                            <input type="hidden" name="furnId" value="{{$product->id}}">
                                                            <button type="submit"  title="DisApprove"  class="btn btn-danger btn-sm" >
                                                                <i class="far fa-times-circle"></i>
                                                            </button>
                                                        </form>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
@stop
@section('script')
    <script type="text/javascript">
        $('#example').DataTable({
            "order": [],
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
        $("#avatar").on('change', function () {
            $(this).prev().removeClass('none');
        })

        $('file-aupload').onchange(function (event) {
            alert();
            console.log(event);
        });


       

    </script>
@stop
