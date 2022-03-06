<?php

namespace App\Http\Controllers\Invoice\Admin;

use App\Helper\AuthHelper;
use App\Models\Invoice\Project;
use App\Models\Invoice\ProjectUser;
use App\Models\Invoice\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Invoice\TaskUser;
use App\Models\Invoice\TasksHelper;
use App\Models\Invoice\ProjectField;
use Illuminate\Validation\Rule;
use Validator;


class ProjectController extends Controller
{
    public function index() {
        $projects = Project::orderByDesc('created_at')->paginate(10);

        return view('invoice.admin.projects.index', compact('projects'));
    }

    public function create() {
        return view('invoice.admin.projects.create');
    }

    public function store(Request $request) {
        $project = new Project();
        $project->name = $request->name;
        $project->create_in = AuthHelper::user()->id;
        $project->description = $request->description;
        $project->abbreviation = $request->abbreviation;
        $project->start_abbreviation_number = $request->start_abbreviation_number;
        $name = '';
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $name = uniqid(). '.' . $image->getClientOriginalExtension();
            $image->move(public_path('invoices/admin/img/projects/'), $name);
        }
        $project->logo = 'invoices/admin/img/projects/' . $name;
        $project->save();
        //-------------------New Project Fields---------------------
        $TasksHelper = TasksHelper::where('Default', '1')->get();
        if(isset($TasksHelper)){
            foreach($TasksHelper as $setting){
                $ProjectField = new ProjectField();
                $ProjectField ->project_id = $project->id;
                $ProjectField->setting_id = $setting ->id;
                if($setting->properties !== '[]'){
                    $ProjectField->Default = json_encode(json_decode($setting->properties)[0]);
                }else{
                    $ProjectField->Default = NULL;
                }
                $ProjectField->EmptyOrNot = '1';
                $ProjectField->save();
            }
        }
        //----------------------------------------------------------

        $projus = new ProjectUser();
        $projus->project_id = $project->id;
        $projus->user_id = AuthHelper::user()->id;

        $projus->save();

