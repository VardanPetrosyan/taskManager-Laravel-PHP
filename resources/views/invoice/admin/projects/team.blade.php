@extends('invoice._layouts.admin')
@section('page-name', 'Project Team')

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
       
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="scrolling-wrapper btn-groupe">
            <a href="{{ route('invoice.admin.project_edit', ['id' => $project->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0"><button class="card test btn"><p>Setting</p></button></a>
            <a href="{{ route('invoice.admin.project_team', ['id' => $project->id]) }}" rel="tooltip" class="dropdown-item btn btn-info btn-link pl-0"><button class="card test btn active" ><p>Team</p></button></a>
            <a href="{{ route('invoice.admin.project_fields', ['id' => $project->id]) }}" rel="tooltip" class="dropdown-item btn btn-success btn-link pl-0"><button class="card test btn "><p>Fields</p></button></a>        
        </div>
        <div class="row">
            <div class="col-md-12 addMemberUser">
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
                <div class="card-body">
                    <div class="tab-pane add_users active show" id="link1">
                        @foreach($projectUsers as $pro_us)
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