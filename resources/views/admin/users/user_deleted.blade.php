@extends('_layouts.admin')
@section('content')
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-item w-100">
            <div class="row gap-20">
                <div class='col-md-12'>
                    <div class="layers bd bgc-white p-20">
                        <div class="layer w-100 mB-10">
                            <h4 class="lh-1 margined-header">Արխիվ</h4>
                        </div>
                        <div class="layer w-100">
                            <div class="peers ai-sb fxw-nw">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="bdwT-0" style="width: 120px">Նկար</th>
                                        <th class="bdwT-0">Անուն</th>
                                        <th class="bdwT-0">Էլ հասցե</th>
                                        <th class="bdwT-0">Կարգավիճակ</th>
                                        <th class="bdwT-0">Պաշտոն</th>
                                        <th class="bdwT-0">Դպրոց</th>
                                        <th class="bdwT-0">Կարգավորում</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="fw-600"><img src="{{ asset('assets/images/upload/' . $user->img) }}" alt="Logo" style="width: 110px; height: 110px;"></td>
                                            <td class="fw-600">{{ $user->name }}</td>
                                            <td class="fw-600">{{ $user->email }}</td>
                                            <td class="fw-600">{{ $user->status }}</td>
                                            <td class="fw-600">{{ $user->positionName }}</td>
                                            <td class="fw-600">{{ $user->schoolName }}</td>
                                            <td class="text-left">
                                                <a title="Edit" class="btn btn-primary btn-sm" href="{{ route('admin_user_edit', ['id' => $user->id]) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($user->status != App\Models\User::STATUS_DELETED)
                                                    <a title="Deactivate" class="btn btn-danger btn-sm" href="{{ route('admin_user_delete', ['id' => $user->id]) }}">
                                                        <i class="far fa-star"></i>
                                                    </a>
                                                @else
                                                    <a title="Activate" class="btn btn-success btn-sm" href="{{ route('admin_user_treat', ['id' => $user->id]) }}">
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
