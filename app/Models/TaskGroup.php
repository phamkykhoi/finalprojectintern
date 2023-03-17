<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'activity_id',
        'created_by',
        'updated_by'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
