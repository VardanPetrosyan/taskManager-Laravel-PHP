<?php

namespace App\Http\Controllers\Invoice\Users;

use App\Models\Invoice\ProjectUser;
use App\Models\Invoice\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function profile($id) {
        $user = User::find($id);

        $projectUserCount = ProjectUser::where('user_id', $id)->count();

        $tasksCount = Task::where('user_id', $id)->count();

        return view('invoice.users.profile.profile', compact('user', 'projectUserCount', 'tasksCount'));
    }

    public function profileUpdate($id, Request $request) {
        $validatedData = $request->validate([
            "username" => ['required', 'regex:/^\S*$/u','min:4', 'max:255'],
            "email" => ['required',"regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/u",Rule::unique('users')->ignore($id)],
        ]);
        $user = User::find($id);

        $user->name = $request->username;
        $user->email = $request->email;

        $user->save();

        return back()->with('success', 'You updated your profile!');
    }

    public function settings() {
        return view('invoice.users.profile.settings');
    }

    public function checkOldPassword(Request $request) {
        $user = User::find($request->id);

        if(Hash::check($request->old_pass, $user->password)) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function updatePassword($id, Request $request) {
        $validatedData = $request->validate([
            "new_password" => ['required', 'regex:/^\S*$/u','min:4', 'max:255'],
        ]);
        $user = User::find($id);

        $user->password = Hash::make($request->new_password);

        $user->save();

        return back()->with('success', 'You updated your password!');
    }
}
