@extends('invoice._layouts.user')
@section('page-title', 'Dashboards')

@section('content')
    <div class="col" id="col">
        @include('invoice.users.includes.table', ['tasks' => $tasks, 'tableName' => 'Tasks Table','settings'=>$settings,'taskuser'=>$taskuser,'taskSetting'=>$taskSetting,'users'=>$users])
    </div>
@endsection
<input type="hidden" id="route_task" data-route-update="{{ route('invoice.users.project_update', ['id' => '#ID#']) }}">
<input type="hidden" id="route"
       data-route-selectProjectTasks="{{ route('invoice.users.tasks.select_project_tasks') }}"
       data-route-getTasks="{{ route('invoice.users.project_get_task') }}"
       data-route-projectUpdate="{{ route('invoice.users.project_update', ['id' => '#ID#']) }}"
       data-route-form="{{ route('invoice.users.project_create_task')}}"
       data-route-search="{{ route('invoice.users.tasks.search') }}"
>