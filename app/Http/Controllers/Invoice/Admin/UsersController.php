<?php

namespace App\Http\Controllers\Invoice\Admin;

use App\Models\Invoice\ProjectUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Validation\Rule;
use App\Models\Invoice\Task;
use App\Models\Invoice\TasksHelper;
use App\Models\Invoice\TaskUser;
use App\Models\Invoice\TaskSettings;
use App\Models\Invoice\Project;

class UsersController extends Controller
{
    public function index() {
        $projects = Project::all();
        $task = Task::all();
        $taskuser = TaskUser::all();
        $settings = TasksHelper::all();
        $taskSetting = TaskSettings::all();
        $users = User::where('invoice', 1)->where('status', 'user')->orderByDesc('created_at')->paginate(10);

        return view('invoice.admin.users.index', compact('projects','users','task','settings','taskuser','taskSetting'));
    }

    public function edit($id) {
        $user = User::find($id);
        $projects = ProjectUser::where('user_id', $id)->get();

        return view('invoice.admin.users.edit', compact('user', 'projects'));
    }

    public function update($id, Request $request) {
        $validatedData = $request->validate([
            "name" => ['required', 'regex:/^\S*$/u','min:4', 'max:255'],
            "email" => ['required',"regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/u",Rule::unique('users')],
            "password" => ['required', 'regex:/^\S*$/u','min:4', 'max:255'],
        ]);
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;

        $name = 'default-user.jpg';
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $name = uniqid(). '.' . $image->getClientOriginalExtension();
            $image->move(public_path('invoices/images/'), $name);
        }

        $user->img = 'invoices/images/' . $name;
        $user->save();

        return redirect()->route('invoice.admin.users')->with('success', 'User profile updated successfully!');
    }

    public function create() {
        return view('invoice.admin.users.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            "name" => ['required', 'regex:/^\S*$/u','min:4', 'max:255'],
            "email" => ['required',"regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/u",Rule::unique('users')],
            "password" => ['required', 'regex:/^\S*$/u','min:4', 'max:255'],
        ]);
        $user = new User();

        $user->name = $request->name;
        $user->img = 'invoices/images/default-user.jpg';
        $user->email = $request->email;
        $user->password = Hash::make(trim($request->password));
        $user->invoice = 1;
        $user->is_verify = 1;

        $user->save();
        
        return redirect()->route('invoice.admin.users')->with('success', 'User created successfully!');
    }

    public function delete($id) {
        User::destroy($id);

        return back()->with('success', 'User deleted successfully!');
    }

    public function remove(Request $request) {

        if($request->tasks){
            $task = json_decode($request->tasks);
            $last_val = false;
    
            foreach(json_decode($request->tasks) as $edit_task){
                $key =  $edit_task->key;
    
                $task = TaskUser::where('user_id', $key)->get();
                if(isset($edit_task)){
                    foreach($task as $edit){
                        foreach($edit_task->value as $val){
                            if($val !== $last_val){
                                $last_val = $val;
                                $taskus = new TaskUser();
                                $taskus->task_id = $edit->task_id;
                                $taskus->user_id = $val;
                                $taskus->save();  
                            }
                        }
                }
                
    
                foreach($task as $tasku){

                    $tasku->delete();
                };
                }
            }
        }
        
        foreach ($request->id as $id) {
            User::destroy($id);
        }
        return response()->json(true);
    }

    public function invite(Request $request) {
        $users = explode(',', $request->invite_email);

        foreach ($users as $user) {
            $to_email = trim($user);
            $uniq = uniqid();
            $us = new User();
            $us->email = $to_email;
            $us->code = $uniq;
            $us->save();

            $data = array('name' => $to_email, 'body' => "follow this <a href='" . route('invoice.register') . "?code=" . $uniq . "'>link</a> to register");

            Mail::send('invoice.admin.mail.mail', $data, function ($message) use ($to_email) {
                $message->to($to_email)->subject('Registration');

                $message->from($to_email, env('MAIL_USERNAME'));
            });
        }

        return back()->with('success', 'Mail send successfully!');
    }

    public function checkEmail(Request $request) {
        $user = User::where('email', $request->email)->first();

        if(is_null($user)) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
}
