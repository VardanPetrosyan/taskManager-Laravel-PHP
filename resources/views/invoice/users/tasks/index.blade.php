@extends('invoice._layouts.user')
@section('page-title', 'Tasks')

@section('content')
    <div class="col" id="col">
        @include('invoice.users.includes.table', ['tasks' => $tasks, 'tableName' => 'Tasks Table'])
    </div>
    <input type="hidden" id="user_id" value="{{ \App\Helper\AuthHelper::user()->id }}">
@endsection
<input type="hidden" id="route_task" data-route-update="{{ route('invoice.users.project_update', ['id' => '#ID#']) }}">
<input type="hidden" id="route"
       data-route-selectProjectTasks="{{ route('invoice.users.tasks.select_project_tasks') }}"
       data-route-getTasks="{{ route('invoice.users.project_get_task') }}"
       data-route-projectUpdate="{{ route('invoice.users.project_update', ['id' => '#ID#']) }}"
       data-route-form="{{ route('invoice.users.project_create_task')}}"
       data-route-search="{{ route('invoice.users.tasks.search') }}"
>