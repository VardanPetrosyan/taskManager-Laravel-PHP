@extends('_layouts.admin')

@section('content')
    <div class="masonry-item col-md-6 offset-md-3">
        <div class="bd bgc-white">
            <div class="layers">
                <div class="layer w-100 p-20">
                    <h4 class="lh-1">Գույքի տվյալների կարգավորում</h4>
                </div>
                <div class="layer w-100">
                    <div class="col-md-12">
                        <form action="{{ route('admin_furniture_update',['id'=>$furniture->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $furniture->id }}">
                            {{--<input type="hidden" name="right_answer_id" value="{{ $question->rightAnswer->id }}">--}}

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">
                                                Անվանում
                                            </label>
                                            <input type="text" name="name" value="{{ $furniture->name }}" class="form-control" id="name">
                                            @if($errors->has('name'))
                                                <p class="alert alert-danger">
                                                    {{ $errors->first('name') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="category">
                                                Կատեգորիա
                                            </label>
                                            <select name="category" id="category" class="form-control h-50">
                                                @foreach($categories as $category)
                                                    <option id="{{ $category->id }}" {{ $furniture->category_id == $category->id ? 'selected' : '' }}
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('category'))
                                                <p class="alert alert-danger">
                                                    {{ $errors->first('category') }}
                                                </p>
                                            @endif
                                        </div>
                                        {{--<div class="form-group">--}}
                                        {{--<label for="price">--}}
                                        {{--Արժեք--}}
                                        {{--</label>--}}
                                        {{--<input type="number" id="price" name="price" class="form-control" step="1000" value="{{ $furniture->price }}">--}}
                                        {{--</div>--}}
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label for="responsible">Պատասխանատու</label>
                                                <select name="responsible" id="responsible" class="form-control h-75">
                                                    <option value="" selected hidden>Ընտրել պատասխանատու</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{$furniture->user_id == $user->id?"selected" : ""}}>{{ $user->name }} ({{$user->schoolName }},{{$user->positionName}})</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('responsible'))
                                                    <p class="alert alert-danger p-3">
                                                        {{ $errors->first('responsible') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div id="categoryChange" class="row form-group ">
                                            <div class="select_box col-sm-12">
                                                <label for="categoriesStructure">Բաժին</label>
                                                <select name="categoriesStructure" id="categoriesStructure" class="form-control categoryStructureSelect" >
                                                    @foreach($categoriesStructureForUpdete as $categoryStructureForUpdete)
                                                        <option value="{{ $categoryStructureForUpdete->id }}"  selected hidden>{{ $categoryStructureForUpdete->category }}</option>
                                                    @endforeach
                                                    @foreach($categoriesStructure as $categoryStructure)
                                                        <option value="{{ $categoryStructure->id }}">{{ $categoryStructure->category }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('categoriesStructure'))
                                                    <p class="alert alert-danger p-3">
                                                        {{ $errors->first('categoriesStructure') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <label for="count">
                                                        Քանակ
                                                    </label>
                                                    <input type="number" id="count" name="count" class="form-control" value="{{ $furniture->count }}">
                                                    @if($errors->has('count'))
                                                        <p class="alert alert-danger">
                                                            {{ $errors->first('count') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="form-group">--}}
                                        {{--<label for="code">--}}
                                        {{--Կոդ--}}
                                        {{--</label>--}}
                                        {{--<input type="text" name="code" value="{{ $furniture->code }}" class="form-control" id="code">--}}
                                        {{--</div>--}}

                                    </div>
                                    <div class="col-md-6">
                                        {{--<div class="form-group">--}}
                                            {{--@if(!is_null($furniture->image))--}}
                                                {{--<label for="avatar">--}}
                                                    {{--<div class="main">--}}
                                                        {{--<img draggable="false" src="{{ asset('img/products/' . $furniture->image) }}" id="output" alt="" width="246" height="205">--}}
                                                        {{--<div class="for-user-bg">--}}
                                                            {{--<span>Upload Image</span>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</label>--}}
                                                {{--<input type="file" class="none" name="avatar" id="avatar">--}}
                                            {{--@else--}}
                                                {{--<label for="image" class="btn btn-primary">--}}
                                                    {{--Ներբեռնել նկար--}}
                                                {{--</label>--}}
                                                {{--<input type="file" style="display: none;" id="image" name="avatar">--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                                {{--<label for="school">--}}
                                                    {{--Դպրոց--}}
                                                {{--</label>--}}
                                                {{--<select name="school" id="school" class="form-control" style="height: 34px;">--}}
                                                    {{--@foreach($schools as $school)--}}
                                                        {{--<option value="{{ $school->id }}" {{ $school->id == $furniture->school_id ? 'selected' : '' }}>{{ $school->name }}</option>--}}
                                                    {{--@endforeach--}}
                                                {{--</select>--}}
                                            {{--@if($errors->has('school'))--}}
                                                {{--<p class="alert alert-danger">--}}
                                                    {{--{{ $errors->first('school') }}--}}
                                                {{--</p>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                        <div class="form-group">
                                            <label for="code">
                                                Կոդ
                                            </label>
                                            <input type="text" name="code" value="{{ $furniture->code }}" class="form-control" id="code">
                                            @if($errors->has('code'))
                                                <p class="alert alert-danger">
                                                    {{ $errors->first('code') }}
                                                </p>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="description">
                                                Նկարագիր
                                            </label>
                                            <textarea name="description" id="description" class="form-control" cols="20" rows="5">{{ $furniture->description }}</textarea>
                                            @if($errors->has('description'))
                                                <p class="alert alert-danger">
                                                    {{ $errors->first('description') }}
                                                </p>
                                            @endif
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
        // $("#avatar").on('change', function () {
        //     var input = event.target;
        //     var reader = new FileReader();
        //     reader.onload = function(){
        //         var dataURL = reader.result;
        //         var output = document.getElementById('output');
        //         output.src = dataURL;
        //         console.log(output);
        //     };
        //     reader.readAsDataURL(input.files[0]);
        // })


        $(document).on('change', '.categoryStructureSelect', function (e) {
            $(this).parents('.select_box').nextAll().remove();
            let changeId = e.target.value;
            $(`#test_${changeId}`).remove();

            $.get('/admin/changeSelect/' + changeId, function (data) {
                if (data.length !== 0) {
                    $('#categoryChange').append(`<div id="test_${changeId}" class="select_box col-sm-12"></div>`);
                    $(`#test_${changeId}`).append(`<label for="${changeId}_sel"><b>Ենթաբաժին</b></label>`);
                    $(`#test_${changeId}`).append(`<select id="${changeId}_sel" name="categoriesStructure" class="form-control categoryStructureSelect"></select>`);
                    $(`#${changeId}_sel`).append(`<option value='${changeId}' selected hidden>Ընտրել ենթաբաժին</option>`);
                    for (let category of data) {
                        $(`#${changeId}_sel`).append(`<option value="${category.id }">${category.category}</option>`);
                    }
                }
            });
        });

    </script>
@stop
