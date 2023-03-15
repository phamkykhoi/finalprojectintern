<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function deleteFile($id)
    {
        if (!$file = Attachment::find($id)) {
            return;
        }
        
        if (Storage::exists("public\attachments\\".$file->file_name)) {
            Storage::delete("public\attachments\\".$file->file_name);
        }

        return $file->delete();
    }
}
