<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('jobs', JobController::class);


Route::post('jobs/search', [JobController::class, 'search'])->name('jobs.search');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
    Route::post('jobs/{jobId}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    // Route::post('/applications/{id}/accept', [JobApplicationController::class, 'accept'])->name('applications.accept');
    // Route::post('/applications/{id}/reject', [JobApplicationController::class, 'reject'])->name('applications.reject');

    Route::get('/applications', [JobApplicationController::class, 'index'])->name('applications.index');
});

// Admin routes
// Route::get('/admin/approve-job/{id}', [AdminController::class, 'approveJob'])->name('admin.approveJob');
// Route::get('/admin/reject-job/{id}', [AdminController::class, 'rejectJob'])->name('admin.rejectJob');

// Profile routes
// Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.index');
// Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
// Route::get('applications/{applicationId}/cancel', [ProfileController::class, 'cancelApplication'])->name('applications.cancel');

Route::post('/applications/{id}/approve', [JobApplicationController::class, 'approve'])->name('applications.approve');
Route::post('/applications/{id}/reject', [JobApplicationController::class, 'reject'])->name('applications.reject');




Route::middleware(['auth'])->group(function () {
    Route::get('/admin/approve-job/{id}', [AdminController::class, 'approveJob'])->name('admin.approveJob');
    Route::get('/admin/reject-job/{id}', [AdminController::class, 'rejectJob'])->name('admin.rejectJob');
});
