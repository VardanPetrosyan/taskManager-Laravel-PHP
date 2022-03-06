@extends('invoice._layouts.admin')
@section('page-name', 'Edit Task')

@section('content')
    @if($message = Session::get('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="material-icons">close</i>
            </button>
            <span>{{ $message }}</span>
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header card-header-icon card-header-{{ $sidebar->filters }}">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Edit Task
                        </h4>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('invoice.admin.project_update_task', ['id' => $task->id]) }}" method="POST"  id="editForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-sm-6 text-center">
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ asset($task->users->img) }}"
                                                 alt="...">
                                        </div>
                                        <div>
                                            <h4>{{ $task->users->name }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating" for="task_number">Task Number*</label>
                                            <input type="text" name="task_number" class="form-control"
                                                   id="task_number" value="{{ $task->task_number }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating" for="title">Title*</label>
                                            <input type="text" name="title" class="form-control"
                                                   id="title" value="{{ $task->title }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating" for="description">Description*</label>
                                            <textarea name="description" id="description" class="form-control" rows="3" required>{{ $task->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating" for="date">Date*</label>
                                            <input type="text" name="date" class="form-control datepicker"
                                                   id="date" value="{{ date_format(new DateTime($task->date), 'd/m/Y') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="bmd-label-floating" for="time">Time*</label>
                                            <input type="text" name="time" class="form-control"
                                                   id="time" value="{{ $task->time }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-{{ $sidebar->filters }} pull-right">Update Task</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('invoices/admin/js/myScript.js') }}"></script>
    <script>
        md.initFormExtendedDatetimepickers();
    </script>
@endsection