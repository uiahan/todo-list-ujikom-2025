<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManageTaskerController;
use App\Http\Controllers\Admin\ManageWorkerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Tasker\ManageJobController;
use App\Http\Controllers\Tasker\TaskerController;
use App\Http\Controllers\Worker\JobController;
use App\Http\Controllers\Worker\QuestController;
use App\Http\Controllers\Worker\WorkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('index');

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['prefix' => 'admin', 'middleware' => ['can:admin']], function (){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.admin');
    Route::group(['prefix' => 'manage-tasker', 'controller' => ManageTaskerController::class], function(){
        Route::get('/', 'index')->name('manage.tasker');
    });
    Route::group(['prefix' => 'manage-worker', 'controller' => ManageWorkerController::class], function(){
        Route::get('/', 'index')->name('manage.worker');
    });
});

Route::group(['prefix' => 'tasker', 'middleware' => ['can:tasker']], function (){
    Route::get('/dashboard', [TaskerController::class, 'dashboard'])->name('dashboard.tasker');
    Route::group(['prefix' => 'manage-job', 'controller' => ManageJobController::class], function(){
        Route::get('/', 'index')->name('manage.job');
        Route::get('/view-job', 'viewJob')->name('view.job');
    });
});

Route::group(['prefix' => 'worker', 'middleware' => ['can:worker']], function (){
    Route::get('/dashboard', [WorkerController::class, 'dashboard'])->name('dashboard.worker');
    Route::group(['prefix' => 'my-job', 'controller' => JobController::class], function() {
        Route::get('/', 'index')->name('job');
    });
    Route::group(['prefix' => 'quest-list', 'controller' => QuestController::class], function() {
        Route::get('/', 'index')->name('quest');
    });
});
