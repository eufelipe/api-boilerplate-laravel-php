<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\TasksRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TasksController extends Controller
{


    /**
     * @var mixed
     */
    private $taskService = null;


    public function __construct()
    {
        $this->taskService = resolve(TaskService::class);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->taskService->searchTasks($request);

    }


    /**
     * @param TasksRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(TasksRequest $request)
    {
        return $this->taskService->createTask($request);
    }


    /**
     * @param TasksRequest $request
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TasksRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        return $this->taskService->updateTask($request, $task);
    }


    /**
     * @param Task $task
     * @return Task
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return $task;
    }


    /**
     * @param Task $task
     * @return Task
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        return $this->taskService->deleteTask($task);
    }

}
