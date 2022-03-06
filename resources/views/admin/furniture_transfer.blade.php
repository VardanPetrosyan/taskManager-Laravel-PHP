@extends('_layouts.admin')

@section('content')
    <div class="masonry-item col-md-6 offset-md-3">
        <div class="bd bgc-white">
            <div class="layers">
                <div class="layer w-100 p-20">
                    <h4 class="lh-1">Գույքի տեղափոխում</h4>
                </div>
                <div class="layer w-100">
                    <div class="col-md-12">
                        <form action="{{ route('admin_furniture_update_transfer',['id'=>$furniture->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $furniture->id }}">
                            {{--<input type="hidden" name="right_answer_id" value="{{ $question->rightAnswer->id }}">--}}

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label for="responsible">Պատասխանատու</label>
                                                <select name="responsible" id="responsible" class="form-control h-75">
                                                    <option value="" selected hidden>Ընտրել պատասխանատու</option>
                                                    @foreach($users as $user)
                                                        @if($user->id != $furniture->user_id)
                                                        <option value="{{ $user->id }}" {{$furniture->user_id == $user->id?"selected" : ""}}>{{ $user->name }} ({{$user->schoolName }},{{$user->positionName}})</option>
                                                        @endif
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
                                                    <input type="number" id="count" name="count" class="form-control" min="1" max="{{ $furniture->count}}" value="{{ $furniture->count }}">
                                                    @if($errors->has('count'))
                                                        <p class="alert alert-danger">
                                                            {{ $errors->first('count') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" class="btn btn-success float-right" value="Տեղափոխել">
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

        $(document).ready(function () {
            $('#responsible').select2();
        });
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
