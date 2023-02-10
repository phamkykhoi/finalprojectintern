<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


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
    Route::get('user/list', [UserController::class, 'indexJson']);
    Route::resource('user', UserController::class);
    Route::resource('department', DepartmentController::class);
    Route::post('department/assign-member', [DepartmentController::class, 'assignMember'])->name('department.assign.member');
    Route::get('department/{departmentId}/members', [DepartmentController::class, 'getMembers'])->name('department.members');
    Route::delete('department/{departmentId}/remove/member/{userId}', [DepartmentController::class, 'removeMember'])->name('department.remove.member');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
