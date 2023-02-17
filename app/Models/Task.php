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
    ];

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
    protected $casts = [
        'is_important' => 'boolean',
        'is_quickly' => 'boolean',
    ];
}
