<?php

namespace App\Http\Controllers\Invoice\Admin;

use App\Models\Invoice\TasksHelper;
use App\Models\Invoice\TaskSettings;
use App\Models\Invoice\ProjectField;
use App\Models\Invoice\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class SettingsController extends Controller
{
    public function index(Request $request) {
        $set = TasksHelper::all();
        if(isset($request->search)){
            $search = $request->search;
            $index = strpos($search, '#');
            if($index === false) {
                $settings = TasksHelper::where('name', 'LIKE', '%'.$search.'%')->orderByDesc('created_at')->get();
            }else{
                $search = explode('#', $search)[1];
                foreach($set as $setting){
                    foreach(json_decode($setting->properties) as $items){
                        if(stripos($items->name, "$search") !== false){
                            $settings[] = $setting;
                        }
                    };
                };
            }
        }else{
            $settings = TasksHelper::all();
        }
        return view('invoice.admin.settings.index', compact('settings','set'));
    }
    public function create() {
        $settings = TasksHelper::all();
        return view('invoice.admin.settings.create',compact('settings'));
    }
    public function newcreate() {
        $settings = TasksHelper::all();
        return view('invoice.admin.settings.newcreate',compact('settings'));
    }
    public function store(Request $request) {

        

        if($request->creat == "true" ){
            $validatedData = $request->validate([
                'name' => ['required'],
                'json_name' => ['required'],
                'json_color' => ['required'],
            ]);
            $setting = new TasksHelper();
            $properties[] = array(
                                "id" => 1,
                                "name"=>$request->json_name,
                                "color"=>$request->json_color
                            );
            
            $setting->name = $request->name;
            $setting->properties = json_encode($properties);
            $setting->save();
            $Projects = Project::all();
            if(isset($Projects)){
                foreach($Projects as $project){
                    $ProjectField = new ProjectField();
                    $ProjectField ->project_id = $project->id;
                    $ProjectField->setting_id = $setting ->id;
                    $ProjectField->Default = json_encode(json_decode($setting->properties)[0]);
                    $ProjectField->EmptyOrNot = 1;
                    $ProjectField->save();
                }
            }
        }else{
            $validator = Validator::make($request->all(), [
                "json_name" => ['required'],
                'json_color' => ['required'],
            ]);
            if($validator->fails()){
                return response()->json(['error'=>$validator->errors()->all()]);
            }
            $setting =  TasksHelper::find($request->Fieldid);

            $setting_properties = $setting->properties;

            $setting_properties =  json_decode($setting_properties);
            
            if(!empty($setting_properties)){
            $setting_properties = end($setting_properties)->id;
                $properties[] = 
                array(
                   "id" => $setting_properties + 1,
                   "name"=>$request->json_name,
                   "color"=>$request->json_color
                );
            }else{
                $properties[] = 
                array(
                   "id" => 1,
                   "name"=>$request->json_name,
                   "color"=>$request->json_color
                );
            }
           
                
            // $setting = TasksHelper::where('name' , '=', $request->name)->first();


            $properties_update = json_encode(array_merge(json_decode($setting->properties),$properties));
        
            $setting->properties = $properties_update;
        if($request->sendByjquery == true){
            $FieldProject = ProjectField::find($request->FieldProjectId);

            if($setting->Default == 1){
                $validatedData = $request->validate([
                    'Fieldid' => ['required'],
                    'json_name' => ['required'],
                    'json_color' => ['required'],
                ]);
                $newfield  = new TasksHelper();
                $newfield->name = $setting->name;
                $newfield->properties = $setting->properties;
                $newfield->Default = '0';

                $newfield->save();
                $FieldProject ->setting_id = $newfield->id;

                $FieldProject ->save();

                $TaskSettings = TaskSettings::where('setting_id',$setting->id)->get();
                foreach($TaskSettings as $taskSetting){
                    if($taskSetting->tasks->projects->id == $FieldProject->project_id){
                        $taskSetting ->setting_id = $newfield->id;
                        $taskSetting->save();
                    }
                }
                if($request->sendByjquery == true){
                    $field = ["$newfield->id","$newfield->name"];
                    return response()->json(['properties'=>$properties,'field'=>$newfield,'last_field'=>$setting]);
                }
            }else{
                $setting->save();
                if($request->sendByjquery == true){
                    $field = ["$setting->id","$setting->name"];
                    return response()->json(['properties'=>$properties,'field'=>$setting,'last_field'=>$setting]);
                }
            }
        }
        $setting->save();

            
        }
        
        return redirect()->route('invoice.admin.settings')->with('success', 'Project created successfully!');
    }
    public function deleteField(Request $request) {
        foreach($request->FieldsId as $Key=>$value){
            $settings = TasksHelper::find($value);
            $ProjectFields = ProjectField::where('setting_id',$settings->id)->get();

            foreach($ProjectFields as $ProjectField){
                $ProjectField->delete();
            }
            $TaskSettings = TaskSettings::where('setting_id',$settings->id)->get();
            foreach($TaskSettings as $TaskSetting){
                $TaskSetting->delete();
            }
            // $settings->delete();
        }
        return response()->json($settings);

    }
    public function edit($name, Request $request) {
        $setting = TasksHelper::where('name' , '=', $name)->first();
        $properties = json_decode($setting->properties);
        $properties = $properties[$request->id];
        return view('invoice.admin.settings.edit', ['setting'=>$setting,'properties'=>$properties,'id'=>$request->id]);
    }
    public function update($id, Request $request) {
        
        $settings = TasksHelper::find($id);

        $setting = json_decode($settings->properties);

        $properties = json_encode(array(
            "id" => $setting[$request->id]->id,
            "name"=>$request->json_name,
            "color"=>$request->json_color
        
        ));

        $setting[$request->id] = json_decode($properties);
        
        $settings->properties = json_encode($setting);
    
        $settings->save();
        if($request ->sendByjquery == true){
            return response()->json($settings);
        }

        return redirect()->route('invoice.admin.settings')->with('success', 'Project updated successfully!');
    }
    public function delete($id, Request $request) {
        $settings = TasksHelper::find($id);
 
        $setting = json_decode($settings->properties);
         array_splice($setting,$request->id,1);
        
        $settings->properties = json_encode($setting);

        $settings->save();

        if(empty(json_decode($settings->properties))){
            foreach($settings->taskSetting as $removesetting){
                $removesetting->delete();
            }
        }
        if($request->sendByjquery == 'true'){
            return response()->json($settings);
        }

        // $Projects = Projects::all();
        // if(isset($Projects)){
        //     foreach($Projects as $project){
        //         $ProjectField = new ProjectField();
        //         $ProjectField ->project_id = $project->id;
        //         $ProjectField->setting_id = $settings ->id;
        //         $ProjectField->Default = json_encode(json_decode($settings->properties)[0]);
        //         $ProjectField->EmptyOrNot = 1;
        //         $ProjectField->save();
        //     }
        // }

        return back()->with('success', 'Project deleted successfully!');
    }

}
