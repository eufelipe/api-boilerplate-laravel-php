<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'completed'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the task's completed.
     *
     * @param  string  $value
     * @return string
     */
    public function getCompletedAttribute($value)
    {
        return $value == 1;
    }

}