        return redirect()->route('invoice.admin.project')->with('success', 'Project created successfully!');
    }
    public function items($id, Request $request) {
            $project = Project::find($id);
            $TasksHelper = TasksHelper::all();
            $ProjectFields = ProjectField::all();
            if($request->make == 'creat'){
            $view = view('invoice.admin.projects.Layouts._fields', compact('project','TasksHelper','ProjectFields'))->render();
                return response()->json(array('success' => true, 'html'=>$view));
            }else if($request->make == 'use'){
            $view = view('invoice.admin.projects.Layouts.UseExisting_fields', compact('project','TasksHelper','ProjectFields'))->render();
                return response()->json(array('success' => true, 'html'=>$view));
            }else if($request->make == 'edit'){
                $thisProjectField = ProjectField::find($request->projectFieldId);
                $NewEditItem = $request->NewEditItem;
                $view = view('invoice.admin.projects.Layouts.edit_fieldl_layout', compact('project','TasksHelper','ProjectFields','thisProjectField','NewEditItem'))->render();
                return response()->json(array('success' => true, 'html'=>$view));
            }

        
    }
    public function CreatFields($id, Request $request) {
        if($request->make == 'creat'){
            $validator = Validator::make($request->all(), [
                "FiledName" => ['required',Rule::unique('tasks_helper','name')],
            ]);
            if($validator->fails()){
                return response()->json(['error'=>$validator->errors()->all()]);
            }
            $project = Project::find($id);
            if(!empty($request->FiledName)){
                $arr = Input::all();
                $field = new TasksHelper;
                $field ->name = $request->FiledName;
                if(isset($request->FiledId)){
                    $settings = TasksHelper::find($request->FiledId);
                    
                    $field ->properties = $settings->properties;
                }else{
                    
                    $field ->properties = json_encode([]);
                }
                $field ->Default = 0;
                $field -> save();
    
                $ProjectField = new ProjectField;
                $ProjectField ->project_id = $id;
                $ProjectField ->setting_id = $field->id;
                
                    if(isset($request->FiledSettingId)){
                    foreach(json_decode($settings->properties) as $prop){
                            if($request->FiledSettingId == $prop->id){
                                $ProjectField ->Default = json_encode($prop);
                        }
                    }
                    }else{
                        if(!empty(json_decode($field->properties))){
                            $ProjectField ->Default =  json_encode(json_decode($field->properties)[0]);
                        }else{
                            $ProjectField ->Default =  NULL;
    
                        }
                    }
    
    
                    if(isset($request->checkEmpty)){
                        if($request->InputOfEmpty == NULL){
                            $ProjectField->EmptyOrNot = '0';
        
                        }else{
                            $ProjectField->EmptyOrNot = '0';
                            $ProjectField->EmptyValue = "$request->InputOfEmpty";
                        }
                    }else{
        
                        $ProjectField->EmptyOrNot = '1';
                    };
        
                    $ProjectField->save();
            }
        }else if($request->make == 'use'){

            $field = TasksHelper::find($request->useFieldId);

            $ProjectField = new ProjectField;
            $ProjectField ->project_id = $id;
            $ProjectField ->setting_id = $field->id;
            $ProjectField ->Default =  NULL;
            $ProjectField ->EmptyOrNot = '0';
            $ProjectField->save();
        }
        return response()->json(['field'=>$field,'ProjectField'=>$ProjectField]);

    }
    public function UpdateFields($id, Request $request) {
        $whateupdate = '';
        $value =  "$request->value";

        $update = $request->update;
        $ProjectField = ProjectField::find($request->fieldId);

        if($request->update == 'EmptyOrNot'){
            $whateupdate = 'EmptyOrNot';
            $ProjectField -> $update = $value;
        }else if($request->update == 'Default'){
           $whateupdate = 'Default';

           if($value == 0){
                $ProjectField -> $update =  NULL;

           }else{
                $values =  json_decode($ProjectField->settings->properties);
                foreach($values as $val){
                    if($val->id == $value){
                        $ProjectField -> $update =  json_encode($val);
                    }
                }

           }
        }
        $ProjectField -> save();
        $project = $ProjectField->projects;
        return response()->json(['ProjectField'=>$ProjectField,'project'=>$project,'whateupdate'=>$whateupdate]);



    }
    public function fields($id, Request $request) {
        $project = Project::find($id);
        $TasksHelper = TasksHelper::all();
        $ProjectFields = ProjectField::all();
        return view('invoice.admin.projects.fields', compact('project','TasksHelper','ProjectFields'));
    }
    public function Searchfield(Request $request) {
        $fields = TasksHelper::find($request->id);

        if($request ->creat == 'false'){
            $send = ['field'=>$fields,'work'=>'search'];
            return response()->json($send);
        }else if($request ->creat == 'true'){
            $properties = $fields->properties;
            $setting = TasksHelper::find($request->SettingId);
            $ProjectFields = ProjectField::find($request->ProjectFieldId);
            $setting ->properties = $properties;

            if($setting->Default == 1){
                $newfield  = new TasksHelper();
                $newfield->name = $setting->name;
                $newfield->properties = $setting->properties;
                $newfield->Default = '0';
    
                $newfield->save();
                $ProjectFields ->setting_id = $newfield->id;
                $setting = $newfield;
    
            }else{
                $setting->save();
            }

            $ProjectFields->Default = NULL;

            $ProjectFields->save();

            $send = ['field'=>$setting,'work'=>'update','ProjectField'=>$ProjectFields];
            return response()->json($send);
        }else{
            return response()->json('error');
        }
    }
    public function edit($id) {
        $project = Project::find($id);

        return view('invoice.admin.projects.edit', compact('project'));
    }

    public function update($id, Request $request) {
        $project = Project::find($id);
        $project->name = $request->name;

        $project->description = $request->description;
        $project->abbreviation = $request->abbreviation;
        $project->start_abbreviation_number = $request->start_abbreviation_number;

        $name = $request->old_logo;
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $name = uniqid(). '.' . $image->getClientOriginalExtension();
            $image->move(public_path('invoices/admin/img/projects/'), $name);
        }

        $project->logo = 'invoices/admin/img/projects/' .$name;

        $project->save();

        return redirect()->route('invoice.admin.project')->with('success', 'Project updated successfully!');
    }

    public function show($id) {
        $project = Project::find($id);
        $projectUser = ProjectUser::where('project_id', $id)->get();
        $tasks = Task::where('project_id', $id)->orderByDesc('created_at')->paginate(10);

        return view('invoice.admin.projects.show', compact('project', 'projectUser', 'tasks'));
    }

    public function delete($id) {
        $prod = ProjectUser::where('project_id', $id)->get();
        $tasks = Task::where('project_id', $id)->get();
        $projectFields = ProjectField::where('project_id', $id)->get();
        foreach ($prod as $p) {
            $p->delete();
        }
        foreach($tasks as $task){
            $task->delete();
            foreach($task->settings as $setting){
                $setting->delete();
            }
        }
        foreach($projectFields as $projectField){
            $projectField ->delete();
        }
        Project::destroy($id);

        return back()->with('success', 'Project deleted successfully!');
    }

    public function checkUser(Request $request) {
        $users = User::where([
            ['invoice', 1],
            ['name', 'LIKE', '%'. $request->name . '%'],
        ])->get();
        $project_users = ProjectUser::where('project_id', $request->project_id)->get();

        foreach ($users as $i => $user) {
            foreach ($project_users as $pro_us) {
                if($pro_us->user_id == $user->id) {
                    $users->forget($i);
                }
            }
        }

        return response()->json(['users' => $users]);
    }

    public function addProjectUser(Request $request) {
        $project_user = new ProjectUser();
        $project_user->project_id = $request->project_id;
        $project_user->user_id = $request->user_id;

        $project_user->save();

        $user = User::find($request->user_id);
        
        return response()->json(['user' => $user]);
    }

    public function removeProjectUser(Request $request) {
        $project_users = ProjectUser::all();
        for($i = 0; $i < count($request->id); $i++) {
            foreach ($project_users as $project_user) {
                if($project_user->user_id == $request->id[$i] && $project_user->project_id == $request->project_id) {
                    ProjectUser::where('project_id', $request->project_id)->where('user_id', $request->id[$i])->delete();
                    $task = Task::where('project_id', $request->project_id)->get();
                    if($task){
                        foreach($task as $remove_task_id){
                        TaskUser::where('task_id', $remove_task_id->id)->where('user_id', $request->id[$i])->delete();
                        }
                    }  
                }
            }
        }
        return response()->json(true);
    }

    public function removeUserInProject(Request $request) {
        $project_users = ProjectUser::all();

        for($i = 0; $i < count($request->id); $i++) {
            foreach ($project_users as $project_user) {
                if($project_user->project_id == $request->id[$i] && $project_user->user_id == $request->user_id) {
                    ProjectUser::where('project_id', $request->id[$i])->where('user_id', $request->user_id)->delete();
                }
            }
        }

        return response()->json(true);
    }

    public function search(Request $request) {
        $projects = Project::where('name', 'LIKE', '%'.$request->name.'%')->get();
        $arr = [];
        foreach ($projects as $project) {
            array_push($arr, $project->projectUsers);
        }
        return response()->json(['projects' => $projects]);

    }
    

    public function editTask($id) {
        $task = Task::find($id);

        return view('invoice.admin.projects.editTask', compact('task'));
    }

    public function updateTask($id, Request $request) {
        $task = Task::find($id);
        $date = explode('/', $request->date)[2] . '-' . explode('/', $request->date)[1] . '-' . explode('/', $request->date)[0];

        $task->task_number = $request->task_number;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->date = $date;
        $task->time = $request->time;

        $task->save();

        return back()->with('success', 'Task updated successfully!');
    }

    public function team($id) {
        $projectUsers = ProjectUser::where('project_id', $id)->orderByDesc('created_at')->with('users')->get();
        $project = Project::find($id);

        return view('invoice.admin.projects.team', compact('projectUsers', 'project'));
    }
}
