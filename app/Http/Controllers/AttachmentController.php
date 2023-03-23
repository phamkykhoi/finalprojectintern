<?php

namespace App\Http\Controllers;

use App\Repositories\AttachmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Events\UploadFileSuccess;
use App\Models\Attachment;
use App\Services\FileService;

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
        $param = json_decode($request->params);
        $file = $request->file('file');
        $fileName = $file->hashName();
        Storage::disk('local')->putFile('public/attachments', $file);

        $attachment = $this->attachmentRepo->save([
            'attachable_id' => $param->task_id,
            'file_path' => Storage::path($fileName),
            'file_name' => $fileName,
            'extension' => $file->extension(),
            'mime_type'=> $file->getMimeType(),
            'size' => $file->getSize(),
            'title' => $file->getClientOriginalName(),
        ]);

        $params = $request->params ? json_decode($request->params, true) : [];
        event(new UploadFileSuccess($attachment, $params ?? []));

        return $this->success([
            'attachment' => $attachment,
            'file_url' => url('/storage/attachments', ['file' => $fileName])
        ]);
    }

    public function deleteByIds(Request $request)
    {
        try {
            if(!is_array($request->checkedFiles)){
                app(FileService::class)->deleteFile($request->checkedFiles);
                return $this->success();
            }
            
            foreach($request->checkedFiles as $attachmentId){
                app(FileService::class)->deleteFile($attachmentId);
            }

            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getAttachments($id)
    {
        return $this->success([
            'attachment_list' => $this->attachmentRepo->getByTaskId($id)
        ]);
    }

    public function deleteAttachmentByTask(Request $request, $taskId)
    {
        try {
            $this->attachmentRepo->deleteAttachmentByTask($request->checkedFiles);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function updateAttachmentInfor(Request $request)
    {
        dd($request);
        try {
            $this->attachmentRepo->updateAttachment( $request->get('task'), $request->get('listAttachments'));
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
