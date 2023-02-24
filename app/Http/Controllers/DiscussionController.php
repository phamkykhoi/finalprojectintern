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
            'discussions'=>$this->discussionRepo->getByTaskId($id)
        ]);
    }

    public function store(Request $request)
    {
        $this->discussionRepo->save($request->all());
        return $this->success();
    }
}
