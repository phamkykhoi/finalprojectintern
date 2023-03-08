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
        try {
            return $this->success([
                'discussions' => $this->discussionRepo->getByTaskId($id)
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function destroy($discussionId)
    {
        try {
            $this->discussionRepo->deleteById($discussionId);
            return $this->success();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $inputs = $request->all();
        $inputs['user_id'] = $user->id;

        try {
            $this->discussionRepo->save($inputs);
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
