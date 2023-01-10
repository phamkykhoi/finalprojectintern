<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Repositories\ActivityRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\TaskGroupRepository;
use App\Http\Requests\Activity\StoreActivityRequest;

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
        return Inertia::render('Activity/Detail', [
            'activity' => $this->activityRepo->findById($id),
            'departments' => $this->departmentRepo->getAll(['activities']),
            'taskGroups' => $this->taskGroupRepo->getByActivityId($id, ['tasks']),
            'activityId' => (int) $id,
        ]);
    }

    public function store(StoreActivityRequest $request)
    {   
        $this->activityRepo->save($request->all());
        return redirect()->route('dashboard');
    }
}
