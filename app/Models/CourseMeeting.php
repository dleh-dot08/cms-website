<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMeeting extends Model
{
    protected $fillable = [
        'course_id','pertemuan_ke','judul','materi_singkat','materi_detail',
        'durasi_menit','is_active','sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function course() { return $this->belongsTo(Course::class); }
}
