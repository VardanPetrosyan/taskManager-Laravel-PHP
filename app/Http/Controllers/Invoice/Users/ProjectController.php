<?php

namespace App\Http\Controllers\Invoice\Users;

use App\Helper\AuthHelper;
use App\Models\Invoice\Project;
use App\Models\Invoice\ProjectUser;
use App\Models\Invoice\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice\TasksHelper;
use App\Models\Invoice\TaskUser;
use App\Models\Invoice\TaskSettings;
use App\Models\User;
use App\Events\StatusEdit;



class ProjectController extends Controller
{
    public function index() {
        $projects = ProjectUser::where('user_id', AuthHelper::user()->id)->with('projects', 'users')->get();
        return view('invoice.users.projects.index', compact('projects'));
    }

    public function view($id, Request $request) {
        $project = Project::find($id);
        $projectUsers = ProjectUser::where('project_id', $project->id)->get();
        $tasksettings = TaskSettings::all();
        $taskshelper = TasksHelper::all();
        $users = User::all();
        $flag = false;
        foreach ($projectUsers as $us) {
            if($us->user_id == AuthHelper::user()->id) {
                $flag = true;
            }
        }

        if($flag) {
            $tasks = Task::where('project_id', $id)->orderByDesc('created_at')->paginate(10);

            if ($request->ajax()) {
                return view('invoice.users.includes.table', [
                    'tasks' => $tasks,
                    'tableName' => $project->name
                ])->render();
            }

            return view('invoice.users.projects.view', compact('project', 'tasks','tasksettings','taskshelper','users'));
        } else {
            return redirect()->route('errors');
        }
    }

    public function create(Request $request) {
        $task = new Task();
        $date = explode('/', $request->date)[2] . '-' . explode('/', $request->date)[1] . '-' . explode('/', $request->date)[0];

        $task->project_id = $request->project_id;
        $task->user_id = $request->user_id;
        $task->task_number = $request->task_number;
        $task->title = $request->task_title;
        $task->description = $request->description;
        $task->date = $date;
        $task->time = $request->time;

        $task->save();

        return back()->with('success', 'Task created successfully!');

    }

    public function errors() {
        return view('invoice.errors.404');
    }

    public function getTask(Request $request) {
        $task = Task::find($request->id);

        return response()->json($task);
    }

    public function update($id, Request $request) {
        $user = AuthHelper::user()->id;
        $task = Task::find($id);
        if(isset($request->task_title)){
        $date = explode('/', $request->date)[2] . '-' . explode('/', $request->date)[1] . '-' . explode('/', $request->date)[0];
        $task->task_number = $request->task_number;
        $task->title = $request->task_title;
        $task->description = $request->description;
        $task->date = $date;
        $task->time = $request->time;
        $task->save();
        }
        if(isset($request->add_user)){
            $taskus = new TaskUser();
            $taskus->task_id = $task->id;
            $taskus->user_id = $request->add_user;
            $taskus->save();  
        }elseif(isset($request->remove_user)){
            $taskus =  TaskUser::where('task_id', $task->id)->where('user_id', $request->remove_user)->get();
            foreach($taskus as $tasku){
                $tasku->delete();
            };
        }

        if(isset($request->setting)){

            $setting = $request->setting;  
    
            $tasksetting = TaskSettings::where('task_id' , '=', $task->id)->get();
                foreach($setting as $key => $value){
                    $taskhelper = TasksHelper::find($key);
                    if(!empty($tasksetting)){
                        foreach($tasksetting as $deleteitems){
                            if($taskhelper->id == $deleteitems->setting_id){
                                $deleteitems->delete();
                            }
                        }
                    }
                    if($value !== 'empty'){
                        $tasksettings = new TaskSettings();
    
                        $tasksettings->task_id = $task->id;
                        $tasksettings->user_id = $user;
                        $tasksettings->setting_id = $taskhelper->id;
                            foreach(json_decode($taskhelper->properties)as $item){
                                if($item->id == $value){
                                    $tasksettings->setting = json_encode($item);
                                }
                            }  
                        $tasksettings->save(); 
                        $send = json_encode(array(
                            "update" => 'status',
                            "userID"=> NULL,
                            "data"=> $tasksettings,
                            ));
                        event(new StatusEdit($send));
                    }  
                }
    
            }
        if(isset($request->task_title)){
        return back()->with('success', 'Task updated successfully!');
        }else{
            return response('success');
        }
    }

    public function deleteTask($id) {
        Task::destroy($id);

        return back()->with('success', 'You deleted your tasks!');
    }
    public function taskRemove(Request $request) {
        if(isset($request->id)){
            foreach($request->id as $id){
                $task = Task::find($id);

                $taskusers = TaskUser::where('task_id',$task->id)->get();
                if(isset($taskusers)){
                    foreach($taskusers as $taskuser){
                        $taskuser->delete();
                    }
                } 
                
                $tasksettings = TaskSettings::where('task_id',$task->id)->get();
                if(isset($tasksettings)){
                foreach($tasksettings as $tasksetting){
                    $tasksetting->delete();
                }
                }

                $task->delete();    

            }
            return response()->json(true);

        }
        return response()->json(false);


    }

    public function searchProject(Request $request) {
        $projects = ProjectUser::where('user_id', $request->user_id)->with('projects', 'users')->get();

        if(!is_null($request->search)) {
            foreach ($projects as $i => $project) {
                if (strpos(strtolower($project->projects->name), strtolower($request->search)) === false) {
                    $projects->forget($i);
                }
            }
        }

        return response()->json($projects);
    }
}
