<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Repositories\ActivityRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\TaskGroupRepository;
use App\Http\Requests\Activity\StoreActivityRequest;
use App\Http\Requests\Activity\UpdateActivityRequest;
use App\Http\Requests\Activity\AssignMemberRequest;
use App\Repositories\UserActivityRepository;
use App\Repositories\UserRepository;

class ActivityController extends Controller
{
    protected $departmentRepo;

    protected $activityRepo;

    protected $taskGroupRepo;

    protected $userActivityRepo;

    protected $userRepo;
    public function __construct(
        ActivityRepository $activityRepo,
        DepartmentRepository $departmentRepo,
        TaskGroupRepository $taskGroupRepo,
        UserActivityRepository $userActivityRepo,
        UserRepository $userRepo,
    )
    {
        $this->activityRepo = $activityRepo;
        $this->departmentRepo = $departmentRepo;
        $this->taskGroupRepo = $taskGroupRepo;
        $this->userActivityRepo = $userActivityRepo;
        $this->userRepo = $userRepo;
    }

    public function show($id)
    {
        $user = auth()->user();
        return Inertia::render('Activity/Detail', [
            'activity' => $this->activityRepo->findById($id),
            'departments' => $this->departmentRepo->getDepartments(['activities'], $user->isRoot() ? null : $user->id),
            'taskGroups' => $this->taskGroupRepo->getByActivityId($id),
            'activityId' => (int) $id,
        ]);
    }

    public function store(StoreActivityRequest $request)
    {
        $this->activityRepo->save($request->all());
        return redirect()->route('dashboard');
    }

    public function update($id, UpdateActivityRequest $request)
    {

        try {
            $inputs = $request->all();
            $this->activityRepo->save($inputs, ['id' => $id]);
            return $this->success();

        } catch (\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }

    }

    public function assignMember(AssignMemberRequest $request)
    {
        try {
            $this->userActivityRepo->assignMember(
                $request->user_id,
                $request->activity_id,
                $request->role_id
            );

            return response()->json([
                'status' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function removeMember($activityId, $userId)
    {
        try {
            $this->userActivityRepo->removeMember($userId, $activityId);

            return response()->json([
                'status' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getMembers($activityId)
    {
        try {
            return response()->json([
                'users' => $this->userRepo->getByActivityId($activityId)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
