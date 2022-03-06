<?php

namespace App\Http\Controllers\Invoice\Admin;

use App\Helper\AuthHelper;
use App\Helper\CollectionHelper;
use App\Models\Invoice\Project;
use App\Models\Invoice\ProjectUser;
use App\Models\Invoice\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice\TasksHelper;
use App\Models\Invoice\TaskUser;
use App\Models\Invoice\TaskSettings;
use App\Models\Invoice\ProjectField;
use App\Events\StatusEdit;

class TaskController extends Controller
{
    public function index(Request $request) {
        // $text = $request->text;
        // event(new StatusEdit($text));
        if(isset($request->search)) {
            $search = "$request->search";
            $index = strpos($search, '#');
            if(isset($request->project)){
                $projects = Project::where('id',$request->project)->pluck('id');
                $tasks = Task::where(function ($q) use ($request) {
                    $q->where('title', 'LIKE', '%'.$request->search.'%')
                        ->orWhere('description', 'LIKE', '%'.$request->search.'%')
                        ->orWhere('task_number', 'LIKE', '%'.$request->search.'%');
                })->whereIn('project_id', $projects)->orderByDesc('created_at')->get();
            }else if($index === false) {
                $tasks = Task::where('task_number', 'LIKE', '%'.$search.'%')->orWhere('description', 'LIKE', '%'.$search.'%')->orderByDesc('created_at')->get();
            }else {
                $search = explode('#', $search)[1];
                $users = User::where('name', "LIKE", '%'. $search .'%')->where('invoice', 1)->first();
                $tasks = Task::where('user_id', $users->id)->orderByDesc('created_at')->get();
            }
           
        } else if(isset($request->project)){
                $proj = $request->project;
                $tasks = Task::where('project_id', $proj)->orderByDesc('created_at')->get();
        } else {
            $tasks = Task::orderByDesc('created_at')->get();
        }
        $projects = Project::all();

        $tasks = CollectionHelper::paginate($tasks, 100000);
        $taskuser = TaskUser::all();
        $settings = TasksHelper::all();
        $taskSetting = TaskSettings::all();
        $users = User::all();
        if($request->ajax()) {
            return view('invoice.admin.includes.table', compact('tasks','settings','taskuser','taskSetting','users'))->render();
        }

        return view('invoice.admin.tasks.index', compact('projects','tasks','settings','taskuser','taskSetting','users'));
    }

    public function taskShow($id) {
        $task = Task::find($id);
        $ProjectFields = ProjectField::where('project_id',$task->projects->id)->get();
        
            $settings = [];
            foreach($ProjectFields as $projfield){
                $settings[] = $projfield->settings;
            }
        $projects = Project::all();
        // $settings  = TasksHelper::all();
        $taskuser  = TaskUser::where('task_id',$id)->get();
        $taskSetting = TaskSettings::all();
        $users = User::all();
        

        return view('invoice.admin.tasks.show', compact('task', 'projects','settings','users','taskuser','taskSetting'));
    }
   
    public function taskUpdate($id, Request $request) {
       
        $user = AuthHelper::user()->id;
        $task = Task::find($id);
        if(isset($request->title)){
            $date = explode('/',$request->date)[2] . '-' .explode('/',$request->date)[1] . '-' . explode('/',$request->date)[0];

            $task->title = $request->title;
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
                        "userID"=>NULL,
                        "data"=>$tasksettings,
                        ));
                    event(new StatusEdit($send));
                }  
            }

        }
        if(isset($request->title)){
        return redirect()->route('invoice.admin.task')->with('success', 'Task updated successfully!');
        }else{
        return response('success');
        }
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
    public function selectProject(Request $request) {
        if($request->projects == 'false') {
            $projUs = ProjectUser::where('project_id', $request->id)->where('user_id', $request->user_id)->first();

            if (!is_null($projUs)) {
                $task = Task::find($request->task_id);

                $task->project_id = $request->id;
                $task->save();

                return response()->json(['status' => true]);
            } else {
                $task = Task::find($request->task_id);
                return response()->json(['status' => false, 'projects' => $task->projects]);
            }
        } else {
            $projUs = new ProjectUser();

            $projUs->project_id = $request->id;
            $projUs->user_id = $request->user_id;

            $projUs->save();

            $task = Task::find($request->task_id);

            $task->project_id = $request->id;
            $task->save();

            return response()->json(['status' => true]);
        }
    }

    public function create(Request $request) {

        if(isset($request->post)){
            $projfields = ProjectField::where('project_id',$request->id)->get();
            $projectUsers = ProjectUser::where('project_id',$request->id)->get();
            $setting = [];
            $Users=[];
            foreach($projfields as $projfield){
                $setting[] = $projfield->settings;
            }
            foreach($projectUsers as $projectUser){
                $Users[] = $projectUser->users;
            }
            return response()->json(['setting'=>$setting,'projfields'=>$projfields, 'Users'=> $Users]);
        }
        $projfields = ProjectField::all();
        $settings  = TasksHelper::all();
        $users =  User::all();
        $url = explode('?project=', url()->previous());
        $projects = Project::all();
        if(isset($url[1])) {
            $proj_id = $url[1];
        } else {
            $proj_id = 0;
        }
        return view('invoice.admin.tasks.create', compact('projects', 'proj_id','settings','users','projfields'));
    }

    public function store(Request $request) {
        $user = AuthHelper::user()->id;
        $task = new Task();
        $date = explode('/',$request->date)[2] . '-' .explode('/',$request->date)[1] . '-' . explode('/',$request->date)[0];

        $task->project_id = $request->project_id;
        $task->user_id = $user;
        $task->task_number = $request->task_number;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->time = $request->time;
        $task->date = $date;
        
        $task->save();

       
        if($request->users){
            $taskus = new TaskUser();

            foreach($request->users as $user){
                $taskus->task_id = $task->id;
                $taskus->user_id = $user;
                
                $taskus->save(); 
                };
        }

        
        if($request->setting){
            $setting = $request->setting;
            foreach($setting as $key => $value){
                $tasksettings = new TaskSettings();
                $taskhelper = TasksHelper::find($key);
                
                $tasksettings->task_id = $task->id;
                $tasksettings->user_id = $user;
                    $tasksettings->setting_id = $taskhelper->id;
                    foreach(json_decode($taskhelper->properties)as $item){
                        if($item->id == $value){
                            $tasksettings->setting = json_encode($item);
                        }
                    }  
                $tasksettings->save(); 
            }
        }
        

        
        return redirect()->route('invoice.admin.task', ['project' => $request->project_id])->with('success', 'Task created successfully!');

    }
    public function addProjectUser(Request $request) {
        $project_user = new TaskUser();
        $project_user->project_id = $request->task_id;
        $project_user->user_id = $request->user_id;

        $project_user->save();

        $user = User::find($request->user_id);

        return response()->json(['user' => $user]);
    }
}
