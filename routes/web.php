<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;



Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:PIC'])->group(function () {    
    Route::resource('users', UserManagementController::class);
});

Route::middleware(['auth','role:PIC'])->group(function () {
    Route::get('/task-categories', [TaskCategoryController::class, 'index'])->name('task-categories.index');
    Route::get('/task-categories/create', [TaskCategoryController::class, 'create'])->name('task-categories.create');
    Route::post('/task-categories', [TaskCategoryController::class, 'store'])->name('task-categories.store');
    Route::get('/task-categories/{id}/edit', [TaskCategoryController::class, 'edit'])->name('task-categories.edit');
    Route::put('/task-categories/{id}', [TaskCategoryController::class, 'update'])->name('task-categories.update');
    Route::get('/task-categories/{id}/force-delete', [TaskCategoryController::class, 'forceDestroy'])->name('task-categories.force-destroy');
    Route::delete('/task-categories/{id}', [TaskCategoryController::class, 'destroy'])->name('task-categories.destroy');
});

Route::middleware(['auth'])->prefix('daily-reports')->name('daily-reports.')->group(function () {
    Route::get('/', [DailyReportController::class, 'index'])->name('index');
    Route::get('/create', [DailyReportController::class, 'create'])->name('create');
    Route::post('/', [DailyReportController::class, 'store'])->name('store');
    Route::get('/{dailyReport}', [DailyReportController::class, 'show'])->name('show');
    Route::get('/{dailyReport}/continue', [DailyReportController::class, 'continue'])->name('continue');
    Route::delete('/{dailyReport}', [DailyReportController::class, 'destroy'])->name('destroy');
    Route::post('/{dailyReport}/approve', [DailyReportController::class, 'approve'])->name('approve');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings.index');
    Route::post('/meetings/generate', [MeetingController::class, 'generateMeetings'])->name('meetings.generate');
    Route::post('/meetings/{meeting}/topics', [MeetingController::class, 'storeTopic'])->name('meetings.topics.store');
    Route::patch('/topics/{topic}/toggle', [MeetingController::class, 'toggleComplete'])->name('topics.toggle');
    Route::post('/topics/{topic}/continue', [MeetingController::class, 'continueTopic'])->name('topics.continue');
});

require __DIR__.'/auth.php';



