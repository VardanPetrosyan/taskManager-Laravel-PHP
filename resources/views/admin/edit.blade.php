@extends('_layouts.admin')

@section('content')
    <div class="masonry-item col-md-6 offset-md-3">
        <div class="bd bgc-white">
            <div class="layers">
                <div class="layer w-100 p-20">
                    <h4 class="lh-1">Ապրանքի տվյալների կարգավորում</h4>
                </div>
                <div class="layer w-100">
                    <div class="col-md-12">
                        <form action="{{ route('admin_product_update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            {{--<input type="hidden" name="right_answer_id" value="{{ $question->rightAnswer->id }}">--}}

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            @if(!is_null($product->image))
                                                <label for="avatar">
                                                    <div class="main">
                                                        <img draggable="false" src="{{ asset('img/products/' . $product->image) }}" id="output" alt="" width="246" height="205">
                                                        <div class="for-user-bg">
                                                            <span>Upload Image</span>
                                                        </div>
                                                    </div>
                                                </label>
                                                <input type="file" class="none" name="avatar" id="avatar">
                                            @else
                                                <label for="image" class="btn btn-primary">
                                                    Ներբեռնել նկար
                                                </label>
                                                <input type="file" style="display: none;" id="image" name="avatar">
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="description">
                                                Նկարագիր
                                            </label>
                                            <textarea name="description" id="description" class="form-control" cols="20" rows="5">
                                                {{ $product->description }}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">
                                                Անուն
                                            </label>
                                            <input type="text" name="name" value="{{ $product->name }}" class="form-control" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="category">
                                                Կատեգորիա
                                            </label>
                                            <select name="category" id="category" class="form-control h-50">
                                                @foreach($categories as $category)
                                                    <option id="{{ $category->id }}" {{ $product->category == $category->id ? 'selected' : '' }}
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">
                                                Արժեք
                                            </label>
                                            <input type="number" id="price" name="price" class="form-control" step="1000" value="{{ $product->price }}">
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <label for="count">
                                                        Քանակ
                                                    </label>
                                                    <input type="number" id="count" name="count" class="form-control" value="{{ $product->count }}">
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="unit">
                                                        Միավոր
                                                    </label>
                                                    <select name="unit" id="unit" class="form-control" style="height: 34px;">
                                                        @foreach($units as $unit)
                                                            <option value="{{ $unit->id }}" {{ $unit->id == $product->unit ? 'selected' : '' }}>{{ $unit->unit }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="code">
                                                Կոդ
                                            </label>
                                            <input type="text" name="code" value="{{ $product->code }}" class="form-control" id="code">
                                        </div>
                                        <div class="form-group">
                                            <label for="status">
                                                Կարգավիճակ
                                            </label>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <select name="status" id="status" class="form-control h-100">
                                                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Ակտիվ</option>
                                                        <option value="passive" {{ $product->status == 'passive' ? 'selected' : '' }}>Պասիվ</option>
                                                        <option value="reserve" {{ $product->status == 'reserve' ? 'selected' : '' }}>Պատվիրված</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Լավագույն ապրանքներ</label>
                                                    <input type="checkbox" name="top" @if($product->top=="1") checked @endif />
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
@stop

@section('script')
    <script>
        $("#avatar").on('change', function () {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var dataURL = reader.result;
                var output = document.getElementById('output');
                output.src = dataURL;
                console.log(output);
            };
            reader.readAsDataURL(input.files[0]);
        })
    </script>
@stop

