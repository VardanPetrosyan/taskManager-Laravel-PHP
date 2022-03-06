@extends('invoice._layouts.admin')
@section('page-name', 'All Tasks')

@section('styles')
    <link rel="stylesheet" href="{{ asset('invoices/admin/css/tasks.css') }}">
    <style>
        .filter-option {
            padding-left: 15px!important;
            padding-top: inherit!important;
            padding-right: 10px!important;
        }
        .bootstrap-select > .dropdown-toggle {
            padding-right: 15px;
        }
        .colorbox{
            text-align: center;
            border: 1px solid;
            margin: 4% 2%;
            color: white;
            font-size: larger;
            font-weight: 500;
            padding: 0;
            width: 24px;
            height: 24px;
        }
        .imgbox{
            border-radius: 5px;
            width: auto;
            height: 25px;
            text-align: center;
            border: 1px solid;
            margin: 9% 2%;
            color: white;
            font-size: larger;
            font-weight: 500;
            padding: 11px;
            transition: all 1s ease 0s;
        }
        .imgbox>p{
            position: absolute;
            top: 0px;
            left: 6px;
        }
        .settingname{
            align-self: center;
        }
        .settingitem,.useritem{
            cursor: pointer;
        }
        .btn-style{
            contain: content;
            margin: 4px 0px 1px;
            height: 21px;
            background-color: rgba(0, 0, 0, 0);
            padding: 0px;
            transition: all 1s ease 0s;
            font-size: 13px;
            font-weight: 300;
            font-family: none;
        }
        #dropbox{
            padding: 18px 0px;
            overflow: hidden auto;
            max-height: 237px!important;
        }
        .btn.btn-secondary:hover {
            background-color: #d7dede;;
            }
        .form-group{
            padding: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                <select class="selectpicker" id="everythingBtn" data-size="4" data-style="btn btn-primary btn-round everythingBtn" >
                    <option value="0">Select Projects</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" @if(request()->request->get('project') == $project->id) selected @endif>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
           
            <div class="col-lg-9 col-md-9 col-sm-9 col-9 col-search">
                <div class="input-group no-border searchBox">
                    <input type="text" id="searchdash" name="search" class="form-control" placeholder="Search..." autocomplete="off"  value="{{ isset(request()->search) ? request()->search : '' }}">
                    <button type="button" class="btn btn-white btn-round btn-just-icon searchBtn">
                        <i class="material-icons">search</i>
                        <div class="ripple-container"></div>
                    </button>
                    <div class="help">
                        <ul class="nav">
                            <li class="search-item link-color">users: <span>#</span></li>
                        </ul>
                    </div>
                    <div class="search-res">
                        <ul class="nav">
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-1 col-btn">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('invoice.admin.task_create') }}" class="btn btn-{{ $sidebar->filters }} mediaBtn">New Tasks</a>
                    <a href="{{ route('invoice.admin.task_create') }}" class="btn btn-just-icon btn-round btn-{{ $sidebar->filters }} mt-0 mediaBtnCircle"><i class="material-icons">add</i></a>
                </div>
            </div>
        </div>
        <div class="row" id="col">
            @include('invoice.admin.includes.table', ['tasks' => $tasks,'settings'=>$settings,'taskuser'=>$taskuser,'users'=>$users])
        </div>
    </div>

    <input type="hidden" id="route"
           data-route-search="{{ route('invoice.admin.search') }}"
           data-route-project="{{ route('invoice.admin.search_project') }}"
           data-users-edit="{{ route('invoice.admin.users_edit', ['id' => "#ID#"]) }}"
           data-route-searchUser="{{ route('invoice.admin.search_user') }}"
           data-route-searchUserTask="{{ route('invoice.admin.search_user_task') }}"
           data-task-show="{{ route('invoice.admin.task_show', ['task' => '#ID#']) }}"
    >
@endsection

@section('scripts')
    <script>
        let d = "{{ date('d') }}"
    </script>
    <script src="{{ asset('invoices/admin/js/search.js') }}"></script>
@endsection