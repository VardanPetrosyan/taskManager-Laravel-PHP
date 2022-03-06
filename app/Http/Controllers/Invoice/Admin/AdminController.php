<?php

namespace App\Http\Controllers\Invoice\Admin;

use App\Helper\CollectionHelper;
use App\Models\Invoice\Project;
use App\Models\Invoice\ProjectUser;
use App\Models\Invoice\Sidebar;
use App\Models\Invoice\Task;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Models\Invoice\TasksHelper;
use App\Models\Invoice\TaskUser;
use App\Models\Invoice\TaskSettings;

class AdminController extends Controller
{
    public function index(Request $request) {
        if(strpos($request->search, '#') !== false) {
            if ($request->project > 0) {
                $tasks = '';
                $search = explode('#', $request->search)[1];
                $users = User::where([
                    ['name', 'LIKE', '%' . $search . '%'],
                    ['invoice', 1]
                ])->get();
                $projectsUsers = ProjectUser::where('project_id', $request->project)->with('users')->get();

                foreach ($users as $i => $user) {
                    $flag = false;
                    foreach ($projectsUsers as $us) {

                        if ($user->id == $us->user_id) {
                            $flag = true;
                        }
                    }
                    if (!$flag) {
                        $users->forget($i);
                    }
                }

                if (count($users) > 0) {
                    $tasks = Task::where('user_id', $users[0]->id)->where('project_id', $request->project)->get();

                    $tasks = CollectionHelper::paginate($tasks, 10);
                }
            } else {
                $search = explode('#', $request->search)[1];
                $users = User::where([
                    ['name', 'LIKE', '%' . $search . '%'],
                    ['invoice', 1]
                ])->first();

                $tasks = Task::where('user_id', $users->id)->get();

                $tasks = CollectionHelper::paginate($tasks, 10);
            }
        } else {
            $projects = Project::where('id',$request->project)->pluck('id');
            $query = Task::where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%'. $request->search .'%')
                    ->orWhere('description', 'LIKE', '%'. $request->search .'%')
                    ->orWhere('task_number', 'LIKE', '%' . $request->search .'%');
            });
            if(isset($request->project)) {
                $query = $query->where('project_id', $projects);
            }
            $tasks = $query->orderByDesc('created_at')->with('users')->get();

            $tasks = CollectionHelper::paginate($tasks, 100000);

            $taks = new Collection();
            // if(count($tasks) == 0) {
            //     $projects = Project::where('name', 'LIKE', '%'.$request->search . '%')->get();

            //     foreach ($projects as $project) {
            //         $task = Task::where('project_id', $project->id)->orderByDesc('created_at')->get();

            //         $taks = $taks->merge($task);
            //     }

