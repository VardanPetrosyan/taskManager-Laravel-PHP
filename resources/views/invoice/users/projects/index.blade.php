@extends('invoice._layouts.user')
@section('page-title', 'Projects')

@section('content')
    @forelse($projects as $project)
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('invoice.users.project_view', ['id' => $project->project_id]) }}"><span class="h2 font-weight-bold mb-0">{{ $project->projects->name }}</span></a>
                            <p class="mt-3 mb-3 text-sm">
                                @php($count = 0)
                                @foreach($project->projects->projectUsers as $i => $user)
                                    @if($i <= 5)
                                        @php($count = $i)
                                        @if($user->user_id != \App\Helper\AuthHelper::user()->id)
                                            <img class="avatar rounded-circle" src="{{ asset($user->users->img) }}" alt="" style="width: 30px; height: 30px" title="{{ $user->users->name }}">
                                        @endif
                                    @endif
                                @endforeach
                                <span style="font-size: 18px;font-weight: bold">+ {{ count($project->projects->projectUsers) - $count }}</span>
                            </p>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape text-white rounded-circle shadow" style="background-image: url({{ asset($project->projects->logo) }}); background-size: cover; background-position: center; width: 80px; height: 80px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-xl-12 col-md-12">
            <div class="card card-stats">
                <div class="card-body">
                    <h3>No project to show</h3>
                </div>
            </div>
        </div>
    @endforelse
@endsection
<input type="hidden" id="route"
       data-route-projectSearch="{{ route('invoice.users.projects_search') }}"
       data-route-projectView="{{ route('invoice.users.project_view', ['id' => '#ID#']) }}"
>
<input type="hidden" id="user_id" value="{{ \App\Helper\AuthHelper::user()->id }}">