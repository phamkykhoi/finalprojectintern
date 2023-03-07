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
        $user_id = auth()->user()->id;
        
        return Inertia::render('Dashboard', [
            'departments' => $this->departmentRepo->getDepartments(['activities'], ['id' => $user_id])
        ]);
    }
}
