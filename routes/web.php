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
Route::get('/profile', [JobApplicationController::class, 'appplicationsOnProfile'])->name('profile.view');

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


// GET|HEAD        / ............................................................................ 
// GET|HEAD        admin/approve-job/{id} ......... admin.approveJob › AdminController@approveJob
// GET|HEAD        admin/reject-job/{id} ............ admin.rejectJob › AdminController@rejectJob
// GET|HEAD        applications ............. applications.index › JobApplicationController@index
// POST            applications/{id}/approve applications.approve › JobApplicationController@app…
// POST            applications/{id}/reject applications.reject › JobApplicationController@reject
// GET|HEAD        home ............................................. home › HomeController@index
// GET|HEAD        jobs ........................................ jobs.index › JobController@index
// POST            jobs ........................................ jobs.store › JobController@store
// GET|HEAD        jobs/create ............................... jobs.create › JobController@create
// POST            jobs/search ............................... jobs.search › JobController@search
// POST            jobs/{jobId}/apply .......................... jobs.apply › JobController@apply
// GET|HEAD        jobs/{job} .................................... jobs.show › JobController@show
// PUT|PATCH       jobs/{job} ................................ jobs.update › JobController@update
// DELETE          jobs/{job} .............................. jobs.destroy › JobController@destroy
// PUT             jobs/{job} ................................ jobs.update › JobController@update
// GET|HEAD        jobs/{job}/edit ............................... jobs.edit › JobController@edit
// GET|HEAD        login ............................. login › Auth\LoginController@showLoginForm
// POST            login ............................................. Auth\LoginController@login
// POST            logout .................................. logout › Auth\LoginController@logout
// GET|HEAD        password/confirm password.confirm › Auth\ConfirmPasswordController@showConfir…
// POST            password/confirm ...................... Auth\ConfirmPasswordController@confirm
// POST            password/email password.email › Auth\ForgotPasswordController@sendResetLinkEm…
// GET|HEAD        password/reset password.request › Auth\ForgotPasswordController@showLinkReque…
// POST            password/reset .......... password.update › Auth\ResetPasswordController@reset
// GET|HEAD        password/reset/{token} password.reset › Auth\ResetPasswordController@showRese…
// GET|HEAD        register ............. register › Auth\RegisterController@showRegistrationForm
// POST            register .................................... Auth\RegisterController@register
// GET|HEAD        up ........................................................................... 

                         