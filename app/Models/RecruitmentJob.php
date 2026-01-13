<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class RecruitmentJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'work_type_id',
        'location_id',

        'judul',
        'slug',
        'ringkasan',

        'deskripsi_role',
        'jobdesk_detail',
        'kualifikasi_detail',

        'responsibilities',
        'requirements',
        'benefits',

        'salary_min',
        'salary_max',
        'salary_note',

        'deadline_at',
        'status',
        'published_at',

        'apply_type',
        'apply_value',

        'dokumen_diminta',
        'pic_name',
        'pic_contact',

        'cover_image_path',
        'is_featured',
        'sort_order',

        'user_id',
    ];

    protected $casts = [
        'responsibilities' => 'array',
        'requirements' => 'array',
        'benefits' => 'array',
        'dokumen_diminta' => 'array',

        'deadline_at' => 'date',
        'published_at' => 'datetime',

        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'salary_min' => 'integer',
        'salary_max' => 'integer',
    ];

    // ===== RELATIONS =====
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function workType()
    {
        return $this->belongsTo(WorkType::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'job_tag');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ===== ACCESSOR (URL cover) =====
    public function getCoverImageUrlAttribute(): ?string
    {
        if (!$this->cover_image_path) return null;
        return Storage::disk('public')->url($this->cover_image_path);
    }

    // ===== HELPERS =====
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }
    
}
