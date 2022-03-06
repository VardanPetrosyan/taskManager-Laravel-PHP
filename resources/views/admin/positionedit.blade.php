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
                        <form action="{{ route('admin_position_update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="position_id" value="{{ $position->id }}">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="positiontype">
                                                Տեսակ
                                            </label>
                                            <select name="positiontype" id="positiontype"
                                                    class="form-control h-100">
                                                <option value="standard" {{ 'standard' == $position->type? 'selected' : '' }}>Պատասխանատու</option>
                                                <option value="director" {{ 'director' == $position->type? 'selected' : '' }}>Տնօրեն</option>
                                                <option value="dep_director" {{ 'dep_director' == $position->type? 'selected' : '' }}>Բաժնի Վարիչ</option>
                                            </select>
                                            <label for="positionname">
                                                Անվանում
                                            </label>
                                            <input type="text" name="positionname" id="positionname"
                                                   value="{{ $position->name }}" class="form-control">
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
