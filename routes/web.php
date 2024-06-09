<?php

use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('user', [App\Http\Controllers\UserControllers::class, 'index'])
    ->name('home');

Route::post('user/login',
    [App\Http\Controllers\UserControllers::class, 'loginPage']);

Route::middleware(['guest'])->prefix('user')->group(function () {
    Route::get('login',
        [App\Http\Controllers\UserControllers::class, 'showLogin'])
        ->name('login');
    Route::post('login',
        [App\Http\Controllers\UserControllers::class, 'loginPage']);
    Route::get('create',
        [App\Http\Controllers\UserControllers::class, 'create'])
        ->name('register');
    Route::post('create',
        [App\Http\Controllers\UserControllers::class, 'store']);
});


Route::post('user/logout',
    [App\Http\Controllers\UserControllers::class, 'logout'])
    ->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::delete('user/{user}/delete',
        [UserController::class, 'delete']);
    Route::put('user/{user}/edit',
        [UserController::class, 'edit']);
    Route::post('user',
        [UserController::class, 'store']);
    Route::post('subject',
        [SubjectController::class, 'store']);
    Route::post('subject/assign',
        [SubjectController::class, 'assign'])->name('subject.assign');
    Route::put('/subject/mark', [SubjectController::class, 'mark'])
        ->name('subject.mark');
});
