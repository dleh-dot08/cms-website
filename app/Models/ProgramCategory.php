<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramCategory extends Model
{
    protected $fillable = ['nama','sort_order','is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jenjangs() { return $this->hasMany(Jenjang::class); }
    public function subPrograms() { return $this->hasMany(SubProgram::class); }
    public function courses() { return $this->hasMany(Course::class); }
}
