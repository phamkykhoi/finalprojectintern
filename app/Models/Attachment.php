<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'attachable_type',
        'file_path',
        'file_name',
        'extension',
        'mime_type',
        'size',
        'title',
    ];

    public function attachable()
    {
        return $this->morphTo();
    }
}
