<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\UserRepository;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $userPaginate = $this->userRepo->paginate();

        return Inertia::render('User/Index', [
            'users' => $userPaginate->items(),
            'meta' => [
                'total' => $userPaginate->total(),
                'perPage' => $userPaginate->perPage(),
                'currentPage' => $userPaginate->currentPage(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Form', [
            'pageTitle' => 'Thêm mới thành viên'
        ]);
    }

    public function store(CreateUserRequest $request)
    {
        $inputs = $request->all();
        $inputs['role'] = User::ROLES['member'];
        $inputs['password'] = bcrypt($inputs['password']);

        $this->userRepo->save($inputs);
        return redirect()->route('user.index')->with('message', 'Create User Successfully!');
    }

    public function edit($id)
    {
        return Inertia::render('User/Form', [
            'user' => $this->userRepo->findById($id),
            'pageTitle' => 'Cập nhật thành viên',
        ]);   
    }

    public function update($id, UpdateUserRequest $request)
    {
        $inputs = $request->all();

        if (empty($inputs['password'])) {
            unset($inputs['password']);
        } else {
            $inputs['password'] = bcrypt($inputs['password']);
        }

        $this->userRepo->save($inputs, ['id' => $id]);
        return redirect()->route('user.index')->with('message', 'Edit User Successfully!');
    }
    
    public function destroy($id)
    {
        $this->userRepo->deleteById($id);
        return redirect()->route('user.index')->with('message', 'Delete Successfully!');
    }

    public function indexJson()
    {
        return response()->json([
            'users' => $this->userRepo->getAll()
        ]);
    }
    
    public function listFollowersInTask($id)
    {
        return $this->success([
            'listFollowers' => $this->userRepo->getListMembersInTask(null, 5, $id),
        ]);
    }
    
    public function listPerformersInTask($id)
    {
        return $this->success([
            'listPerformers' => $this->userRepo->getListMembersInTask(null, 7, $id),
        ]);
    }
}
