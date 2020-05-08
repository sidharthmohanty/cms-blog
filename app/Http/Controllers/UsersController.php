<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function index(){
        return view('users.index')->with('users', User::all());
    }

    public function update(User $user){
       $user->role = 'Admin';
        $user->save();
        session()->flash('success', 'User role has been updated successfully');
        return redirect(route('user-list'));
    }

    public function profile(){
        return view('users.profile')->with('user', auth()->user());
    }

    public function profileUpdate(Request $request){
        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'about' => $request->about
        ]);

        session()->flash('success', 'User profile updated successfully');
        return redirect(route('user-profile'));
    }
}