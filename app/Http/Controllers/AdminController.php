<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function index()
    {
        return to_route('home');
    }

    public function name()
    {
        $task = Task::get();
        return view('name', compact('task'));
    }

    public function dashboard(){
        $user_list = User::get();
        return view('dashboard', compact('user_list'));
    }
}
