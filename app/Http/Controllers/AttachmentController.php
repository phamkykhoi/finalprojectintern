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
        $moveFile=$file->move(public_path('images'), $fileName);
        $url = url('/images', ['file' => $fileName]);

        $this->attachmentRepo->save([
            'uuid'=>'csaccas',
            'attachable_type'=>'file',
            'file_path' => $moveFile->getPath(),
            'file_name' => $moveFile->getFilename(),
            'extension' => $moveFile->getExtension(),
            'mime_type'=>'csanciac',
            'size' => $moveFile->getSize(),
        ]);

        return $this->success($url);
    }

}
