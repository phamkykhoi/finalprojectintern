<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function deleteFile($id)
    {
        Attachment::find($id);
        if (Storage::exists("public\attachments\\".Attachment::find($id)['file_name'])) {
            Storage::delete("public\attachments\\".Attachment::find($id)['file_name']);
        }
        Attachment::destroy($id);
        
    }
}
