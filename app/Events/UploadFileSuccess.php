<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Attachment;

class UploadFileSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attachment;

    public $params;

    public function __construct(Attachment $attachment, array $params = [])
    {
        $this->attachment = $attachment;
        $this->params = $params;
    }
}
