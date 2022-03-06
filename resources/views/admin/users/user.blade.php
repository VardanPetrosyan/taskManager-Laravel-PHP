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
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-3'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h4 class="lh-1 margined-header">Ավելացնել Նոր օգտատեր</h4>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <form method="post" action="{{ route('admin_users_create') }}"
                                      enctype="multipart/form-data" style="width: 100%">
                                    @csrf

                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="col-sm-12 control-label label-to-choose btn btn-primary"
                                                           style="float:left;" for="avatar">
                                                        Օգտատերի նկար
                                                        <i class="fas fa-check selected-icon none"></i>
                                                        <input type="file" id="avatar" name="add_image"
                                                               class="file-aupload" style="display: none;">
                                                    </label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="name"
                                                           placeholder="Անուն">
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
                                                <input type="text" class="form-control" placeholder="Էլ հասցե"
                                                       name="email">
                                                @if($errors->has('email'))
                                                    <span class="invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <input type="password" class="form-control" placeholder="Գաղտնաբառ"
                                                       name="password">
                                                <span style="color:#aba5a5;">*նվազագույնը 6 սիմվոլ</span>

                                                @if($errors->has('password'))
                                                    <span class="invalid-feedback">
                                                        {{ $errors->first('password') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <select name="status" class="form-control h-100">
                                                    <option value="user">Օգտատեր</option>
                                                    <option value="admin">Ադմին</option>
                                                    <option value="manager">Մենեջեր</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div id="categoryChange" class="row mt-3">
                                            <div class="select_box col-sm-12">
                                                <label for="categoryStructure"><b>Բաժին</b></label>
                                                <select id="categoryStructure" name="categoryStructure"
                                                        class="form-control categoryStructureSelect">
                                                    <option value="" selected hidden>Ընտրել բաժին</option>
                                                    @foreach($categoriesStructure as $categoryStructure)
                                                        <option value="{{ $categoryStructure->id }}">{{ $categoryStructure->category }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <label for=""><b>Պաշտոն</b></label>
                                                <select id="position" name="position" class="form-control">
                                                    @foreach($positions as $position)
                                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                    @endforeach
                                                </select>
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
                                    <div class="form-group ">
                                        <hr/>
                                        <input type="submit" value="Հաստատել" class="btn btn-success float-right">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-md-9'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="lh-1 margined-header">
                                        @if(Request::get('filter') == 'user')
                                            Օգտատերեր
                                        @elseif(Request::get('filter') == 'deleted')
                                            Արխիվ
                                        @elseif(Request::get('filter') == 'admin')
                                            Ադմիններ
                                        @else
                                            Բոլոր օգտատերերը
                                        @endif
                                    </h4>
                                </div>
                                <div class="col-sm-6">
                                    <form action="{{ route('admin_user_list') }}" method="get">
                                        <label for="filter" class="float-right ml-3">
                                            <input type="submit" value="Տեսնել" id="filter" class="btn btn-dark">
                                        </label>
                                        <select class="form-control float-right" name="filter" id="filter"
                                                style="width: 175px; height: 33px;">
                                            <option value="all">Բոլոր Օգտատերերը</option>
                                            <option value="user" {{ 'user' == Request::get('filter') ? 'selected' : '' }}>
                                                Օգտատերեր
                                            </option>
                                            <option value="admin" {{ 'admin' == Request::get('filter') ? 'selected' : '' }}>
                                                Ադմիններ
                                            </option>
                                            <option value="deleted" {{ 'deleted' == Request::get('filter') ? 'selected' : '' }}>
                                                Արխիվ
                                            </option>
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
                                        <th class="bdwT-0" style="width: 120px">Նկար</th>
                                        <th class="bdwT-0" id="firstName">Անուն</th>
                                        <th class="bdwT-0">Էլ հասցե</th>
                                        <th class="bdwT-0">Կարգավիճակ</th>
                                        <th class="bdwT-0">Բաժին</th>
                                        <th class="bdwT-0">Պաշտոն</th>
                                        <th class="bdwT-0">Գույք</th>
                                        <th class="bdwT-0">Կարգավորում</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="fw-600"><img
                                                        src="{{ asset('assets/images/upload/'.$user->img) }}" alt="Logo"
                                                        style="width: 80px; height: 80px;"></td>
                                            <td class="fw-600" >{{ $user->name }}</td>
                                            <td class="fw-600">{{ $user->email }}</td>
                                            <td class="fw-600">{{ $user->status }}</td>
                                            {{--                                            @dd($user);--}}


                                            <td class="fw-600">{{ $user->schoolName }}</td>
                                            <td class="fw-600">{{ $user->positionName}}</td>


                                            @if(in_array($user->id,$userIdForDeleteArr))
                                                <td class="fw-600">ունի</td>
                                            @else
                                                <td class="fw-600">չունի</td>
                                            @endif

                                            <td class="text-center">
                                                <a title="Փոփոխել" class="btn btn-primary btn-sm"
                                                   href="{{ route('admin_user_edit', ['id' => $user->id]) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($user->status != App\Models\User::STATUS_DELETED)
                                                    <a title="Deactivate" class="btn btn-danger btn-sm"
                                                       href="{{ route('admin_user_delete', ['id' => $user->id]) }}">
                                                        <i class="far fa-star"></i>
                                                    </a>
                                                @else
                                                    <a title="Activate" class="btn btn-success btn-sm"
                                                       href="{{ route('admin_user_treat', ['id' => $user->id]) }}">
                                                        <i class="far fa-star"></i>
                                                    </a>
                                            @endif

                                            <!-- Button trigger modal -->
                                                <button type="button" title="Ջնջել" class="btn btn-danger btn-sm"
                                                        data-toggle="modal" data-target="#delUserModal{{$user->id}}">
                                                    <i class="far fa-times-circle"></i>
                                                </button>

                                            </td>
                                        </tr>
                                        <div class="modal fade" id="delUserModal{{$user->id}}" tabindex="-1"
                                             role="dialog" aria-labelledby="exampleModalLabel"
                                             aria-hidden="true">
                                            <form action="{{ route('admin_user_deleteFinally',['id' => $user->id])}}"
                                                  name="modalDelete" method="get">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Ջնջե՞լ {{ $user->name }}</h5>
                                                            <a type="button" class="close" data-dismiss="modal"
                                                               aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </a>
                                                        </div>
                                                        <div class="modal-body">

                                                            @foreach($userIdForDeleteArr as $id)
                                                                @if($id == $user->id)
                                                                    <h5 class="modal-title" id="exampleModalLabel">{{ $user->name }} օգտատերը ունի գույք</h5>
                                                                    <div style="padding-top: 20px">
                                                                        <p class="col-md-4">Տեղափոխել</p>

                                                                        <select name="selectUserDelete" id="selectDeleteUser" class="form-control col-md-4">
                                                                            <option value="0" selected hidden>Ընտրել օգտատեր</option>
                                                                            @foreach($usersForSelect as $userName)
                                                                                @if($userName->id != $id)
                                                                                    <option value="{{$userName->id}}">{{$userName->name }}&nbsp;&nbsp;({{$userName->schoolName}})</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <p class="col-md-2">-ին</p>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            <div>
                                                                @if($errors->has('selectUserDelete'))
                                                                    <span class="invalid-feedback">{{$errors->first('selectUserDelete')}}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <a type="button" class="btn btn-secondary"
                                                               data-dismiss="modal">Չեղարկել
                                                            </a>
                                                            {{--<button type="button" class="btn btn-danger">Ջնջել</button>--}}
                                                            <button title="Delete" class="btn btn-danger"
                                                                    id="buttonDelete">
                                                                Ջնջել
                                                            </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!-- Modal -->

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
@section('script')
    <script type="text/javascript">
        $("#avatar").on('change', function () {
            $(this).prev().removeClass('none');
        });
        // $(document).on('change','#selectDeleteUser',function(e){
        //    let value = e.target.value;
        //     console.log(value);
        //    if(value >= 0){
        //        $('#buttonDelete').attr("disabled", false);
        //
        //    }else{
        //        $('#buttonDelete').attr("disabled", true);
        //        $('#errorDelete').text = 'Պարտադիր նշել պատասխանատու';
        //    }
        // });

        $(document).on('change', '.categoryStructureSelect', function (e) {
            $(this).parents('.select_box').nextAll().remove();
            let changeId = e.target.value;

            $(`#test_${changeId}`).remove();

            $.get('/admin/changeSelect/' + changeId, function (data) {
                if (data.length !== 0) {
                    $('#categoryChange').append(`<div id="test_${changeId}" class="select_box col-sm-12"></div>`);
                    $(`#test_${changeId}`).append(`<label for="${changeId}_sel"><b>Ենթաբաժին</b></label>`);
                    $(`#test_${changeId}`).append(`<select id="${changeId}_sel" name="categoryStructure" class="form-control categoryStructureSelect"></select>`);
                    $(`#${changeId}_sel`).append(`<option value='${changeId}' selected hidden>Ընտրել ենթաբաժին</option>`);
                    for (let category of data) {
                        $(`#${changeId}_sel`).append(`<option value="${category.id}">${category.category}</option>`);
                    }
                }
            });
        });
        let table = $('#example').DataTable({
            "order": [],
            initComplete: function () {
                const textNodeSearch = $("#example_filter").children().contents().filter(function () {
                    return this.nodeType == 3; // Node.TEXT_NODE;
                }).get(0);

                textNodeSearch.data =
                    textNodeSearch.nodeValue =
                        textNodeSearch.textContent =
                            textNodeSearch.wholeText =
                                "Որոնել";

                const textItems = $("#example_length").children().contents().filter(function () {
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
        table.columns('.fff' ).search( 'Important' ).draw()


    </script>
@stop
