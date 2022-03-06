@extends('_layouts.admin')
@section('content')
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-12'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h4 class="lh-1 margined-header">Ակտիվ Ապրանքներ</h4>
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
                                            <td class="fw-600">{{ $product->categoryName }}</td>
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
