<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/checkLogin', [UserController::class, 'checkLogin'])->name('checkLogin');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/checkDuplicateEmail', [UserController::class, 'checkDuplicateEmail'])->name('checkDuplicateEmail');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'checkLogin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/clear', [UserController::class, 'clear'])->name('clearConditionSearch');
        Route::get('/add', [UserController::class, 'add'])->middleware(['checkPermissions', 'checkDirector'])->name('add');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->middleware(['checkPermissions'])->name('edit');
        Route::post('/update', [UserController::class, 'update'])->middleware(['checkPermissions', 'checkDirector'])->name('update');
        Route::post('/updatePassword', [UserController::class, 'updatePassword'])->name('updatePassword');
        Route::post('/store', [UserController::class, 'store'])->middleware(['checkPermissions', 'checkDirector'])->name('store');
        Route::post('/delete/{id}', [UserController::class, 'delete'])->middleware(['checkPermissions'])->name('delete');
        Route::post('/checkExistsEmail', [UserController::class, 'checkExistsEmail'])->middleware(['checkPermissions', 'checkDirector'])->name('checkExistsEmail');
        Route::get('/exportCSVFile', [UserController::class, 'exportCSVFile'])->middleware(['checkPermissions', 'checkDirector'])->name('exportCSVFile');
    });
    Route::group(['prefix' => 'group', 'as' => 'group.', 'middleware' => 'checkDirector'], function () {
        Route::get('/', [GroupController::class, 'index'])->name('index');
        Route::post('/import', [GroupController::class, 'import'])->name('import');
    });
});
