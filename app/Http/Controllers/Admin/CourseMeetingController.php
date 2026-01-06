<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMeeting;
use Illuminate\Http\Request;

class CourseMeetingController extends Controller
{
    public function create(Course $course)
    {
        return view('admin.course_meetings.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'pertemuan_ke' => ['required','integer','min:1'],
            'judul' => ['nullable','string','max:255'],
            'materi_singkat' => ['nullable','string'],
            'materi_detail' => ['nullable','string'],
            'durasi_menit' => ['nullable','integer','min:0'],
            'is_active' => ['nullable'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['course_id'] = $course->id;
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        CourseMeeting::create($data);

        // sink total pertemuan otomatis
        $course->update(['total_pertemuan' => $course->meetings()->count()]);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Pertemuan berhasil ditambahkan.');
    }

    public function edit(Course $course, CourseMeeting $meeting)
    {
        abort_unless($meeting->course_id === $course->id, 404);
        return view('admin.course_meetings.edit', compact('course','meeting'));
    }

    public function update(Request $request, Course $course, CourseMeeting $meeting)
    {
        abort_unless($meeting->course_id === $course->id, 404);

        $data = $request->validate([
            'pertemuan_ke' => ['required','integer','min:1'],
            'judul' => ['nullable','string','max:255'],
            'materi_singkat' => ['nullable','string'],
            'materi_detail' => ['nullable','string'],
            'durasi_menit' => ['nullable','integer','min:0'],
            'is_active' => ['nullable'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        $meeting->update($data);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Pertemuan berhasil diupdate.');
    }

    public function destroy(Course $course, CourseMeeting $meeting)
    {
        abort_unless($meeting->course_id === $course->id, 404);

        $meeting->delete();
        $course->update(['total_pertemuan' => $course->meetings()->count()]);

        return back()->with('success', 'Pertemuan berhasil dihapus.');
    }
}
