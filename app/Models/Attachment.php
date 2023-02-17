<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachbale_id',
        'attachable_type',
        'file_path',
        'file_name',
        'extension',
        'mime_type',
        'size'
    ];

    public function attachable()
    {
        return $this->morphTo();
    }
}
