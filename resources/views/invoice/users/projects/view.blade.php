@extends('invoice._layouts.user')
@section('page-title', 'Projects')

@section('styles')
    <style>
        /*@media (max-width: 1396px) {*/
        /*    .reverse {*/
        /*        flex-direction: column-reverse;*/
        /*    }*/
        /*}*/
        @media (max-width: 1200px) {
            .reverse {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
        <div class="col-xl-4 order-xl-2">
            <div class="card card-profile-image">
                <div class="card-avatar">
                    <a href="javascript:;">
                        <img class="img rounded-circle" src="{{ asset($project->logo) }}"
                             style="width: 120px; height: 120px;"/>
                    </a>
                </div>
                <div class="card-body mt-5">
                    <h3 class="mb-0 text-center">{{ $project->name }}</h3>
                    <h6 class="card-category text-gray">About</h6>
                    <h4 class="card-title mb-0">Owned by {{ $project->users->name }}</h4>
                    <p class="card-description">
                        Created on {{ date_format(new DateTime($project->created_at), 'M d, Y') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-8" id="col">
            @include('invoice.users.includes.table', ['tasks' => $tasks, 'tableName' => $project->name,'taskSetting'=>$tasksettings,'settings'=>$taskshelper,'users'=>$users])
        </div>
@endsection

<input type="hidden" id="proj_id" value="{{ $project->id }}">
<input type="hidden" id="route"
       data-route-selectProjectTasks="{{ route('invoice.users.tasks.select_project_tasks') }}"
       data-route-getTasks="{{ route('invoice.users.project_get_task') }}"
       data-route-projectUpdate="{{ route('invoice.users.project_update', ['id' => '#ID#']) }}"
       data-route-form="{{ route('invoice.users.project_create_task')}}"
       data-route-search="{{ route('invoice.users.tasks.search') }}"
>
@section('scripts')
    <script src="{{ asset('invoices/user/js/myScript.js') }}"></script>
@endsection