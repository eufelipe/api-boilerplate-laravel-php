<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(Task::class);
    }

}