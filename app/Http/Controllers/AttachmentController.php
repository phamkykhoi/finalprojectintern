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

    public function destroy($attachmentId)
    {
        try {
            $this->attachmentRepo->deleteById($attachmentId);
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
        try {
            $this->attachmentRepo->updateAttachment( $request->get('task'), $request->get('listAttachments'));
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
