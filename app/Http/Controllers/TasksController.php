<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TasksRequest as Request;

class TasksController extends Controller
{

    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = \Auth::user()->id;
        return Task::create($data);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $task->update($request->all());
        return $task;
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return $task;
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return $task;
    }


}
