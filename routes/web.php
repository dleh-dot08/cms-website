<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OfficerController;
use App\Http\Controllers\Admin\InternController;
use App\Http\Controllers\Admin\MentorController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseMeetingController;
use App\Http\Controllers\Admin\ProgramCategoryController;
use App\Http\Controllers\Admin\JenjangController;
use App\Http\Controllers\Admin\SubProgramController;
use App\Http\Controllers\Admin\RecruitmentJobController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\WorkTypeController;
use App\Http\Controllers\Admin\LocationController;


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

// role content: superadmin/admin/marketing (sesuaikan middleware role kamu)
Route::middleware(['auth','role:superadmin,admin,marketing'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('blogs', BlogController::class)
            ->parameters(['blogs' => 'post']);

        Route::resource('news', NewsController::class)
            ->parameters(['news' => 'post']);
        
        Route::resource('categories', CategoryController::class)
            ->parameters(['categories' => 'category']);
    });

Route::middleware(['auth','role:superadmin,admin,marketing'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('blogs', BlogController::class)->parameters(['blogs' => 'post']);
        Route::resource('news', NewsController::class)->parameters(['news' => 'post']);
        Route::resource('categories', CategoryController::class)->parameters(['categories' => 'category']);

        // ✅ MASTER KURSUS (semua di dalam group admin)
        Route::resource('program-categories', ProgramCategoryController::class)
            ->parameters(['program-categories' => 'programCategory'])
            ->names('program_categories');

        Route::resource('jenjangs', JenjangController::class)
            ->parameters(['jenjangs' => 'jenjang'])
            ->names('jenjangs');

        Route::resource('sub-programs', SubProgramController::class)
            ->parameters(['sub-programs' => 'subProgram'])
            ->names('sub_programs');

        Route::resource('courses', CourseController::class)
            ->parameters(['courses' => 'course'])
            ->names('courses');

        // meetings (juga masuk group admin biar URL-nya /admin/...)
        Route::get('courses/{course}/meetings/create', [CourseMeetingController::class, 'create'])
            ->name('course_meetings.create');

        Route::post('courses/{course}/meetings', [CourseMeetingController::class, 'store'])
            ->name('course_meetings.store');

        Route::get('courses/{course}/meetings/{meeting}/edit', [CourseMeetingController::class, 'edit'])
            ->name('course_meetings.edit');

        Route::put('courses/{course}/meetings/{meeting}', [CourseMeetingController::class, 'update'])
            ->name('course_meetings.update');

        Route::delete('courses/{course}/meetings/{meeting}', [CourseMeetingController::class, 'destroy'])
            ->name('course_meetings.destroy');
        
        // MASTER recruitment
        Route::resource('divisions', DivisionController::class)
            ->parameters(['divisions' => 'division'])
            ->names('divisions');

        Route::resource('work-types', WorkTypeController::class)
            ->parameters(['work-types' => 'workType'])
            ->names('work_types');

        Route::resource('locations', LocationController::class)
            ->parameters(['locations' => 'location'])
            ->names('locations');

        Route::resource('tags', TagController::class)
            ->parameters(['tags' => 'tag'])
            ->names('tags');

        // LOWONGAN
        Route::resource('recruitment-jobs', RecruitmentJobController::class)
            ->parameters(['recruitment-jobs' => 'job'])
            ->names('recruitment_jobs');
    });


require __DIR__.'/auth.php';
