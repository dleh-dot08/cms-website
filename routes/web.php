<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\MentorController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    // hanya superadmin boleh kelola peserta
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:superadmin')
        ->group(function () {
            Route::get('/peserta', [ParticipantController::class, 'index'])->name('peserta.index');
            Route::get('/peserta/tambah', [ParticipantController::class, 'create'])->name('peserta.create');
            Route::post('/peserta', [ParticipantController::class, 'store'])->name('peserta.store');
            Route::delete('/peserta/{user}', [ParticipantController::class, 'destroy'])->name('peserta.destroy');
        });

});

Route::middleware(['auth','role:superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('officers', \App\Http\Controllers\Admin\OfficerController::class)
            ->parameters(['officers' => 'person'])
            ->except(['show']);

        Route::resource('interns', \App\Http\Controllers\Admin\InternController::class)
            ->parameters(['interns' => 'person'])
            ->except(['show']);

        Route::resource('mentors', \App\Http\Controllers\Admin\MentorController::class)
            ->parameters(['mentors' => 'person'])
            ->except(['show']);
    });

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:superadmin')
        ->group(function () {
            Route::resource('users', UserController::class)->except(['show']);
        });
});


require __DIR__.'/auth.php';
