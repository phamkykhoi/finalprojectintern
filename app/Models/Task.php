<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'task_group_id',
        'type',
        'start_date',
        'end_date',
        'is_important',
        'is_quickly',
        'status',
        'completed_at',
        'parent_id',
    ];

    const STATUS = [
        'todo' => 1,
        'in_progress' => 2,
        'done' => 3,
        'cancel' => 4
   ];

    protected $appends = ['is_done'];

    public function getIsDoneAttribute()
    {
        return $this->status === static::STATUS['done'];
    }

    public function attachment()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    protected $casts = [
        'is_important' => 'boolean',
        'is_quickly' => 'boolean',
    ];

}
