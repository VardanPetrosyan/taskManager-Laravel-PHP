@extends('_layouts.admin')
@section('content')
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-4'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h4 class="lh-1 margined-header">Ավելացնել Նոր պաշտոն</h4>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <form method="post" action="{{ route('admin_position_create') }}"
                                      enctype="multipart/form-data" style="width: 100%">
                                    @csrf

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" placeholder="Պաշտոնի անվանումը"
                                                       name="name">
                                                @if($errors->has('name'))
                                                    <span class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-sm-12">
                                                <select name="positionType" class="form-control h-100">
                                                    <option value="" selected hidden>Պաշտոնի տեսակը</option>
                                                    <option value="standard">Պատասխանատու</option>
                                                    <option value="director">Տնօրեն</option>
                                                    <option value="dep_director">Բաժնի վարիչ</option>
                                                </select>
                                            </div>
                                            @if($errors->has('positionType'))
                                                <span class="invalid-feedback">
                                                    {{ $errors->first('positionType') }}
                                                    </span>
                                            @endif
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
                                            Բոլոր պաշտոները
                                    </h4>
                                </div>
                                <div class="col-sm-6">

                                </div>
                            </div>
                            <div class="peers ai-sb fxw-nw justify-content-center">
                                <div class="peers ai-sb fxw-nw">
                                    <table  class="table table-striped table-bordered table-responsive">
                                        <thead>
                                        <tr>
                                            <th class="bdwT-0">id</th>
                                            <th class="bdwT-0">Տեսակ</th>
                                            <th class="bdwT-0">Անվանում</th>
                                            <th class="bdwT-0">Կարգավորում</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($positions as $position)
                                            <tr>
                                                <td class="fw-600">{{ $position->id }}</td>
                                                @if($position->type == 'standard')
                                                    <td class="fw-600">Պատասխանատու</td>
                                                    @elseif($position->type == 'director')
                                                    <td class="fw-600">Տնօրեն</td>
                                                    @else
                                                    <td class="fw-600">Բաժնի վարիչ</td>
                                                    @endif

                                                <td class="fw-600">{{ $position->name }}</td>
                                                <td class="text-center">
                                                    <a title="Edit" class="btn btn-primary btn-sm"
                                                       href="{{ route('admin_position_edit', ['id' => $position->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" title="Delete" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#delUserModal{{$position->id}}">
                                                        <i class="far fa-times-circle"></i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <form action="{{ route('admin_position_deleteFinally',['id' => $position->id])}}"
                                                          name="modalDelete" method="get">
                                                        <div class="modal fade" id="delUserModal{{$position->id}}"
                                                             tabindex="-1"
                                                             role="dialog" aria-labelledby="exampleModalLabel"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Ջնջե՞լ {{ $position->name }}</h5>
                                                                        <a type="button" class="close"
                                                                           data-dismiss="modal"
                                                                           aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </a>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        @foreach($user as $id)
                                                                            @if($id->position == $position->id)
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">
                                                                                    Այդ պաշտոնով գրանցված է օգտատեր</h5>
                                                                                <div style="padding-top: 20px">
                                                                                    <p class="col-md-4">Փոխել</p>

                                                                                    <select name="selectPosition"
                                                                                            class="form-control col-md-4">
                                                                                        <option value="0" selected hidden>
                                                                                            Ընտրել պաշտոն
                                                                                        </option>
                                                                                        @foreach($positions as $pos)
                                                                                            @if($pos->id != $position->id)
                                                                                                <option value="{{$pos->id}}">{{$pos->name}}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div>
                                                                                    @if($errors->has('selectPosition'))
                                                                                        <span class="invalid-feedback">{{$errors->first('selectPosition')}}</span>
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
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
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


    </script>
@stop
