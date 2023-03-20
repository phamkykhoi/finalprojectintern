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
    Route::resource('activity', ActivityController::class);
    Route::resource('task', TaskController::class);
    Route::post('lock-task-by-id/{id}',[TaskController::class,'lockTaskById']);
    Route::post('unlock-task-by-id/{id}',[TaskController::class,'unlockTaskById']);
    Route::get('api/activity/{id}', [TaskController::class, 'show']);
    Route::get('api/list-followers/{id}', [TaskController::class, 'getFollowers']);
    Route::get('api/list-performers/{id}', [TaskController::class, 'getPerformers']);
    Route::put('assign-follower/{id}',[TaskController::class, 'assignFollower']);
    Route::put('assign-performer/{id}',[TaskController::class, 'assignPerformer']);
    Route::post('clone-task-by-id/{id}',[TaskController::class,'cloneTaskById']);
    Route::put('completed-task/{id}', [TaskController::class,'completedTask']);
    Route::resource('subtask', SubTaskController::class);
    Route::get('api/subtask/{id}', [SubTaskController::class, 'getSubTask']);
    Route::get('user/list', [UserController::class, 'indexJson']);
    Route::get('api/list-followers-in-task', [UserController::class, 'listFollowersInTask']); 
    Route::get('api/list-performers-in-task', [UserController::class, 'listPerformersInTask']);
    Route::resource('user', UserController::class);
    Route::resource('department', DepartmentController::class);
    Route::get('api/department', [DepartmentController::class, 'indexJson']);
    Route::post('department/assign-member', [DepartmentController::class, 'assignMember'])->name('department.assign.member');
    Route::resource('taskgroup', TaskGroupController::class);
    Route::get('api/taskgroup/{id}', [TaskGroupController::class, 'getInfo']);
    Route::get('department/{departmentId}/members', [DepartmentController::class, 'getMembers'])->name('department.members');
    Route::delete('department/{departmentId}/remove/member/{userId}', [DepartmentController::class, 'removeMember'])->name('department.remove.member');
    Route::get('taskgroup/copy/{id}', [TaskGroupController::class,'copy']);
    Route::get('taskgroup/list/{id}', [TaskGroupController::class,'getTaskGroupList']);
    Route::post('taskgroup/move', [TaskGroupController::class,'move']);
    Route::delete('delete-attachment', [AttachmentController::class, 'deleteByIds'])->name('delete.file');
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