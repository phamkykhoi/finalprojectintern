<?php

namespace App\Http\Controllers;

use App\Repositories\DiscussionRepository;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    protected $discussionRepo;

    public function __construct(
        DiscussionRepository $discussionRepo,
    )
    {
        $this->discussionRepo = $discussionRepo;
    }

    public function getDiscussion($id)
    {
        return $this->success([
            'discussion_list'=>$this->discussionRepo->getByTaskId($id)
        ]);
    }
}
