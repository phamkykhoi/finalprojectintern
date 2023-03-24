<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Repositories\ActivityRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\TaskGroupRepository;
use App\Http\Requests\Activity\StoreActivityRequest;
use App\Http\Requests\Activity\UpdateActivityRequest;

class ActivityController extends Controller
{
    protected $departmentRepo;

    protected $activityRepo;

    protected $taskGroupRepo;

    public function __construct(
        ActivityRepository $activityRepo,
        DepartmentRepository $departmentRepo,
        TaskGroupRepository $taskGroupRepo
    )
    {
        $this->activityRepo = $activityRepo;
        $this->departmentRepo = $departmentRepo;
        $this->taskGroupRepo = $taskGroupRepo;
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
}
