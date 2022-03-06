{{--@extends("_layouts.admin")--}}
{{--@section('content')--}}
{{--<style>--}}
{{--.control-group *{--}}
{{--display: inline-block;--}}
{{--margin-left: 5px;--}}
{{--color: #337ab7;--}}
{{--}--}}

{{--/* Track */--}}
{{--::-webkit-scrollbar-track {--}}
{{--background: #d0d0d0;--}}
{{--}--}}
{{--::-webkit-scrollbar {--}}
{{--width: 8px;--}}
{{--height: 8px;--}}
{{--}--}}
{{--/* Handle */--}}
{{--::-webkit-scrollbar-thumb {--}}
{{--background: #888;--}}
{{--border-radius: 5px;--}}
{{--}--}}

{{--/* Handle on hover */--}}
{{--::-webkit-scrollbar-thumb:hover {--}}
{{--background: #555;--}}
{{--}--}}

{{--#example1_wrapper {--}}
{{--overflow-x: scroll;--}}
{{--padding-bottom: 15px;--}}
{{--}--}}
{{--</style>--}}
{{--<div class="content-wrapper">--}}
{{--<!-- Content Header (Page header) -->--}}
{{--<section class="content-header">--}}
{{--<h1>--}}
{{--Blank page--}}
{{--<small>it all starts here</small>--}}
{{--</h1>--}}
{{--<ol class="breadcrumb">--}}
{{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
{{--<li><a href="#">Examples</a></li>--}}
{{--<li class="active">Blank page</li>--}}
{{--</ol>--}}
{{--</section>--}}

{{--<!-- Main content -->--}}
{{--<section class="content">--}}

{{--<!-- Default box -->--}}
{{--<div class="box">--}}
{{--<div class="box-header">--}}
{{--<h3 class="box-title">Листинг сущности</h3>--}}
{{--</div>--}}
{{--<!-- /.box-header -->--}}
{{--<div class="box-body">--}}
{{--<div class="form-group">--}}
{{--<a href="{{route('admin_products_create')}}"  class="btn btn-success">Добавить</a>--}}
{{--</div>--}}
{{--<table id="example1" class="table table-bordered table-striped">--}}
{{--<thead>--}}
{{--<tr>--}}
{{--<th>ID</th>--}}
{{--<th>Name</th>--}}
{{--<th>Category</th>--}}
{{--<th>Open Date</th>--}}
{{--<th>Description</th>--}}
{{--<th>Image</th>--}}
{{--<th>Price</th>--}}
{{--<th>Count</th>--}}
{{--<th>Top</th>--}}
{{--<th>Active/Passive</th>--}}
{{--<th>Edit</th>--}}
{{--<th>Status</th>--}}


{{--</tr>--}}
{{--</thead>--}}
{{--<tbody>--}}
{{--@foreach($prod as $product)--}}

{{--<tr>--}}
{{--<td>{{$product->id}}</td>--}}
{{--<td>{{$product->name}}</td>--}}
{{--<td>{{$product->category}}</td>--}}
{{--<td>{{$product->created}}</td>--}}
{{--<td>{!! $product->description !!}</td>--}}
{{--<td>--}}
{{--<img src="{{ asset('img/products/' . $product->image) }}" alt="" width="100">--}}
{{--</td>--}}
{{--<td>{{$product->price}}</td>--}}
{{--<td>{{$product->count}}</td>--}}
{{--<td>{{$product->top}}</td>--}}
{{--<td>{{$product->status}}</td>--}}
{{--<td class="edit"><a href="{{ route('admin_product_edit', ['id' => $product->id]) }}"><i class="fa fa-pencil-square edit-icon" aria-hidden="true"></i></a></td>--}}
{{--<td class="control-group icon-white">--}}
{{--@if($product->status == 'passive')--}}
{{--<a href="{{ route('admin_product_active', ['id' => $product->id]) }}" class="btn btn-success btn-xs"><i class="fa fa-star-o" aria-hidden="true"></i></a></td>--}}
{{--@else--}}
{{--<a href="{{ route('admin_product_passive', ['id' => $product->id]) }}" class="btn btn-danger btn-xs"><i class="fa fa-star-o" aria-hidden="true"></i></a></td>--}}
{{--@endif--}}
{{--</td>--}}
{{--</tr>--}}
{{--@endforeach--}}
{{--</tfoot>--}}
{{--</table>--}}
{{--</div>--}}
{{--<!-- /.box-body -->--}}
{{--</div>--}}
{{--<!-- /.box -->--}}

{{--</section>--}}
{{--<!-- /.content -->--}}
{{--</div>--}}
{{--@endsection--}}

@extends('_layouts.admin')
@section('content')
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-12'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h4 class="lh-1 margined-header">Պասիվ Ապրանքներ</h4>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="bdwT-0" style="width: 120px">Նկար</th>
                                        <th class="bdwT-0">Անուն</th>
                                        <th class="bdwT-0">Կատեգորիա</th>
                                        <th class="bdwT-0">Արժեք</th>
                                        <th class="bdwT-0">Քանակ</th>
                                        <th class="bdwT-0">Կարգավիճակ</th>
                                        <th class="bdwT-0">Կարգավորում</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            @if($product->image)
                                                <td class="fw-600"><img src="{{ asset('img/products/'.$product->image) }}" alt="Logo" style="width: 110px; height: 110px;"></td>
                                            @else
                                                <td class="fw-600"></td>
                                            @endif
                                            <td class="fw-600">{{ $product->name }}</td>
                                            <td class="fw-600">{{ $product->category }}</td>
                                            <td class="fw-600">{{ $product->price }}</td>
                                            <td class="fw-600">{{ $product->count }}</td>
                                            <td class="fw-600">{{ $product->status }}</td>
                                            <td class="text-left">
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
