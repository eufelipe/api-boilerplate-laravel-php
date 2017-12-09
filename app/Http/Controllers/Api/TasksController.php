<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\TasksRequest as Request;
use Carbon\Carbon;

class TasksController extends Controller
{

    const TASK_TIME_CACHE_IN_MINUTES = 10;
    const TASK_CACHE_KEY = 'api::tasks';


    public function index()
    {
        $timeCacheInMinutes = Carbon::now()->addMinutes(self::TASK_TIME_CACHE_IN_MINUTES);
        $tasks = \Cache::remember(self::TASK_CACHE_KEY, $timeCacheInMinutes, function () {
            return Task::all();
        });
        return $tasks;

    }

    public function store(Request $request)
    {
        $this->cleanCache();
        $data = $request->all();
        $data['user_id'] = \Auth::user()->id;
        return Task::create($data);
    }

    private function cleanCache()
    {
        \Cache::forget(self::TASK_CACHE_KEY);
    }

    public function update(Request $request, Task $task)
    {
        $this->cleanCache();
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
        $this->cleanCache();
        $this->authorize('delete', $task);
        $task->delete();
        return $task;
    }

}
