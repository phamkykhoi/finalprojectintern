<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\DepartmentRepository;

class DashboardController extends Controller
{
    protected $departmentRepo;

    public function __construct(DepartmentRepository $departmentRepo)
    {
        $this->departmentRepo = $departmentRepo;
    }

    public function index()
    {
        $user = auth()->user();

        return Inertia::render('Dashboard', [
            'departments' => $this->departmentRepo->getDepartments(['activities'], $user->isRoot() ? null : $user->id)
        ]);
    }
}
