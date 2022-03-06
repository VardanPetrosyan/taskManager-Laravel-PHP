@extends('invoice._layouts.admin')
@section('page-name', 'Reports')
@section('styles')
    <style>
        .link-color {
            color: #0f5b99;
        }

        .link-color:hover {
            color: #ff008c;
            text-decoration: underline;
        }
        .reportCancelBtn {
            transition: .3s;
        }
        .reportCancelBtn:hover {
            background: #f44336!important;
            color: #fff!important;
        }
        #reportEditBtn {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-center">Reports</h3>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-pills nav-pills-{{ $sidebar->filters }} flex-column" role="tablist">
                                    @forelse($reports as $report)
                                        <li class="nav-item">
                                            <a class="nav-link report-link @if($report->slug == request()->get('report-link')) active @endif" data-toggle="tab" data-id="{{ $report->id }}" href="#{{ $report->slug }}"
                                               role="tablist">{{ $report->name }}</a>
                                        </li>
                                    @empty
                                        <li class="nav-item text-center" style="font-size: 16px">
                                            Not Report to show
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header card-header__content">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2>@if($reportName) {{ $reportName->name }} @else Create Report @endif</h2>
                                    <div style="margin-right: 20px;">
                                        <button type="button" class="btn btn-info btn-round btn-fab" id="reportEditBtn" title="edit"><i class="material-icons">edit</i></button>
                                        <button type="button" class="btn btn-{{ $sidebar->filters }} btn-round btn-fab" id="reportCreateBtn"><i class="material-icons">add</i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div  style="display: none; margin-bottom: 50px;">
                                    <form id="editForm" action="{{ route('invoice.admin.reports_store') }}" method="POST" novalidate="novalidate">
                                        @csrf
                                        <div class="form-group bmd-form-group">
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <label for="reportName" class="bmd-label">Name *</label>
                                                </div>
                                                <div class="col-sm-11">
                                                    <input type="text" class="form-control" name="name" id="reportName"
                                                           required aria-required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group bmd-form-group">
                                            <div class="row">
                                                <div class="col-sm-1 mb-3">
                                                    <label for="reportProjects" class="bmd-label">Projects
                                                        *</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <select class="selectpicker" data-style="select-with-transition"
                                                            name="projects[]" id="reportProjects" multiple=""
                                                            title="Choose Projects" required>
                                                        @foreach($projects as $project)
                                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="bootstrap-tagsinput info-badge projects-input">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group bmd-form-group">
                                            <div class="row">
                                                <div class="col-sm-1 mb-3">
                                                    <label for="reportUsers" class="bmd-label">Work author</label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <select class="selectpicker" data-style="select-with-transition"
                                                            name="users[]" id="reportUsers" multiple=""
                                                            title="Choose Projects">
                                                        <option value="all">All user</option>
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="bootstrap-tagsinput info-badge users-input">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <label for="reportFrom" class="bmd-label">Date From*</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <div class="bmd-form-group">
                                                                <input type="text" id="reportFrom" name="from" class="form-control datepicker" value="{{ date('d') . '/' . date('m') . '/' . date('Y') }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-5">
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <label for="reportTo" class="bbmd-label">Date To*</label>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <div class="bmd-form-group">
                                                                <input type="text" id="reportTo" name="to" class="form-control datepicker" value="{{ date('d') . '/' . (date('m') + 1) . '/' . date('Y') }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-outline-danger reportCancelBtn">Cancel</button>
                                            <button type="submit" class="btn btn-success">Save</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-content">
                                    @foreach($reports as $report)
                                        <div class="tab-pane report-tab @if($report->slug == request()->get('report-link')) active @endif" id="{{ $report->slug }}">
                                            <ul class="nav nav-pills nav-pills-{{ $sidebar->filters }}" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link per-link @if(request()->get('per') == 'user') active @endif" data-toggle="tab" href="#per_user_{{ $report->slug }}" role="tablist" data-link="user">
                                                        Per User
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link per-link @if(request()->get('per') == 'issue') active @endif" data-toggle="tab" href="#per_issue_{{ $report->slug }}" role="tablist" data-link="issue">
                                                        Per Issue
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link per-link per_project @if(request()->get('per') == 'project') active @endif" data-toggle="tab" href="#per_project_{{ $report->slug }}" role="tablist" data-link="project">
                                                        Per Project
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="d-flex justify-content-between mt-4">
                                                <div><h4>Total time</h4></div>
                                                <div class="total_time"></div>
                                            </div>
                                            <div class="table-responsive">
                                                <div class="tab-content">
                                                <div class="tab-pane active" id="per_user_{{ $report->slug }}">
                                                    <table class="table">
                                                        <thead class=" text-primary">
                                                        <tr>
                                                            <th width="40">
                                                                #
                                                            </th>
                                                            <th width="100">
                                                                Avatar
                                                            </th>
                                                            <th>
                                                                User Name
                                                            </th>
                                                            <th class="text-right">
                                                                Time spent
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(count($report->reportProjects) > 0)
                                                            @if(count($report->reportUsers) == 0)
                                                                @php($j = 0)
                                                                @foreach($report->reportProjects as $i => $project)
                                                                    @foreach($project->getTasks as $task)
                                                                        @php($j++)
                                                                        <tr>
                                                                            <td>{{ $j }}</td>
                                                                            <td>
                                                                                <a href="{{ route('invoice.admin.users_edit', ['id' => $task->users->id]) }}" class="link-color">
                                                                                    <img src="{{ asset($task->users->img) }}" title="{{ $task->users->name }}" alt="" width="50">
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <a href="{{ route('invoice.admin.users_edit', ['id' => $task->users->id]) }}" class="link-color">
                                                                                    {{ $task->users->name }}
                                                                                </a>
                                                                            </td>
                                                                            <td class="text-right spent_time">{{ $task->time }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endforeach
                                                            @else
                                                                @php($j = 0)
                                                                @foreach($report->reportProjects as $i => $project)
                                                                    @foreach($report->reportUsers as $user)
                                                                        @foreach($tasks as $task)
                                                                            @if($project->project_id == $task->project_id && $user->user_id == $task->user_id)
                                                                                @php($j++)
                                                                                <tr>
                                                                                    <td>{{ $j }}</td>
                                                                                    <td>
                                                                                        <a href="{{ route('invoice.admin.users_edit', ['id' => $task->users->id]) }}" class="link-color">
                                                                                            <img src="{{ asset($task->users->img) }}" title="{{ $task->users->name }}" alt="" width="50">
                                                                                        </a>
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="{{ route('invoice.admin.users_edit', ['id' => $task->users->id]) }}" class="link-color">
                                                                                            {{ $task->users->name }}
                                                                                        </a>
                                                                                    </td>
                                                                                    <td class="text-right spent_time">{{ $task->time }}</td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane @if(request()->get('per') == 'issue') active @endif" id="per_issue_{{ $report->slug }}">
                                                    <table class="table">
                                                        <thead class=" text-primary">
                                                        <tr>
                                                            <th width="40">
                                                                #
                                                            </th>
                                                            <th width="100">
                                                                Task Number
                                                            </th>
                                                            <th>
                                                                Task Title
                                                            </th>
                                                            <th class="text-right">
                                                                Time spent
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(count($report->reportProjects) > 0)
                                                            @php($j = 0)
                                                            @foreach($report->reportProjects as $i => $project)
                                                                @if(count($report->reportUsers) == 0)
                                                                    @foreach($project->getTasks as $task)
                                                                        @php($j++)
                                                                        <tr>
                                                                            <td>{{ $j }}</td>
                                                                            <td><a href="{{ route('invoice.admin.task_show', ['id' => $task->id]) }}" class="link-color">{{ $task->task_number }}</a></td>
                                                                            <td><a href="{{ route('invoice.admin.task_show', ['id' => $task->id]) }}" class="link-color">{{ $task->title }}</a></td>
                                                                            <td class="text-right">{{ $task->time }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    @foreach($report->reportUsers as $user)
                                                                        @foreach($tasks as $task)
                                                                            @if($project->project_id == $task->project_id && $user->user_id == $task->user_id)
                                                                                @php($j++)
                                                                                <tr>
                                                                                    <td>{{ $j }}</td>
                                                                                    <td><a href="{{ route('invoice.admin.task_show', ['id' => $task->id]) }}" class="link-color">{{ $task->task_number }}</a></td>
                                                                                    <td><a href="{{ route('invoice.admin.task_show', ['id' => $task->id]) }}" class="link-color">{{ $task->title }}</a></td>
                                                                                    <td class="text-right">{{ $task->time }}</td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane @if(request()->get('per') == 'project') active @endif" id="per_project_{{ $report->slug }}">
                                                    <table class="table">
                                                        <thead class=" text-primary">
                                                        <tr>
                                                            <th width="40">
                                                                #
                                                            </th>
                                                            <th>
                                                                Project Name
                                                            </th>
                                                            <th class="text-right">
                                                                Time spent
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(count($report->reportProjects) > 0)
                                                            @php($j = 0)
                                                                @foreach($report->reportProjects as $i => $project)
                                                                    @if(count($report->reportUsers) == 0)
                                                                        @php($j++)
                                                                        <tr>
                                                                            <td>{{ $j }}</td>
                                                                            <td>{{ $project->projects->name }}</td>
                                                                            <td class="text-right">{{ $project->time }}</td>
                                                                        </tr>
                                                                    @else
                                                                        @foreach($report->reportUsers as $user)
                                                                            @foreach($tasks as $task)
                                                                                @if($project->project_id == $task->project_id && $user->user_id == $task->user_id)
                                                                                    @php($j++)
                                                                                    <tr>
                                                                                        <td>{{ $j }}</td>
                                                                                        <td>{{ $project->projects->name }}</td>
                                                                                        <td class="text-right">{{ $project->time }}</td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="route"
           data-route-getProject="{{ route('invoice.admin.reports_get_project') }}"
           data-route-getUsers="{{ route('invoice.admin.reports_get_users') }}"
           data-route-getReport="{{ route('invoice.admin.reports_get_report') }}"
           data-route-updateReport="{{ route('invoice.admin.reports_update_report', ['id' => "#ID#"]) }}"
           data-route-createReport="{{ route('invoice.admin.reports_store') }}"
    >
@endsection

@section('scripts')
    <script>
        let day = {{ date('d') }};
        let month = {{ date('m') }};
        let year = {{ date('Y') }};
    </script>
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
    <script src="{{ asset('invoices/admin/js/report.js') }}"></script>
    <script>
        md.initFormExtendedDatetimepickers();
    </script>
@endsection