            //     $tasks = CollectionHelper::paginate($taks, 10000, $request->path);
            // }

        }
        $projects = Project::all();
        $taskuser = TaskUser::all();
        $settings = TasksHelper::all();
        $taskSetting = TaskSettings::all();
        $users = User::all();

        if ($request->ajax()) {
            return view('invoice.admin.includes.table', compact('tasks','settings','taskuser','taskSetting','users'))->render();
        }

        return view('invoice.admin.dashboard', compact('tasks', 'projects','settings','taskuser','taskSetting','users'));
    }

    public function searchProject(Request $request) {
        if(isset($request->search)) {
            if($request->id > 0) {
                if(strpos($request->search, '#') !== false) {
                    $search = explode('#', $request->search)[1];
                    $user = User::where('name', $search)->first();
                }
                if(is_null($user)) {
                    $tasks = Task::where('project_id', $request->id)
                        ->where(function ($query) use ($request) {
                            $query->where('title', 'LIKE', '%' . $request->search . '%')
                                ->orWhere('task_number', 'LIKE', '%' . $request->search . '%')
                                ->orWhere('description', 'LIKE', '%' . $request->search . '%');
                        })->with('users')->orderByDesc('created_at')->get();
                } else {
                    $tasks = Task::where('project_id', $request->id)
                        ->where('user_id', $user->id)
                        ->with('users')->orderByDesc('created_at')->get();
                }
            } else {
                if(strpos($request->search, '#') !== false) {
                    $search = explode('#', $request->search)[1];
                    $user = User::where('name', $search)->first();
                }
                if(is_null($user)) {
                    $tasks = Task::where('title', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('task_number', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                        ->with('users')->orderByDesc('created_at')->get();
                } else {
                    $tasks = Task::where('user_id', $user->id)->with('users')->orderByDesc('created_at')->get();
                }
            }
        } else {
            if($request->id > 0) {
                $tasks = Task::where('project_id', $request->id)
                    ->with('users')->orderByDesc('created_at')->get();
            } else {
                $tasks = Task::with('users')->orderByDesc('created_at')->get();
            }
        }
        $tasks = CollectionHelper::paginate($tasks, 10, $request->path);
        $html = view('invoice.admin.includes.table', compact('tasks'))->render();
        return response()->json($html);
    }

    public function searchUser(Request $request) {
        $users = '';
        $project = '';
        if ($request->project > 0) {
            $project = ProjectUser::where('project_id', $request->project)->with('users')->get();
        } else {
            $users = User::where('invoice', 1)->where('status', 'user')->get();
        }

        return response()->json(['users' => $users, 'projects' => $project]);
    }

    public function search(Request $request) {
        $users = '';
        if(strpos($request->search, '#') !== false) {
            if ($request->project > 0) {
                $search = explode('#', $request->search)[1];
                $users = User::where([
                    ['name', 'LIKE', '%' . $search . '%'],
                    ['invoice', 1],
                    ['status', 'user'],
                ])->get();
                $projects = ProjectUser::where('project_id', $request->project)->get();
                foreach ($projects as $project) {
                    foreach ($users as $j => $user) {
                        if($user->id != $project->user_id) {
                            $users->forget($j);
                        }
                    }
                }
            } else {
                $search = explode('#', $request->search)[1];
                $users = User::where([
                    ['name', 'LIKE', '%' . $search . '%'],
                    ['invoice', 1],
                    ['status', 'user'],
                ])->get();
            }

            return response()->json(['users' => $users, 'tasks' => '']);
        } else {
            $query = Task::where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%'. $request->search .'%')
                    ->orWhere('description', 'LIKE', '%'. $request->search .'%')
                    ->orWhere('task_number', 'LIKE', '%' . $request->search .'%');
            });
            if($request->project > 0) {
                $query->where('project_id', $request->project);
            }

            $tasks = $query->orderByDesc('created_at')->with('users', 'projects')->get();
            $tasks = CollectionHelper::paginate($tasks, 10, $request->path);
            $taks = new Collection();
            if(count($tasks) == 0) {
                $projects = Project::where('name', 'LIKE', '%'.$request->search . '%')->get();

                foreach ($projects as $project) {
                    $task = Task::where('project_id', $project->id)->orderByDesc('created_at')->get();

                    $taks = $taks->merge($task);
                }

                $tasks = CollectionHelper::paginate($taks, 10, $request->path);
            }

            $html = view('invoice.admin.includes.table', compact('tasks'))->render();

            return response()->json(['html' => $html, 'users' => '']);
        }
    }

    public function searchUserTask(Request $request) {
        $search = $request->name;
        $user = User::find($search);

        $tasks = Task::where('user_id', $user->id)->with('users')->orderByDesc('created_at')->get();

        $tasks = CollectionHelper::paginate($tasks, 10, $request->path);

        $html = view('invoice.admin.includes.table', compact('tasks'))->render();

        return response()->json($html);
    }

    public function settings() {

        return view('invoice.admin.settings');
    }

    public function checkPassword(Request $request) {
        $user = User::find($request->id);
        if(Hash::check($request->oldPass, $user->password)) {

            return response()->json(true);
        }

        return response()->json(false);
    }

    public function updatePassword(Request $request, $id) {
        $user = User::find($id);

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'You updated your password!');
    }

    public function sidebarUpdate(Request $request) {
        $sidebar = Sidebar::first();
        $color = $sidebar->filters;
        switch ($request->options) {
            case 'filters': {
                $sidebar->filters = $request->color;
                break;
            }
            case 'background': {
                $sidebar->background = $request->background;

                break;
            }
            case 'image': {
                $sidebar->image = $request->image;
                break;
            }
            case 'is_image': {
                $sidebar->is_image = $request->is_image;
                break;
            }
            case 'mini': {
                $sidebar->mini = $request->mini;
                break;
            }
        }
        $sidebar->save();

        return response()->json(['status' => true, 'message' => 'You updated Sidebar options!', 'color' => $color]);
    }
}
