<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Jenjang;
use App\Models\ProgramCategory;
use App\Models\SubProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $items = Course::query()
            ->with(['programCategory','jenjang','subProgram'])
            ->when($q, fn($qr) => $qr->where('nama_kursus','like',"%{$q}%"))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.courses.index', [
            'items' => $items,
            'q' => $q,
        ]);
    }

    public function create()
    {
        return view('admin.courses.create', [
            'categories' => ProgramCategory::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get(),
            'jenjangs' => Jenjang::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get(),
            'subPrograms' => SubProgram::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'program_category_id' => ['required','integer'],
            'jenjang_id' => ['required','integer'],
            'sub_program_id' => ['required','integer'],

            'nama_kursus' => ['required','string','max:255'],
            'periode_waktu' => ['nullable','string','max:255'],
            'level' => ['nullable','string','max:100'],
            'total_pertemuan' => ['required','integer','min:1'],
            'durasi_menit' => ['nullable','integer','min:1'],
            'pelaksanaan' => ['nullable','string','max:100'],
            'mendapatkan_sertifikat' => ['nullable','boolean'],
            'deskripsi_program' => ['nullable','string'],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],

            // ✅ foto
            'foto_kursus' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        $data['mendapatkan_sertifikat'] = (bool) ($request->boolean('mendapatkan_sertifikat'));
        $data['is_active'] = (bool) ($request->boolean('is_active'));

        if ($request->hasFile('foto_kursus')) {
            $data['foto_kursus_path'] = $request->file('foto_kursus')->store('courses', 'public');
        }

        $data['user_id'] = auth()->id();

        $course = Course::create($data);

        return redirect()->route('admin.courses.show', $course)->with('success', 'Kursus berhasil ditambahkan.');
    }

    public function show(Course $course)
    {
        $course->load(['programCategory','jenjang','subProgram','meetings' => fn($q) => $q->orderBy('pertemuan_ke')]);

        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $course->load(['meetings' => fn($q) => $q->orderBy('pertemuan_ke')]);

        return view('admin.courses.edit', [
            'course' => $course,
            'categories' => ProgramCategory::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get(),
            'jenjangs' => Jenjang::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get(),
            'subPrograms' => SubProgram::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'program_category_id' => ['required','integer'],
            'jenjang_id' => ['required','integer'],
            'sub_program_id' => ['required','integer'],

            'nama_kursus' => ['required','string','max:255'],
            'periode_waktu' => ['nullable','string','max:255'],
            'level' => ['nullable','string','max:100'],
            'total_pertemuan' => ['required','integer','min:1'],
            'durasi_menit' => ['nullable','integer','min:1'],
            'pelaksanaan' => ['nullable','string','max:100'],
            'mendapatkan_sertifikat' => ['nullable','boolean'],
            'deskripsi_program' => ['nullable','string'],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],

            // ✅ foto
            'foto_kursus' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'hapus_foto' => ['nullable','boolean'],
        ]);

        $data['mendapatkan_sertifikat'] = (bool) ($request->boolean('mendapatkan_sertifikat'));
        $data['is_active'] = (bool) ($request->boolean('is_active'));

        // ✅ hapus foto jika dicentang
        if ($request->boolean('hapus_foto') && $course->foto_kursus_path) {
            Storage::disk('public')->delete($course->foto_kursus_path);
            $data['foto_kursus_path'] = null;
        }

        // ✅ jika upload foto baru: hapus lama, simpan baru
        if ($request->hasFile('foto_kursus')) {
            if ($course->foto_kursus_path) {
                Storage::disk('public')->delete($course->foto_kursus_path);
            }
            $data['foto_kursus_path'] = $request->file('foto_kursus')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses.show', $course)->with('success', 'Kursus berhasil diupdate.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil dihapus.');
    }
}
