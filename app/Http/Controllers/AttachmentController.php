<?php

namespace App\Http\Controllers;

use App\Repositories\AttachmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $this->attachmentRepo->save([
            'uuid' => Str::uuid()->toString(),
            'file_path' => Storage::path($fileName),
            'file_name' => $fileName,
            'extension' => $file->extension(),
            'mime_type'=> $file->getMimeType(),
            'size' => $file->getSize(),
            'title' => $file->getClientOriginalName(),
        ]);

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
