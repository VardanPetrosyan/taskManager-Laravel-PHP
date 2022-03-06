@extends('_layouts.admin')

@section('content')
    <div class="masonry-item col-md-6 offset-md-3">
        <div class="bd bgc-white">
            <div class="layers">
                <div class="layer w-100 p-20">
                    <h4 class="lh-1">Կատեգորիայի կարգավորում</h4>
                </div>
                <div class="layer w-100">
                    <div class="col-md-12">
                        <form action="{{ route('admin_category_update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $categories->id }}">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">
                                                Կատեգորիա
                                            </label>
                                            <input type="text" name="category" id="category"
                                                   value="{{ $categories->name }}" class="form-control">
                                            <label for="parentcategory">
                                                Ենթակատեգորիա
                                            </label>
                                            <select name="parentcategory" id="parentcategory"
                                                    class="form-control h-100">
                                                @if($categoryparent->name == '')
                                                    <option value="0">{{$categoryparent->name}}</option>
                                                @else
                                                    <option value="0">Ենթաբաժին չի</option>
                                                @endif
                                                @foreach($categoryAll as $category)
                                                    @if($categoryparent->name != '')
                                                        @if($category->parent != 0)
                                                            <option value={{$category->id}} {{ $categoryparent->id == $category->id? 'selected' : '' }}><b>↳</b>  {{$category->name}}</option>
                                                        @else
                                                            <option value={{$category->id}} {{ $categoryparent->id == $category->id? 'selected' : '' }}>{{$category->name}}</option>
                                                        @endif
                                                    @else
                                                            @if($category->parent != 0)
                                                                <option value={{$category->id}} ><b>↳</b>  {{$category->name}}</option>
                                                            @else
                                                                <option value={{$category->id}} >{{$category->name}}</option>
                                                            @endif

                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">
                                                Կարգավիճակ
                                            </label>
                                            <select name="status" id="status" class="form-control h-100">
                                                <option value="active" {{ $categories->status == "active" ? 'selected' : '' }}>
                                                    Ակտիվ
                                                </option>
                                                <option value="passive" {{ $categories->status == "passive" ? 'selected' : '' }}>
                                                    Պասիվ
                                                </option>
                                            </select>

                                            <label for="story">
                                                Պահեստ
                                            </label>
                                            <select name="story" id="story" class="form-control h-100">
                                                <option value="0" {{ $categories->story == 0 ? 'selected' : '' }}>Առաջին
                                                    պահեստ
                                                </option>
                                                <option value="1" {{ $categories->story == 1 ? 'selected' : '' }}>
                                                    Երկրորդ պահեստ
                                                </option>
                                                <option value="2" {{ $categories->story == 2 ? 'selected' : '' }}>
                                                    Գույք
                                                </option>
                                            </select>
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

    </script>
@stop
