<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'role_task',
    ];

    const STATUS = [
        'executor' => 1,
        'followers' => 2,
   ];
}
