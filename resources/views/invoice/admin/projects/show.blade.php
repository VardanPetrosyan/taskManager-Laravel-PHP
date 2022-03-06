@extends('invoice._layouts.admin')
@section('page-name', 'Show Project')

@section('styles')
    <style>
        #addMember .modal-body {
            position: relative;
        }
        #addMember .modal-search ul{
            position: absolute;
            z-index: 1;
            width: 85%;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            box-shadow: 0 27px 24px 0 rgba(0,0,0,.2), 0 40px 77px 0 rgba(0,0,0,.22);
            list-style: none;
            margin: 0;
            padding: 0;
        }
        #addMember .modal-search ul li {
            border-bottom: 1px solid rgba(0,0,0,.2);
        }
        .removeBtn {
            display: none;
        }

        @media (max-width: 767px) {
            .freverse {
                display: flex;
                flex-direction: column-reverse;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row freverse">
            <div class="col-md-8 addMemberUser">
                <div class="card">
                    <div class="card-header card-header-icon card-header-{{ $sidebar->filters }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title" style="margin-bottom: 15px">{{ $project->name }}</h4>
                            <div>
                                <button class="btn btn-danger btn-sm removeBtn">Remove from team</button>
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addMember">Add members...</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <ul class="nav nav-pills nav-pills-{{ $sidebar->filters }}" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link @if(request()->request->get('tab') == 'users' || count(request()->request) == 0)  active show  @endif links" data-toggle="tab" href="#link1" data-link="users" role="tablist">
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->request->get('tab') == 'tasks')  active show  @endif links" data-toggle="tab" href="#link2" role="tablist"  data-link="tasks">
                                Tasks
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content tab-space">
                        <div class="tab-pane add_users @if(request()->request->get('tab') == 'users' || count(request()->request) == 0)  active show  @endif" id="link1">
                            @foreach($projectUser as $pro_us)
                                <div class="pl-1 mb-3">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" value="" data-id="{{ $pro_us->users->id }}">
                                            <img src="{{ asset($pro_us->users->img) }}" alt="" width="30" style="margin-left: 5px; margin-right: 5px">
                                            <a href="javascript:;">{{ $pro_us->users->name }}</a>
                                            <span class="form-check-sign" style="top: 5px">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-pane @if(request()->request->get('tab') == 'tasks')  active show  @endif" id="link2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Avatar</th>
                                            <th>Name</th>
                                            <th>Task Number</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($tasks as $i => $task)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td><a href="{{ route('invoice.admin.users_edit', ['id' => $task->users->id]) }}"><img src="{{ asset($task->users->img) }}" alt="" width="50"></a></td>
                                                <td><a href="{{ route('invoice.admin.users_edit', ['id' => $task->users->id]) }}">{{ $task->users->name }}</a></td>
                                                <td>{{ $task->task_number }}</td>
                                                <td>{{ $task->title }}</td>
                                                <td>{{ str_limit(strip_tags($task->description), 20) }}</td>
                                                <td>{{ date_format(new DateTime($task->date), 'd/M/Y') }}</td>
                                                <td>{{ $task->time }}</td>
                                                <td class="td-actions d-flex justify-content-end">
                                                    <a href="{{ route('invoice.admin.project_edit_task', ['id' => $task->id])}}" rel="tooltip" class="btn btn-success btn-link btnEdit" data-id="{{ $task->id }}">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <h3>No task to show</h3>
                                                </td>
                                            </tr>
                                        @endforelse
                                        {!! $tasks->appends(['tab' => 'tasks'])->links() !!}
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="javascript:;">
                            <img class="img" src="{{ asset($project->logo) }}" />
                        </a>
                    </div>
                    <div class="card-body">
                        <h6 class="card-category text-gray">About</h6>
                        <h4 class="card-title">Owned by {{ $project->users->name }}</h4>
                        <p class="card-description">
                            Created on {{ date_format(new DateTime($project->created_at), 'M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-mini modal-primary" id="addMember" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-small">
            <div class="modal-content">
                <div class="modal-header">
                    <span>Add Team Member</span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                </div>
                <div class="modal-body">
                    <input type="text" placeholder="Select user" class="form-control" id="input-field" autocomplete="off">
                    <div class="modal-search">
                        <ul id="myUL">
                        </ul>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div data-notify="container" class="col-11 col-md-2 alert alert-success alert-with-icon animated fadeInDown fadeOutUp" role="alert" data-notify-position="bottom-right" style="display: inline-block; margin: 15px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1031; bottom: 20px; right: 20px;"><button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 50%; margin-top: -9px; z-index: 1033;"><i class="material-icons">close</i></button><i data-notify="icon" class="material-icons">add_alert</i><span data-notify="title"></span> <span data-notify="message">Project created successfully!</span><a href="#" target="_blank" data-notify="url"></a></div>

    <input type="hidden" id="route" data-route="{{ route('invoice.admin.project_check_user') }}"
            data-route-add="{{ route('invoice.admin.project_add_user') }}"
            data-route-remove="{{ route('invoice.admin.project_remove_user') }}">
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
    <script>
        let projectId = {{ $project->id }}
    </script>
@endsection
