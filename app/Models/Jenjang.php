<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    protected $fillable = ['program_category_id','nama','sort_order','is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function programCategory() { return $this->belongsTo(ProgramCategory::class); }
}
