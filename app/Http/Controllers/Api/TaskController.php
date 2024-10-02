<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        if (count($tasks) > 0) {
            return $tasks;
        } else {
            return response()->json(['message' => 'No tasks found.'], 204);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $task = new Task();
        $task->name = $request->name;
        $task->done = false;
        $task->save();
        return response()->json([
            "message" => 'Task Created Successfully', 
            "task" => $task
        ],  200);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'done' => 'required|boolean',
        ]);
        $task = Task::find($id);
        $task->name = $request->name;
        $task->done = $request->done;
        $task->save();
        return $task;
    }

    public function show($id)
    {

        $task = Task::find($id);
        if ($task) {
            return $task;
        } else {
            return response()->json([
                "message" => 'Task Not Found',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            return response()->json([
                "message" => 'Task Deleted Successfully',
            ],200);
        } else {
            return response()->json([
                "message" => 'Task Not Found',
            ], 404);
        }
    }
}
