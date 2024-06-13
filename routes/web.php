<?php

use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\Student;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PusherController;
use Illuminate\Support\Facades\Broadcast;


Route::get('user', [App\Http\Controllers\UserControllers::class, 'index'])
    ->name('home');

Route::post(
    'user/login',
    [App\Http\Controllers\UserControllers::class, 'loginPage']
);

Route::middleware(['guest'])->prefix('user')->group(function () {
    Route::get(
        'login',
        [App\Http\Controllers\UserControllers::class, 'showLogin']
    )
        ->name('login');
    Route::post(
        'login',
        [App\Http\Controllers\UserControllers::class, 'loginPage']
    );
    Route::get(
        'create',
        [App\Http\Controllers\UserControllers::class, 'create']
    )
        ->name('register');
    Route::post(
        'create',
        [App\Http\Controllers\UserControllers::class, 'store']
    );
});


Route::post(
    'user/logout',
    [App\Http\Controllers\UserControllers::class, 'logout']
)
    ->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::delete(
        'user/{user}/delete',
        [UserController::class, 'delete']
    );
    Route::put(
        'user/{user}/edit',
        [UserController::class, 'edit']
    );
    Route::post(
        'user',
        [UserController::class, 'store']
    );
    Route::post(
        'subject',
        [SubjectController::class, 'store']
    );
    Route::post(
        'subject/assign',
        [SubjectController::class, 'assign']
    )->name('subject.assign');
    Route::put('/subject/mark', [SubjectController::class, 'mark'])
        ->name('subject.mark');
});



Route::middleware(['auth'])->group(function () {
    // Route::post('/chat/subject', [ChatController::class, 'store'])->name('chat.store');
    Route::post('/chat/subject', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/subject', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/subject/{subject}', [ChatController::class, 'messages'])->name('chat.messages');
    Broadcast::channel('chat.{subjectId}', function ($user, $subjectId) {
        $chat = \App\Models\Chat::find($subjectId);

        if ($chat) {
            return $user->id === $chat->sender_id || $user->id === $chat->receiver_id;
        }

        return false;
    });
});
Route::post('/pusher/auth', [PusherController::class, 'authenticate'])->name('pusher.auth');
Route::get('/students/{subject}', [StudentController::class, 'studentsInSubject'])->name('students_in_subject');
