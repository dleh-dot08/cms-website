<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMeeting extends Model
{
    use HasFactory;

    protected $table = 'course_meetings';

    protected $fillable = [
        'course_id',
        'pertemuan_ke',
        'judul',
        'materi_singkat',
        'materi_detail',
        'durasi_menit',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'course_id' => 'integer',
        'pertemuan_ke' => 'integer',
        'durasi_menit' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
