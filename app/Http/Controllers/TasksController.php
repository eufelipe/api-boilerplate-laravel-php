<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TasksRequest as Request;

class TasksController extends Controller
{

    public function index() {
        return Task::all();
    }

    public function store(Request $request) {
        return Task::create($request->all());
    }

    public function update(Request $request, Task $task) {
        $task->update($request->all());
        return $task;
    }

    public function show(Task $task) {
        return $task;
    }

    public function destroy(Task $task) {
         $task->delete();
         return $task;
    }


}
