<?php

namespace App\Http\Controllers\Invoice;

use App\Helper\AuthHelper;
use App\Helper\CollectionHelper;
use App\Models\Invoice\ProjectUser;
use App\Models\Invoice\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Invoice\TasksHelper;
use App\Models\Invoice\TaskUser;
use App\Models\Invoice\TaskSettings;


class HomeController extends Controller
{
    public function index() {
        return redirect()->route('invoice.login');
    }

    public function login() {
        return view('invoice.login');
    }

    public function auth(Request $request) {
        $user = User::where('email', $request->email)->first();
        if (!is_null($user)) {
            if(Hash::check($request->password, $user->password)) {
                if($user->status == 'admin') {
                    AuthHelper::login($user);
                    return redirect()->route('invoice.admin.dashboard');
                } else {
                    AuthHelper::login($user);
                    return redirect()->route('invoice.home');
                }
            } else {
                return redirect()->route('invoice.login');
            }
        }
    }

    public function logout() {
        AuthHelper::logout();
        return redirect()->route('invoice.login');
    }

    public function home(Request $request) {
        $id = AuthHelper::user()->id;
        $projects = ProjectUser::where('user_id', $id)->with('projects')->get();

        if($request->search && !$request->projects) {
            $tasks = Task::where('title', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('task_number', 'LIKE', '%'. $request->search . '%')->orderByDesc('created_at')->paginate(10);
        } else if ($request->projects && !$request->search) {
            $tasks = Task::where('project_id', $request->projects)->orderByDesc('created_at')->paginate(10);
        }else if($request->search && $request->projects) {
            $tasks = Task::where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('task_number', 'LIKE', '%'. $request->search . '%');
            })->where('project_id', $request->projects)
            ->orderByDesc('created_at')->paginate(10);
        } else {
            $tasks = new Collection();
            foreach ($projects as $project) {
                $task = Task::where('project_id', $project->project_id)->orderByDesc('created_at')->get();
                $tasks = $tasks->merge($task);
            }

            $tasks = CollectionHelper::paginate($tasks, 10);
        }
        $taskuser = TaskUser::all();
        $settings = TasksHelper::all();
        $taskSetting = TaskSettings::all();
        $users = User::all();

        if($request->ajax()) {
            return view('invoice.users.includes.table', compact('tasks','settings','taskuser','taskSetting','users'), ['tableName' => 'Task Table'])->render();
        }
        return view('invoice.users.index', compact('projects', 'tasks','settings','taskuser','taskSetting','users'));
    }

    public function register(Request $request) {
       
        if(isset($request->code)) {
            $user = User::where('code',$request->code)->first();

            if($user->is_verify == 0) {
                return view('invoice.admin.users.register', compact('user'));
            } else {
                return redirect()->route('invoice.login');
            }
        }
        return redirect()->route('invoice.index');
    }
  
    public function regUser(Request $request) {
        $user = User::where('email', $request->email)->first();
        $validatedData = $request->validate([
            "name" => ['required', 'regex:/^\S*$/u','min:4', 'max:255'],
            "password" => ['required', 'regex:/^\S*$/u','min:4', 'max:255'],
        ]);
        $user->name = $request->name;
        $user->img = 'invoices/images/default-user.jpg';
        $user->email = $request->email;
        $user->password = Hash::make(trim($request->password));
        $user->invoice = 1;
        $user->is_verify = 1;

        $user->save();

        AuthHelper::login($user);

        return redirect()->route('invoice.index');
    }

    public function checkUser(Request $request) {
        if(is_null($request->email)) {
            return response()->json(['type' => false, 'mess' => 'Please fill in the fields']);
        } else {
            $user = User::where('email', $request->email)->first();
            if(is_null($user)) {
                return response()->json(['type' => false, 'mess' => 'No user with such an email']);
            } else {
                if (Hash::check($request->pass, $user->password)) {
                    return response()->json(['type' => true]);
                } else {
                    return response()->json(['type' => false, 'mess' => 'Email or Password incorrect']);
                }
            }
        }
    }
}
