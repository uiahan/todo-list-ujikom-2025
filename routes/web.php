<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ManageTaskerController;
use App\Http\Controllers\Admin\ManageWorkerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\notificationController;
use App\Http\Controllers\Tasker\ManageJobController;
use App\Http\Controllers\Tasker\ManageQuestController;
use App\Http\Controllers\Tasker\TaskerController;
use App\Http\Controllers\Worker\JobController;
use App\Http\Controllers\Worker\PrivateJobController;
use App\Http\Controllers\Worker\QuestController;
use App\Http\Controllers\Worker\WorkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('index');

Route::group(['prefix' => 'notification', 'controller' => notificationController::class], function() {
    Route::get('/', 'index')->name('notification');
    Route::post('/mark-notification-as-read', 'markAsRead');
});

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
    Route::post('/register', 'register')->name('register');
    Route::post('/update', 'update')->name('update');
    Route::get('/register-show', 'registerShow')->name('register.show');
    Route::get('/profile', 'profile')->name('profile');
    Route::post('/update-password', 'updatePassword')->name('update.password');
});

Route::group(['prefix' => 'admin', 'middleware' => ['can:admin']], function (){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.admin');
    Route::group(['prefix' => 'manage-tasker', 'controller' => ManageTaskerController::class], function(){
        Route::get('/', 'index')->name('manage.tasker');
        Route::get('/tasker-data', 'getTasker')->name('tasker.data');
        Route::get('/get-data/{id}', 'getData')->name('tasker.show');
        Route::post('/store-tasker', 'store')->name('store.tasker');
        Route::put('/update-tasker/{id}', 'update')->name('update.tasker');
        Route::delete('/delete-tasker/{id}', 'delete')->name('delete.tasker');
    });
    Route::group(['prefix' => 'manage-worker', 'controller' => ManageWorkerController::class], function(){
        Route::get('/', 'index')->name('manage.worker');
        Route::get('/worker-data', 'getWorker')->name('worker.data');
        Route::get('/get-data/{id}', 'getData')->name('worker.show');
        Route::post('/store-worker', 'store')->name('store.worker');
        Route::put('/update-worker/{id}', 'update')->name('update.worker');
        Route::delete('/delete-worker/{id}', 'delete')->name('delete.worker');
    });
});

Route::group(['prefix' => 'tasker', 'middleware' => ['can:tasker']], function (){
    Route::get('/dashboard', [TaskerController::class, 'dashboard'])->name('dashboard.tasker');
    Route::group(['prefix' => 'manage-job', 'controller' => ManageJobController::class], function(){
        Route::get('/', 'index')->name('manage.job');
        Route::get('/view-job/{task}/worker/{worker}', 'viewJob')->name('view.job');
        Route::get('/view-worker/{task}', 'viewWorker')->name('view.worker');
        Route::post('/store-job', 'store')->name('store.job');
        Route::post('/store-worker', 'storeWorker')->name('store.job.worker');
        Route::delete('/delete-worker/{id}', 'deleteWorker')->name('delete.job.worker');
        Route::put('/update-job/{id}', 'update')->name('update.job');
        Route::delete('/delete-job/{id}', 'delete')->name('delete.job');
    });
    Route::group(['prefix' => 'manage-quest', 'controller' => ManageQuestController::class], function(){
        Route::post('/store-quest', 'store')->name('store.quest');
        Route::get('/quest/{task}', 'getQuest')->name('get.quest');
        Route::post('/approve-quest', 'approve')->name('quest.approve');
        Route::post('/reject-quest', 'reject')->name('quest.reject');
        Route::delete('/delete-quest/{id}', 'delete')->name('delete.quest');
    });
});

Route::group(['prefix' => 'worker', 'middleware' => ['can:worker']], function (){
    Route::get('/dashboard', [WorkerController::class, 'dashboard'])->name('dashboard.worker');
    Route::group(['prefix' => 'my-job', 'controller' => JobController::class], function() {
        Route::get('/', 'index')->name('job');
    });
    Route::group(['prefix' => 'private-job', 'controller' => PrivateJobController::class], function() {
        Route::get('/', 'index')->name('job.private');
        Route::post('/store-job', 'store')->name('store.job.private');
        Route::put('/update-job/{id}', 'update')->name('update.job.private');
        Route::delete('/delete-job/{id}', 'delete')->name('delete.job.private');
        Route::post('/store-quest/private', 'storeQuest')->name('store.quest.private');
        Route::get('/quest/{task}', 'getQuest')->name('get.quest.private');
        Route::delete('/delete-quest/private/{id}', 'deleteQuest')->name('delete.quest');
        Route::get('/private-quest/{task}', 'privateQuest')->name('private.quest');
        Route::post('/done-quest', 'done')->name('done.quest');
    });
    Route::group(['prefix' => 'quest-list', 'controller' => QuestController::class], function() {
        Route::get('/{task}', 'index')->name('quest');
        Route::post('/quest/progress', 'questProgress')->name('quest.progress');
        Route::post('/quest/cancel', 'cancel')->name('quest.cancel'); 
        Route::post('/quest/review', 'updateToReview')->name('quest.updateToReview'); 
    });
});
