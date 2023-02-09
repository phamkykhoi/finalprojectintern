<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeparten extends Model
{
    use HasFactory;

    protected $table = 'user_departments';

    protected $fillable = [
        'user_id',
        'role',
        'departen_id',
    ];
}
