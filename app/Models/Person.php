<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';

    protected $fillable = [
        'type',
        'name',
        'title',
        'bio',
        'foto_path',
        'ditampilkan_di_beranda',
        'sort_order',
        'is_active',
    ];

    public const TYPE_OFFICER = 'officer';
    public const TYPE_INTERN  = 'intern';
    public const TYPE_MENTOR  = 'mentor';
}

