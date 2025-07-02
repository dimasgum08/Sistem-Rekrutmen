<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Candidate\CandidateController;
use App\Http\Controllers\Criteria\CriteriaController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\JobVacancy\JobVacancyController;
use App\Http\Controllers\Schedule\ScheduleController;
use App\Http\Controllers\User\UserController;
use App\Models\Notification;
use Illuminate\Support\Facades\Route;
use Vinkla\Hashids\Facades\Hashids;

Route::get('/test', function () {
    return view('administrator.dashboard.index');
});

Route::middleware('guest')->group(function () {
    Route::get('', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'store'])->name('auth.register');
});

Route::prefix('apps')->middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('apps.dashboard');
    Route::get('get-data-job', [DashboardController::class, 'getDataJob']);

    Route::prefix('users')->middleware('can:read-users')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('apps.users');
        Route::get('get-data', [UserController::class, 'getData'])->name('apps.users.get-data');
        Route::get('create', [UserController::class, 'create'])->name('apps.users.create')->middleware('can:create-users');
        Route::post('store', [UserController::class, 'store'])->name('apps.users.store')->middleware('can:create-users');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('apps.users.edit')->middleware('can:update-users');
        Route::post('{user}/update', [UserController::class, 'update'])->name('apps.users.update')->middleware('can:update-users');
        Route::delete('{user}/delete', [UserController::class, 'destroy'])->name('apps.users.destroy')->middleware('can:delete-users');
    });

    Route::prefix('job-vacancies')->group(function () {
        Route::get('', [JobVacancyController::class, 'index'])->name('apps.job-vacancies');
        Route::get('get-data', [JobVacancyController::class, 'getData'])->name('apps.job-vacancies.get-data');
        Route::get('create', [JobVacancyController::class, 'create'])->name('apps.job-vacancies.create');
        Route::post('store', [JobVacancyController::class, 'store'])->name('apps.job-vacancies.store');
        Route::post('{jobVacancy}/posted', [JobVacancyController::class, 'posted'])->name('apps.job-vacancies.posted');
        Route::get('{jobVacancy}/edit', [JobVacancyController::class, 'edit'])->name('apps.job-vacancies.edit');
        Route::post('{jobVacancy}/update', [JobVacancyController::class, 'update'])->name('apps.job-vacancies.update');
        Route::delete('{jobVacancy}/delete', [JobVacancyController::class, 'destroy'])->name('apps.job-vacancies.destroy');
        Route::get('{jobVacancy}/detail', [JobVacancyController::class, 'detail'])->name('apps.job-vacancies.detail');
        Route::post('{jobVacancy}/apply', [JobVacancyController::class, 'apply'])->name('apps.job-vacancies.apply');
    });

    Route::prefix('candidates')->group(function () {
        Route::get('', [CandidateController::class, 'index'])->name('apps.candidates');
        Route::get('get-data', [CandidateController::class, 'getData'])->name('apps.candidates.get-data');
        Route::get('{candidate}/detail', [CandidateController::class, 'detail'])->name('apps.candidates.detail');
        Route::post('{candidate}/update-status', [CandidateController::class, 'updateStatus'])->name('apps.candidates.update-status');
    });

    Route::prefix('schedules')->group(function () {
        Route::get('', [ScheduleController::class, 'index'])->name('apps.schedules');
        Route::get('get-data', [ScheduleController::class, 'getData'])->name('apps.schedules.get-data');
        Route::get('{candidate}/evaluations', [ScheduleController::class, 'evaluation'])->name('apps.schedules.evaluation');
        Route::post('{candidate}/update', [ScheduleController::class, 'update'])->name('apps.schedules.update');
    });

    Route::prefix('apply')->group(function () {
        Route::get('jobs',[CandidateController::class, 'index'])->name('apps.apply.jobs');
        Route::get('status/{status}', [CandidateController::class, 'getApply'])->name('apps.apply.status');
    });

    Route::get('logout', [AuthController::class, 'logout'])->name('apps.logout');

    Route::post('/notifications', function (\Illuminate\Http\Request $request) {
        $hashids = $request->input('hashids', []);
        $action = $request->input('action');
        if (!is_array($hashids)) return response()->json(['success' => false]);
        $ids = collect($hashids)->map(fn ($hashid) => Hashids::decode($hashid)[0] ?? null)->filter()->all();
        if ($action === 'mark_read') {
            Notification::whereIn('id', $ids)->update(['is_read' => true]);
        } elseif ($action === 'delete') {
            Notification::whereIn('id', $ids)->delete();
        } else {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    });
});


