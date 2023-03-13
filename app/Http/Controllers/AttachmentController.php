<?php

namespace App\Http\Controllers;

use App\Repositories\AttachmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Events\UploadFileSuccess;
use App\Models\Attachment;

class AttachmentController extends Controller
{
    protected $attachmentRepo;

    public function __construct(
        AttachmentRepository $attachmentRepo,
    )
    {
        $this->attachmentRepo = $attachmentRepo;
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->hashName();
        Storage::disk('local')->putFile('public/attachments', $file);
        $attachment = $this->attachmentRepo->save([
            'attachable_id' => json_decode($request->all()['params'])->task_id,
            'file_path' => Storage::path($fileName),
            'file_name' => $fileName,
            'extension' => $file->extension(),
            'mime_type'=> $file->getMimeType(),
            'size' => $file->getSize(),
            'title' => $file->getClientOriginalName(),
        ]); 
        event(new UploadFileSuccess($attachment, $request));
        return $this->success([
            'file_url' => url('/storage/attachments', ['file' => $fileName])
        ]);
    }

    public function getAttachments($id)
    {
        return $this->success([
            'attachment_list' => $this->attachmentRepo->getByTaskId($id)
        ]);
    }

}
