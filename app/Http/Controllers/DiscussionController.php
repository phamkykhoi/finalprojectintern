<?php

namespace App\Http\Controllers;

use App\Repositories\DiscussionRepository;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    protected $discussionRepo;

    public function __construct(
        DiscussionRepository $discussionRepo,
    ) {
        $this->discussionRepo = $discussionRepo;
    }

    public function getDiscussion($id)
    {
        return $this->success([
            'discussions' => $this->discussionRepo->getByTaskId($id)
        ]);
    }

    public function store(Request $request)
    {
        try {
            $this->discussionRepo->save($request->all());
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function update($discussionId, Request $request)
    {
        try {
            $this->discussionRepo->save(['description' => $request->description], ['id' => $discussionId]);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
