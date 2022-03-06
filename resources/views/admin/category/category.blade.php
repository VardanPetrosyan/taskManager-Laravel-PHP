@extends('_layouts.admin')
@section('content')
    <style>
        #table_length > select {
            height: 100px !important;
        }
    </style>
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-4'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h4 class="lh-1 margined-header">Ավելացնել Նոր կատեգորիա</h4>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <form action="{{ route('admin_categorie_store') }}" style="width: 100%">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-sm-12 control-label" for="name">Անուն</label>
                                                    <input type="text" name="name" id="name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="status">Կարգավիճակ</label>
                                                    <select class="form-control h-100" name="status" id="status">
                                                        <option value="active">Ակտիվ</option>
                                                        <option value="passive">Պասիվ</option>
                                                    </select>
                                                </div>
                                                {{--@if($errors->has('name'))--}}
                                                {{--<span class="invalid-feedback">--}}
                                                {{--{{ $errors->first('name') }}--}}
                                                {{--</span>--}}
                                                {{--@endif--}}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="subcategory">Ենթակատեգորիա</label>
                                                <select class="form-control h-50" name="parent">
                                                    <option></option>
                                                    @foreach($categories as $pod)
                                                        <option value="{{ $pod->id }}">{{$pod->name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--@if($errors->has('email'))--}}
                                                {{--<span class="invalid-feedback">--}}
                                                {{--{{ $errors->first('email') }}--}}
                                                {{--</span>--}}
                                                {{--@endif--}}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="storage">Պահեստ</label>
                                                <select name="storage" id="storage" class="form-control"
                                                        style="height: 35px;">
                                                    <option value="0">Առաջին</option>
                                                    <option value="1">Երկրորդ</option>
                                                    <option value="2">Գույք</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        @include('flash::message')
                                        <hr/>
                                        <input type="submit" value="Հաստատել" class="btn btn-success float-right">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-md-8'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="lh-1 margined-header">
                                        @if(Request::get('filter') == 'first')
                                            Առաջին պահեստ
                                        @elseif(Request::get('filter') == 'second')
                                            Երկրորդ պահեստ
                                        @else
                                            Բոլոր կատեգորիաները
                                        @endif
                                    </h4>
                                </div>
                                <div class="col-sm-6">
                                    <form action="{{ route('admin_categorie_all') }}" method="get">
                                        <label for="filter" class="float-right ml-3">
                                            <input type="submit" value="Տեսնել" id="filter" class="btn btn-dark">
                                        </label>
                                        <select class="form-control float-right" name="filter" id="filter"
                                                style="width: 207px; height: 33px;">
                                            <option value="all">Բոլոր Կատեգորիաները</option>
                                            <option value="first" {{ 'first' == Request::get('filter') ? 'selected' : '' }}>
                                                Առաջին պահեստ
                                            </option>
                                            <option value="second" {{ 'second' == Request::get('filter') ? 'selected' : '' }}>
                                                Երկրորդ պահեստ
                                            </option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <table id="table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th></th>
                                        <th>Անուն</th>
                                        <th>Ենթակատեգորիա</th>
                                        <th>Կարգավիճակ</th>
                                        <th>Պահեստ</th>
                                        <th>Կարգավորում</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($categories as $category)
                                        @if($category->parent == 0)
                                            <tr>
                                                <td>{{$category->id}}</td>
                                                <td></td>
                                                <td>{{$category->name}}</td>
                                                <td></td>
                                                @if($category->status == 'active')
                                                    <td>Ակտիվ</td>
                                                @else
                                                    <td>Պասիվ</td>
                                                @endif
                                                @if($category->story == '0')
                                                    <td>Առաջին պահեստ</td>
                                                @elseif($category->story == '1')
                                                    <td>Երկրորդ պահեստ</td>
                                                @else
                                                    <td>Գույք</td>
                                                @endif
                                                <td class="text-center">
                                                    <a title="Edit" class="btn btn-primary btn-sm"
                                                       href="{{ route('admin_category_edit', ['id' => $category->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" title="Delete" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#delUserModal{{$category->id}}">
                                                        <i class="far fa-times-circle"></i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <form action="{{ route('admin_category_deleteFinally',['id' => $category->id])}}"
                                                          name="modalDelete" method="get">
                                                        <div class="modal fade" id="delUserModal{{$category->id}}"
                                                             tabindex="-1"
                                                             role="dialog" aria-labelledby="exampleModalLabel"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Ջնջե՞լ {{ $category->name }}</h5>
                                                                        <a type="button" class="close"
                                                                           data-dismiss="modal"
                                                                           aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </a>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @foreach($categoryForDeleteProduct as $id)
                                                                            @if($id->category == $category->id)
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">
                                                                                    {{ $category->name }} կատեգորիան
                                                                                    ունի գրանցված ապրանք</h5>
                                                                                <div style="padding-top: 20px">
                                                                                    <p class="col-md-4">Տեղափոխել</p>

                                                                                    <select name="selectProductCategoryDelete"
                                                                                            id="selectDeleteProduct"
                                                                                            class="form-control col-md-4">
                                                                                        <option value="" selected
                                                                                                hidden>
                                                                                            Ընտրել կատեգորիա
                                                                                        </option>
                                                                                        @foreach($categories as $categoryName)
                                                                                            @if($categoryName->id != $id->category)
                                                                                                <option value="{{$categoryName->id}}">{{$categoryName->name}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div>
                                                                                    @if($errors->has('selectProductCategoryDelete'))
                                                                                        <span class="invalid-feedback">{{$errors->first('selectProductCategoryDelete')}}</span>
                                                                                    @endif
                                                                                </div>
                                                                                @break
                                                                            @endif
                                                                        @endforeach
                                                                        @foreach($categoryForDeleteFurniture as $id)
                                                                            @if($id->category_id == $category->id)
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">
                                                                                    {{ $category->name }} կատեգորիան
                                                                                    ունի գրանցված գույք</h5>
                                                                                <div style="padding-top: 20px">
                                                                                    <p class="col-md-4">Տեղափոխել</p>

                                                                                    <select name="selectFurnitureCategoryDelete"
                                                                                            id="selectDeleteFurniture"
                                                                                            class="form-control col-md-4">
                                                                                        <option value="" selected
                                                                                                hidden>
                                                                                            Ընտրել կատեգորիա
                                                                                        </option>
                                                                                        @foreach($categories as $categoryName)
                                                                                            @if($categoryName->id !=$id->category_id)
                                                                                                <option value="{{$categoryName->id}}">{{$categoryName->name}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div>

                                                                                    @if($errors->has('selectFurnitureCategoryDelete'))
                                                                                        <span class="invalid-feedback">{{$errors->first('selectFurnitureCategoryDelete')}}</span>
                                                                                    @endif
                                                                                </div>
                                                                                @break
                                                                            @endif

                                                                        @endforeach

                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <a type="button" class="btn btn-secondary"
                                                                           data-dismiss="modal">Չեղարկել
                                                                        </a>
                                                                        {{--                                                                        <button type="button" class="btn btn-danger">Ջնջել</button>--}}
                                                                        <button title="Delete" class="btn btn-danger"
                                                                                id="buttonDelete">
                                                                            Ջնջել
                                                                        </button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                        @foreach($categories as $categoryparent)
                                            @if($categoryparent->parent == $category->id)
                                                <tr>
                                                    <td>{{$categoryparent->id}}</td>
                                                    <td>↳</td>
                                                    <td>{{$categoryparent->name}}</td>
                                                    <td>{{$category->name}}</td>
                                                    @if($categoryparent->status == 'active')
                                                        <td>Ակտիվ</td>
                                                    @else
                                                        <td>Պասիվ</td>
                                                    @endif
                                                    @if($categoryparent->story == '0')
                                                        <td>Առաջին պահեստ</td>
                                                    @elseif($categoryparent->story == '1')
                                                        <td>Երկրորդ պահեստ</td>
                                                    @else
                                                        <td>Գույք</td>
                                                    @endif
                                                    <td class="text-center">
                                                        <a title="Edit" class="btn btn-primary btn-sm"
                                                           href="{{ route('admin_category_edit', ['id' => $categoryparent->id]) }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" title="Delete" class="btn btn-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#delUserModal{{$category->id}}">
                                                            <i class="far fa-times-circle"></i>
                                                        </button>
                                                        <!-- Modal -->
                                                        <form action="{{ route('admin_category_deleteFinally',['id' => $category->id])}}"
                                                              name="modalDelete" method="get">
                                                            <div class="modal fade" id="delUserModal{{$category->id}}"
                                                                 tabindex="-1"
                                                                 role="dialog" aria-labelledby="exampleModalLabel"
                                                                 aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                                Ջնջե՞լ {{ $category->name }}</h5>
                                                                            <a type="button" class="close"
                                                                               data-dismiss="modal"
                                                                               aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </a>

                                                                        </div>
                                                                        <div class="modal-body">
                                                                            @foreach($categoryForDeleteProduct as $id)
                                                                                @if($id->category == $category->id)
                                                                                    <h5 class="modal-title"
                                                                                        id="exampleModalLabel">
                                                                                        {{ $category->name }} կատեգորիան
                                                                                        ունի գրանցված ապրանք</h5>
                                                                                    <div style="padding-top: 20px">
                                                                                        <p class="col-md-4">Տեղափոխել</p>

                                                                                        <select name="selectProductCategoryDelete"
                                                                                                id="selectDeleteProduct"
                                                                                                class="form-control col-md-4">
                                                                                            <option value="" selected
                                                                                                    hidden>
                                                                                                Ընտրել կատեգորիա
                                                                                            </option>
                                                                                            @foreach($categories as $categoryName)
                                                                                                @if($categoryName->id != $id->category)
                                                                                                    <option value="{{$categoryName->id}}">{{$categoryName->name}}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div>
                                                                                        @if($errors->has('selectProductCategoryDelete'))
                                                                                            <span class="invalid-feedback">{{$errors->first('selectProductCategoryDelete')}}</span>
                                                                                        @endif
                                                                                    </div>
                                                                                    @break
                                                                                @endif
                                                                            @endforeach
                                                                            @foreach($categoryForDeleteFurniture as $id)
                                                                                @if($id->category_id == $category->id)
                                                                                    <h5 class="modal-title"
                                                                                        id="exampleModalLabel">
                                                                                        {{ $category->name }} կատեգորիան
                                                                                        ունի գրանցված գույք</h5>
                                                                                    <div style="padding-top: 20px">
                                                                                        <p class="col-md-4">Տեղափոխել</p>

                                                                                        <select name="selectFurnitureCategoryDelete"
                                                                                                id="selectDeleteFurniture"
                                                                                                class="form-control col-md-4">
                                                                                            <option value="" selected
                                                                                                    hidden>
                                                                                                Ընտրել կատեգորիա
                                                                                            </option>
                                                                                            @foreach($categories as $categoryName)
                                                                                                @if($categoryName->id !=$id->category_id)
                                                                                                    <option value="{{$categoryName->id}}">{{$categoryName->name}}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div>

                                                                                        @if($errors->has('selectFurnitureCategoryDelete'))
                                                                                            <span class="invalid-feedback">{{$errors->first('selectFurnitureCategoryDelete')}}</span>
                                                                                        @endif
                                                                                    </div>
                                                                                    @break
                                                                                @endif

                                                                            @endforeach

                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <a type="button" class="btn btn-secondary"
                                                                               data-dismiss="modal">Չեղարկել
                                                                            </a>
                                                                            {{--                                                                        <button type="button" class="btn btn-danger">Ջնջել</button>--}}
                                                                            <button title="Delete" class="btn btn-danger"
                                                                                    id="buttonDelete">
                                                                                Ջնջել
                                                                            </button>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
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
    <script type="text/javascript" src="{{ asset('admin/js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.tabledit.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    <script>

    </script>
@endsection
