<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskGroupController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\SubTaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('api/activity/{id}', [TaskController::class, 'show']);
    Route::get('api/list-user/{id}', [TaskController::class, 'getUser']);
    Route::get('api/followers/{id}', [TaskController::class, 'getFollower']);
    Route::get('api/executor/{id}', [TaskController::class, 'getExecutor']);
    Route::resource('activity', ActivityController::class);
    Route::resource('task', TaskController::class);
    Route::put('completed-task/{id}', [TaskController::class,'completedTask']);
    Route::resource('subtask', SubTaskController::class);
    Route::get('api/subtask/{id}', [SubTaskController::class, 'getSubTask']);
    Route::get('user/list', [UserController::class, 'indexJson']);
    Route::resource('user', UserController::class);
    Route::resource('department', DepartmentController::class);
    Route::get('api/department', [DepartmentController::class, 'indexJson']);
    Route::post('department/assign-member', [DepartmentController::class, 'assignMember'])->name('department.assign.member');
    Route::resource('taskgroup', TaskGroupController::class);
    Route::get('department/{departmentId}/members', [DepartmentController::class, 'getMembers'])->name('department.members');
    Route::delete('department/{departmentId}/remove/member/{userId}', [DepartmentController::class, 'removeMember'])->name('department.remove.member');
    Route::get('taskgroup/copy/{id}', [TaskGroupController::class,'copy']);
    Route::get('taskgroup/list/{id}', [TaskGroupController::class,'getTaskGroupList']);
    Route::post('taskgroup/move', [TaskGroupController::class,'move']);
    Route::post('/upload-file', [AttachmentController::class,'upload']);
    Route::post('get-attachments-by-task/{taskId}', [AttachmentController::class, 'getAttachments']);
    Route::post('/get-discussion-by-task-id/{taskId}',[DiscussionController::class,'getByTaskId']);
    Route::post('/update_attachments',[AttachmentController::class,'updateAttachmentInfor']);
    Route::resource('discussion', DiscussionController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
