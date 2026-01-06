<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function recruitmentJobs()
    {
        return $this->hasMany(RecruitmentJob::class);
    }
}
