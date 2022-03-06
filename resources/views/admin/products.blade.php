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
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h4 class="lh-1 margined-header">Ավելացնել Նոր ապրանք</h4>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <form method="post" action="{{ route('admin_products_create') }}" enctype="multipart/form-data" style="width: 100%">
                                    @csrf

                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    {{--<label class="col-sm-12 control-label label-to-choose" style="float:left;" for="avatar">--}}
                                                        {{--Նկար--}}
                                                        {{--<i class="fas fa-check selected-icon none"></i>--}}

                                                    {{--</label>--}}
                                                    <label class="form-control product-img" style="height: 170px">
                                                        <input type="file" id="avatar" name="image" class="file-aupload" style="display: none;">
                                                        <img src="{{asset("/assets/images/photo_default_2.png")}}" />
                                                    </label>
                                                    <label for="without" class="switch">
                                                        <span class="without">Առանց նկար</span>
                                                        <input type="checkbox" id="without" name="without_image" value="without">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    <br>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label class="category">Անուն</label>
                                                    <input type="text" class="form-control" name="name" placeholder="Անուն">
                                                    @if($errors->has('name'))
                                                        <span class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="category">Կատեգորիա</label>
                                                <select name="category" id="category" class="form-control h-75">
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mt-5">
                                            <div class="col-sm-12">
                                                <label for="price">Արժեք</label>
                                                <input type="number" class="form-control" name="price" id="price">
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-7">
                                                <label for="count">Քանակ</label>
                                                <input type="number" id="count" name="count" class="form-control">
                                            </div>
                                            <div class="col-sm-5">
                                                <label for="unit">
                                                    Միավոր
                                                </label>
                                                <select name="unit" id="unit" class="form-control" style="height: 34px;">
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="code">Կոդ</label>
                                                    <input type="text" name="code" id="code" class="form-control h-50">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="description">Նկարագիր</label>
                                                <textarea id="description" name="description" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <label for="status">Կարգավիճակ</label>
                                                <select name="status" id="status" class="form-control h-75">
                                                    <option value="active">Ակտիվ</option>
                                                    <option value="passive">Պասիվ</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <hr />
                                        @include('flash::message')
                                        
                                        <input type="submit" value="Հաստատել" class="btn btn-success float-right">

                                    </div>



                                </form>

                            </div>
                        </div>
                        <form action="{{ route('upload_product') }}" style="width: 100%" enctype="multipart/form-data" method="post">
                            @csrf
                            <hr />
                            {{--<p><a href="{{asset('assets/images/upload/HaytiOrinakeliDzev.xlsx')}}" download>Ներբեռնել Հայտի Օրինակ</a></p>--}}
                            {{--<p><a href="{{asset('assets/images/upload/id-ner.xlsx')}}" download>Ներբեռնել ID-ների Աղյուսակ</a></p>--}}
                            <label style="display: block; border: 1px solid; height: 100px; margin-top: 20px; text-align: center;   background: #7c8695;">
                                <input type="file" name="file" style="display:none;">
                                <i class="fa fa-cloud-upload" style="font-size: 105px; color: black"></i>
                            </label>
                            <input type="submit" value="Հաստատել" class="btn btn-success float-right mt-3">
                        </form>
                    </div>
                </div>

                <div class='col-md-9'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="lh-1 margined-header">
                                        @if(Request::get('filter') == 'reserve')
                                            Պատվիրված
                                        @elseif(Request::get('filter') == 'active')
                                            Ակտիվ
                                        @elseif(Request::get('filter') == 'passive')
                                            Պասիվ
                                        @else
                                            Բոլոր ապրանքները
                                        @endif
                                    </h4>   
                                </div>
                                <div class="col-sm-6">
                                    <form action="{{ route('admin_products') }}" method="get">
                                        <label for="filter" class="float-right ml-3">             
                                            <input type="submit" value="Տեսնել" id="filter" class="btn btn-dark">
                                        </label>
                                        <select class="form-control float-right" name="filter" id="filter" style="width: 175px; height: 33px;">
                                            <option value="all">Բոլոր Ապրանքները</option>
                                            <option value="active" {{ 'active' == Request::get('filter') ? 'selected' : '' }}>Ակտիվ</option>
                                            <option value="passive" {{ 'passive' == Request::get('filter') ? 'selected' : '' }}>Պասիվ</option>
                                            <option value="reserve" {{ 'reserve' == Request::get('filter') ? 'selected' : '' }}>Պատվիրված</option>
                                        </select>   
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Նկար</th>
                                        <th>Անուն</th>
                                        <th>Կատեգորիա</th>
                                        <th>Արժեք</th>
                                        <th>Կոդ</th>
                                        <th>Քանակ</th>
                                        <th>Կարգավիճակ</th>
                                        <th>Կարգավորում</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        @if($product->status == 'passive')
                                            <tr style="background-color: #fbc8cd;">
                                            @else
                                            <tr>
                                            @endif

                                            @if(!is_null($product->image))
                                                <td class="fw-600"><img src="{{ asset('img/products/'.$product->image) }}" alt="Logo" style="width: 110px; height: 110px;"></td>
                                            @else
                                                <td></td>
                                            @endif
                                            <td class="fw-600">{{ $product->name }}</td>
                                            <td class="fw-600">{{ $product->categoryName }}</td>
                                            <td class="fw-600">{{ $product->price }}</td>
                                            <td class="fw-600">{{ $product->code }}</td>
                                            <td class="fw-600">{{ $product->count }} {{ $product->unitName }}</td>
                                            @php
                                                if($product->status == 'active'){
                                                    $status = 'Ակտիվ';
                                                } elseif($product->status == 'passive') {
                                                    $status = 'Պասիվ';
                                                }else{
                                                    $status = 'Պատվիրված';
                                                }
                                            @endphp
                                            <td class="fw-600">{{ $status }}</td>
                                            <td class="text-center">
                                                <a title="Edit" class="btn btn-primary btn-sm" href="{{ route('admin_product_edit', ['id' => $product->id]) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($product->status != App\Models\Product::STATUS_PASSIVE)
                                                    <a title="Deactivate" class="btn btn-danger btn-sm" href="{{ route('admin_product_passive', ['id' => $product->id]) }}">
                                                        <i class="far fa-star"></i>
                                                    </a>
                                                @else
                                                    <a title="Activate" class="btn btn-success btn-sm" href="{{ route('admin_product_active', ['id' => $product->id]) }}">
                                                        <i class="far fa-star"></i>
                                                    </a>
                                                @endif

                                            <!-- Button trigger modal -->
                                                <button type="button"  title="Delete" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delModal{{$product->id}}">
                                                    <i class="far fa-times-circle"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="delModal{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Ջնջե՞լ {{ $product->name }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Չեղարկել</button>
                                                                {{--<button type="button" class="btn btn-danger">Ջնջել</button>--}}
                                                                <a title="Delete" class="btn btn-danger" href="{{ route('admin_product_delete', ['id' => $product->id]) }}">Ջնջել</a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <a id="download" href="{{ route('export_products') }}" class="btn btn-info" style="background:#5CB85C;border:#5CB85C" target="_blank">Արտահանել ցանկը Excel</a>
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
