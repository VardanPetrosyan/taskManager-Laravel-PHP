@extends('_layouts.admin')

@section('content')
    <div class="masonry-item col-md-6 offset-md-3">
        <div class="bd bgc-white">
            <div class="layers">
                <div class="layer w-100 p-20">
                    <h4 class="lh-1">Օգտագերի տվյալների կարգավորում</h4>
                </div>
                <div class="layer w-100">
                    <div class="col-md-12">
                        <form action="{{ route('admin_user_update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            {{--<input type="hidden" name="right_answer_id" value="{{ $question->rightAnswer->id }}">--}}

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <label for="avatar" @if(is_null($user->img)) class="btn btn-primary btn-md" style="margin-left: 59px;" @endif >
                                                @if(!is_null($user->img))
                                                    <div class="main">
                                                        <img draggable="false" src="{{ asset('assets/images/upload/'.$user->img) }}" id="output" alt="No" width="246" height="205">
                                                        <div class="for-user-bg">
                                                            <span>Upload Image</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    Ներբեռնել նկար
                                                @endif 
                                            </label>
                                            <input type="file" class="none" name="img" id="avatar">
                                        </div>                                    
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">
                                                Անուն
                                            </label>
                                            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                                            <label for="email">
                                                Էլ հասցե
                                            </label>
                                            <input type="text" name="email" id="email" value="{{ $user->email }}" class="form-control">
                                            <label for="password">
                                                Գաղտնաբառ
                                            </label>
                                            <input type="password" id="password" name="password" class="form-control">
                                            <label for="status">
                                                Կարգավիճակ
                                            </label>
                                            <select name="status" id="status" class="form-control h-100">
                                                <option value="admin" {{ $user->status == App\Models\User::STATUS_ADMIN ? 'selected' : '' }}>Ադմին</option>
                                                <option value="user" {{ $user->status == App\Models\User::STATUS_USER ? 'selected' : '' }}>Օգտատեր</option>
                                                <option value="manager" {{ $user->status == App\Models\User::STATUS_MANAGER ? 'selected' : '' }}>Մենեջեր</option>
                                                <option value="deleted" {{ $user->status == App\Models\User::STATUS_DELETED ? 'selected' : '' }}>Արխիվ</option>
                                            </select>

                                            <label for="position">
                                                Պաշտոն
                                            </label>
                                            <select name="position" id="position" class="form-control h-100">

                                                @foreach($positions as $position)
                                                    <option value="{{$position->id}}" {{ $user->position == $position->id ? 'selected' : '' }}>{{ $position->name  }}</option>
                                                @endforeach
                                            </select>


                                            <div id="categoryChange" class="row mt-3">
                                                <div class="select_box col-sm-12">
                                                    <label for="categoryStructure"><b>Բաժին</b></label>
                                                    <select id="categoryStructure" name="categoriesStructure"
                                                            class="form-control categoryStructureSelect">
                                                        @foreach($categoriesStructureForUpdete as $categoryStructureForUpdete)
                                                            <option value="{{$categoryStructureForUpdete->id}}" selected hidden>{{ $categoryStructureForUpdete->category  }}</option>
                                                        @endforeach
                                                        @foreach($categoriesStructure as $categoryStructure)
                                                            <option value="{{$categoryStructure->id}}">{{ $categoryStructure->category  }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>




                                            {{--<label for="categoriesStructure">--}}
                                                {{--Դպրոց--}}
                                            {{--</label>--}}
                                            {{--<select name="categoriesStructure" id="categoriesStructure" class="form-control h-100">--}}
                                                {{--@foreach($categoriesStructure as $categoryStructure)--}}

                                                {{--@endforeach--}}
                                            {{--</select>--}}

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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
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
        });

        $(document).on('change', '.categoryStructureSelect', function (e) {
            $(this).parents('.select_box').nextAll().remove();
            let changeId = e.target.value;

            $(`#test_${changeId}`).remove();

            $.get('/admin/changeSelect/' + changeId, function (data) {
                if (data.length !== 0) {
                    $('#categoryChange').append(`<div id="test_${changeId}" class="select_box col-sm-12"></div>`);
                    $(`#test_${changeId}`).append(`<label for="${changeId}_sel"><b>Ենթաբժին</b></label>`);
                    $(`#test_${changeId}`).append(`<select id="${changeId}_sel" name="categoriesStructure" class="form-control categoryStructureSelect"></select>`);
                    $(`#${changeId}_sel`).append(`<option value='${changeId}' selected hidden>Ընրել ենթաբաժին</option>`);
                    for (let category of data) {
                        $(`#${changeId}_sel`).append(`<option value="${category.id }">${category.category}</option>`);
                    }
                }
            });
        });
    </script>
@stop
