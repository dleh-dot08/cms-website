<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'jenis',
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'gambar_utama_path',
        'status',
        'published_at',
        'user_id',
        'ditampilkan_di_beranda',
        'sort_order',
    ];

    protected $casts = [
        'ditampilkan_di_beranda' => 'boolean',
        'published_at' => 'datetime',
    ];

    public const JENIS_BLOG = 'blog';
    public const JENIS_NEWS = 'news';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    // Optional helper: buat slug unik
    public static function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $base = Str::slug($judul);
        $slug = $base;
        $i = 2;

        while (static::query()
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
