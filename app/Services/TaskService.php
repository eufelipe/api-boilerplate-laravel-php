<?php

namespace App\Services;

use App\Http\Requests\TasksRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Task;

class TaskService
{

    const TASK_TIME_CACHE_IN_MINUTES = 10;
    const TASK_CACHE_KEY = 'api::tasks';

    private $limit = 10;

    private $orderByColumn = 'id';
    private $order = 'asc';

    private $likeByColumn = null;
    private $like = null;


    public function loadTaskFromCache()
    {
        $timeCacheInMinutes = Carbon::now()->addMinutes(self::TASK_TIME_CACHE_IN_MINUTES);
        $tasks = \Cache::remember(self::TASK_CACHE_KEY, $timeCacheInMinutes, function () {
            return $this->loadTasks();
        });

        return $tasks;
    }

    /**
     * @param string $orderByColumn
     * @param string $order
     * @param null $like
     * @param null $likeByColumn
     * @param int $limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadTasks($orderByColumn = 'id', $order = 'asc', $like = null, $likeByColumn = null, $limit = 10)
    {

        $tasks = Task::orderBy($orderByColumn, $order)
            ->where(function ($query) use ($like, $likeByColumn) {

                if (!is_null($like) && !is_null($likeByColumn)) {
                    return $query->where($likeByColumn, 'like', '%' . $like . '%');
                }
                return $query;
            })
            ->paginate($limit);

        return $tasks;
    }

    /**
     *
     * retorna as tasks paginadas com suporte a filtros de like, order e limit
     *
     *
     * Campos opcionais esperados (from Request):
     *
     *  - limit
     *  - orderByColumn
     *  - order
     *  - likeByColumn
     *  - like
     *
     * Exemplo de utilizacao:
     *
     * /api/v1/tasks?limit=10&orderByColumn=created_at&order=asc&likeByColumn=title&like=Minha Tarefa
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function searchTasks(Request $request)
    {
        $this->clearCache();

        if ($request->has('limit')) {
            $this->limit = $request->limit;
        }

        if ($request->has('orderByColumn')) {
            $this->orderByColumn = $request->orderByColumn;
        }

        if ($request->has('order')) {
            $this->order = $request->order;
        }

        if ($request->has('likeByColumn')) {
            $this->likeByColumn = $request->likeByColumn;
        }

        if ($request->has('like')) {
            $this->like = $request->like;
        }

        try {
            return response()->json($this->loadTasks($this->orderByColumn, $this->order, $this->like, $this->likeByColumn, $this->limit));

        } catch (\Exception $e) {
            return response()->json(["message" => "consulta invalida!", "error" => $e]);
        }

    }

    public function clearCache()
    {
        \Cache::forget(self::TASK_CACHE_KEY);
    }

    /**
     * Cria uma nova task e inclui o usuario logado
     * @param TasksRequest $request
     * @return mixed
     */
    public function create(TasksRequest $request)
    {
        $this->clearCache();
        $data = $request->all();
        $data['user_id'] = \Auth::user()->id;
        return Task::create($data);
    }

    /**
     * Atualiza uma task
     * @param TasksRequest $request
     * @param Task $task
     * @return Task
     */
    public function update(TasksRequest $request, Task $task)
    {
        $this->clearCache();
        $task->update($request->all());
        return $task;
    }

    /**
     * Remove uma task
     * @param Task $task
     * @return Task
     */
    public function destroy(Task $task)
    {
        \Cache::forget(self::TASK_CACHE_KEY);
        $task->delete();
        return $task;
    }


}