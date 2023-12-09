<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $task = $request->task;
        Task::create([
            'user_id' => Auth::user()->id,
            'task' => $task,
            'status' => 0
        ]);
        return to_route('home');
    }

    public function destroy($id)
    {
        $task = Task::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if (isset($task)) {
            $task->delete();
        }
        return to_route('home');
    }

    public function edit($id)
    {
        $task_list = Task::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        $task = Task::findOrFail($id);
        return view('home', compact('task', 'task_list'));
    }

    public function update(Request $request, $id)
    {
        $task = $request->task;
        $task_find = Task::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if (isset($task_find)) {
            $task_find->update([
                'task' => $task
            ]);
        }

        return to_route('home');
    }
    public function update_status(Request $request, $id)
    {
        $status = $request->status;
        $task_find = Task::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if (isset($task_find)) {
            $task_find->update([
                'status' => $status
            ]);
        }

        return 'success';
    }

    public function status_update(Request $request)
    {
        return $request->all();
    }
}
