<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'program_category_id',
        'jenjang_id',
        'sub_program_id',
        'nama_kursus',
        'foto_kursus_path',
        'periode_waktu',
        'level',
        'total_pertemuan',
        'durasi_menit',
        'pelaksanaan',
        'mendapatkan_sertifikat',
        'deskripsi_program',
        'is_active',
        'sort_order',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'mendapatkan_sertifikat' => 'boolean',
        'sort_order' => 'integer',
        'total_pertemuan' => 'integer',
        'durasi_menit' => 'integer',
    ];

    /* =========================
     | Relationships
     ========================= */

    // Admin: with('programCategory')
    public function programCategory()
    {
        return $this->belongsTo(ProgramCategory::class, 'program_category_id');
    }

    // Alias untuk halaman publik (controller/view yang pakai "category")
    public function category()
    {
        return $this->belongsTo(ProgramCategory::class, 'program_category_id');
    }

    // Jenjang
    public function jenjang()
    {
        // kalau model kamu memang bernama `jenjang` (lowercase), biarkan:
        return $this->belongsTo(jenjang::class, 'jenjang_id');

        // kalau model kamu sebenarnya `Jenjang` (PascalCase), pakai ini:
        // return $this->belongsTo(Jenjang::class, 'jenjang_id');
    }

    // Alias untuk halaman publik yang pakai "level"
    public function level()
    {
        return $this->belongsTo(jenjang::class, 'jenjang_id');
        // atau Jenjang::class kalau model kamu PascalCase
    }

    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class, 'sub_program_id');
    }

    // Dipakai di Admin\CourseController@show -> load('meetings')
    public function meetings()
    {
        return $this->hasMany(\App\Models\CourseMeeting::class, 'course_id')
            ->orderBy('pertemuan_ke')
            ->orderBy('sort_order');
    }

    /* =========================
     | Accessors
     ========================= */

    // Kompatibilitas: blade kamu pakai $course->cover_url
    public function getCoverUrlAttribute()
    {
        $path = $this->foto_kursus_path;

        if (!$path) return asset('img/placeholder/course-cover.png');

        // kalau sudah URL
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;

        // kalau path public assets/img
        if (
            str_starts_with($path, 'assets/') || str_starts_with($path, 'img/') ||
            str_starts_with($path, '/assets/') || str_starts_with($path, '/img/')
        ) {
            return asset(ltrim($path, '/'));
        }

        // IMPORTANT: file kamu disimpan ke disk 'public'
        return Storage::disk('public')->url($path);
    }

    // Kompatibilitas: blade kamu pakai $course->nama
    public function getNamaAttribute()
    {
        return $this->nama_kursus;
    }

    // Kompatibilitas: ada kode lama yang pakai $course->name
    public function getNameAttribute()
    {
        return $this->nama_kursus;
    }

    // Kompatibilitas: blade kamu pakai $course->description
    public function getDescriptionAttribute()
    {
        return $this->deskripsi_program;
    }
}
