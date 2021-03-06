<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'completed',
        'user_id'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;

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
