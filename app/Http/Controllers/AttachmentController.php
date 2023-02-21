<?php

namespace App\Http\Controllers;

use App\Repositories\AttachmentRepository;
use Illuminate\Http\Request;

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
        $fileName = time().'.'.$file->extension();
        $publicFile = $file->move(public_path('images'), $fileName);
        $url = url('/images', ['file' => $fileName]);

        $this->attachmentRepo->save([
            'uuid'=>"1",
            'attachable_type'=>'task',
            'file_path' => $publicFile->getPath(),
            'file_name' => $publicFile->getFilename(),
            'extension' => $publicFile->getExtension(),
            'mime_type'=> $publicFile->getMimeType(),
            'size' => $publicFile->getSize(),
            'deleted_by'=>null,
            'deleted_at'=>null,
        ]);

        return $this->success($url);
    }

}
