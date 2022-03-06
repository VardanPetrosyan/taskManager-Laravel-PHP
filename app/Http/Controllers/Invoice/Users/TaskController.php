<?php

namespace App\Http\Controllers\Invoice\Users;

use App\Helper\AuthHelper;
use App\Helper\CollectionHelper;
use App\Models\Invoice\ProjectUser;
use App\Models\Invoice\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use function foo\func;
use App\Models\Invoice\TasksHelper;
use App\Models\Invoice\TaskUser;
use App\Models\Invoice\TaskSettings;
use App\Models\User;

class TaskController extends Controller
{
    public function index(Request $request) {
        $id = AuthHelper::user()->id;
        $tasks = Task::all();
        $projects = ProjectUser::where('user_id', $id)->with('projects')->get();
        if($request->projects) {
            Task::where('project_id', $request->projects);
        }
        
        $tasks = Task::orderByDesc('created_at')->with('projects')->paginate(10);
        // ------------------ Tasks Settings ----------------//
        $taskuser = TaskUser::all();
        $settings = TasksHelper::all();
        $taskSetting = TaskSettings::all();
        $users = User::all();
        // ------------------------------------------------------//
        if($request->ajax()) {
            return view('invoice.users.includes.table', compact('tasks','settings','taskuser','taskSetting','users'), ['tableName' => 'Tasks Table'])->render();
        }

        return view('invoice.users.tasks.index', compact('tasks', 'projects','settings','taskuser','taskSetting','users'));
    }
    // public function index(Request $request) {
    //     $task_id = [];
    //     $querys = [];
    //     $tasks = [];
    //     $id = AuthHelper::user()->id;
    //     $taskuser = TaskUser::where('user_id', $id)->with('tasks')->get();
    //     foreach($taskuser as $tasksetting){
    //         $tasks_where_me = Task::find($tasksetting->task_id);
    //         $task_id[]  = $tasks_where_me->id;
    //     }
    //     foreach($task_id as $id){
    //         $querys[] = Task::where('id', $id);
    //     }
    //     dd($querys);z
    //     $projects = ProjectUser::where('user_id', $id)->with('projects')->get();
    //     foreach($querys as $query){
    //     if($request->projects) {
    //         $query->where('project_id', $request->projects);
    //     }
    //     $tasks_creat_by_me = $query->orderByDesc('created_at')->with('projects')->paginate(10);
    //     $tasks= $tasks_creat_by_me;
    //     }
    //     $settings = TasksHelper::all();
    //     $taskSetting = TaskSettings::where('task_id', $id)->with('tasks')->get();
    //     if($request->ajax()) {
    //         return view('invoice.users.includes.table', compact('tasks'), ['tableName' => 'Tasks Table'])->render();
    //     }

    //     return view('invoice.users.tasks.index', compact('tasks', 'projects'));
    // }

    public function selectProjectTasks(Request $request) {
        if ($request->project_id != 0) {
            $query = Task::where('project_id', $request->project_id);
            if(strpos($request->path, 'home') !== false) {
                if(isset($request->search)) {
                    $query->where(function($q) use ($request) {
                        $q->where('task_number', 'LIKE', '%'. $request->search .'%')
                            ->orWhere('title', 'LIKE', '%'. $request->search .'%')
                            ->orWhere('description', 'LIKE', '%'. $request->search .'%');
                    });
                }
            } else {
                $query->where('user_id', $request->user_id);
            }

            $tasks = $query->orderByDesc('created_at')->get();
        } else {
            if($request->tasks == "true") {
                if(isset($request->search)) {
                    $tasks = Task::where('user_id', $request->user_id)->where(function ($q) use ($request) {
                        $q->where('task_number', 'LIKE', '%'. $request->search .'%')
                            ->orWhere('title', 'LIKE', '%'. $request->search .'%')
                            ->orWhere('description', 'LIKE', '%'. $request->search .'%');
                    })->orderByDesc('created_at')->get();
                } else {
                    $tasks = Task::where('user_id', $request->user_id)->orderByDesc('created_at')->get();
                }
            } else {
                $projectUser = ProjectUser::where('user_id', $request->user_id)->get();

                $tasks = new Collection();
                foreach ($projectUser as $value) {
                    if(isset($request->search)) {
                        $task = Task::where('project_id', $value->project_id)->where(function ($q) use ($request) {
                            $q->where('task_number', 'LIKE', '%'. $request->search .'%')
                                ->orWhere('title', 'LIKE', '%'. $request->search .'%')
                                ->orWhere('description', 'LIKE', '%'. $request->search .'%');
                        })->orderByDesc('created_at')->get();
                    } else {
                        $task = Task::where('project_id', $value->project_id)->orderByDesc('created_at')->get();
                    }

                    $tasks = $tasks->merge($task);
                }
            }
        }
        $tasks = CollectionHelper::paginate($tasks, 10, $request->path);
        $html = view('invoice.users.includes.table', compact('tasks'), [
            'tableName' => 'Tasks Table'
        ])->render();

        return response()->json(['status' => true, 'html' => $html]);
    }

    public function search(Request $request) {
        if(isset($request->user_id)) {
            $query = Task::where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('task_number', 'LIKE', '%' . $request->search . '%');
            });
            // ->where('user_id', $request->user_id);
            $projects = ProjectUser::where('user_id', AuthHelper::user()->id)->pluck('project_id');


        } else {
            $projects = ProjectUser::where('user_id', AuthHelper::user()->id)->pluck('project_id');
            $query = Task::where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('task_number', 'LIKE', '%' . $request->search . '%');
            })->whereIn('project_id', $projects);
        }
        if($request->project_id != 0) {
            $query->where('project_id', $request->project_id);
        }

        $tasks = $query->orderByDesc('created_at')->get();

        $tasks = CollectionHelper::paginate($tasks, 10, $request->path);
        $taskuser = TaskUser::all();
        $settings = TasksHelper::all();
        $taskSetting = TaskSettings::all();
        $users = User::all();
        $html = view('invoice.users.includes.table', compact('tasks','settings','taskuser','taskSetting','users','projects'), ['tableName' => 'Tasks Table'])
        ->render();
        return response()->json($html);
    }
}
