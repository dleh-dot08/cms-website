<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ProgramCategory;
use App\Models\Jenjang;
use App\Models\SubProgram;
use App\Models\CourseMeeting;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $categories  = ProgramCategory::query()->where('is_active', 1)->orderBy('sort_order')->get();
        $levels      = Jenjang::query()->where('is_active', 1)->orderBy('sort_order')->get();
        $subPrograms = SubProgram::query()->where('is_active', 1)->orderBy('sort_order')->get();

        $query = Course::query()
            ->with(['category', 'level', 'subProgram'])
            ->where('is_active', 1);

        if ($q = trim((string) $request->get('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('nama_kursus', 'like', "%{$q}%")
                  ->orWhere('deskripsi_program', 'like', "%{$q}%");
            });
        }

        if ($categoryId = $request->get('category')) {
            $query->where('program_category_id', $categoryId);
        }

        if ($levelId = $request->get('level')) {
            $query->where('jenjang_id', $levelId);
        }

        if ($subId = $request->get('sub')) {
            $query->where('sub_program_id', $subId);
        }

        $courses = $query
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('program', compact('categories', 'levels', 'subPrograms', 'courses'));
    }

    // ✅ SHOW PUBLIC (DETAIL PROGRAM)
    public function show(Course $course)
    {
        $course->load(['programCategory', 'jenjang', 'subProgram']);

        $meetings = $course->meetings()
            ->where('is_active', 1)
            ->orderBy('pertemuan_ke')
            ->get();

        return view('program-show', compact('course', 'meetings'));
    }
}
