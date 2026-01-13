<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));

        // ✅ status kamu di DB = 'publish'
        $publishedStatuses = ['publish', 'published'];

        $query = Post::query()
            ->where('jenis', 'news')
            ->whereIn('status', $publishedStatuses)
            ->where(function ($w) {
                // ✅ published_at boleh null, atau <= sekarang
                $w->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });

        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                  ->orWhere('ringkasan', 'like', "%{$q}%")
                  ->orWhere('konten', 'like', "%{$q}%");
            });
        }

        $posts = $query
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('public.news.index', compact('posts', 'q'));
    }

    public function show(Post $post)
    {
        if ($post->jenis !== 'news') abort(404);

        $publishedStatuses = ['publish', 'published'];
        if (!in_array($post->status, $publishedStatuses, true)) abort(404);

        if ($post->published_at && $post->published_at->isFuture()) abort(404);

        return view('public.news.show', compact('post'));
    }
}
