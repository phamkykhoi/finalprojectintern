<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\DepartmentRepository;
use App\Http\Requests\Department\CreateDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Http\Requests\Department\AssignMemberRequest;
use App\Repositories\UserDepartmentRepository;
use App\Repositories\UserRepository;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $departmentRepo;

    protected $userDepartmentRepo;

    protected $userRepo;

    public function __construct(
        DepartmentRepository $departmentRepo,
        UserDepartmentRepository $userDepartmentRepo,
        UserRepository $userRepo
    )
    {
        $this->departmentRepo = $departmentRepo;
        $this->userDepartmentRepo = $userDepartmentRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $departmentPaginate = $this->departmentRepo->paginate();

        return Inertia::render('Departen/Show', [
            'departments' => $departmentPaginate->items(),
            'meta' => [
                'total' => $departmentPaginate->total(),
                'perPage' => $departmentPaginate->perPage(),
                'currentPage' => $departmentPaginate->currentPage(),
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Departen/Create', [
            'pageTitle' => 'Thêm mới Phòng ban'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        $this->departmentRepo->save($request->all());
        return redirect()->route('department.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('Departen/Create', [
            'department' => $this->departmentRepo->findById($id),
            'pageTitle' => 'Cập nhật Phòng ban',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateDepartmentRequest $request)
    {
        $inputs = $request->all();
        $this->departmentRepo->save($inputs, ['id' => $id]);
        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->departmentRepo->deleteById($id);
        return redirect()->route('department.index');
    }

    public function assignMember(AssignMemberRequest $request)
    {
        try {
            $this->userDepartmentRepo->assignMember(
                $request->user_id,
                $request->department_id,
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

    public function removeMember($departmentId, $userId)
    {
        try {
            $this->userDepartmentRepo->removeMember($userId, $departmentId);

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

    public function getMembers($departmentId)
    {
        try {
            return response()->json([
                'users' => $this->userRepo->getByDepartmentId($departmentId)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
