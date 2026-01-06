<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'program_category_id','jenjang_id','sub_program_id',
        'nama_kursus','foto_kursus_path','periode_waktu','level','total_pertemuan',
        'durasi_menit','pelaksanaan','mendapatkan_sertifikat',
        'deskripsi_program','is_active','sort_order','user_id',
    ];

    protected $casts = [
        'mendapatkan_sertifikat' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function programCategory() { return $this->belongsTo(ProgramCategory::class); }
    public function jenjang() { return $this->belongsTo(Jenjang::class); }
    public function subProgram() { return $this->belongsTo(SubProgram::class); }
    public function meetings() { return $this->hasMany(CourseMeeting::class); }
    public function author() { return $this->belongsTo(User::class, 'user_id'); }
}
