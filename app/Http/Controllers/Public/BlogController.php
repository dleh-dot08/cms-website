<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));

        // status di DB kamu = "publish"
        $publishedStatuses = ['publish', 'published'];

        $query = Post::query()
            ->where('jenis', 'blog')
            ->whereIn('status', $publishedStatuses)
            ->where(function ($w) {
                // published_at boleh null (anggap langsung tampil) atau <= sekarang
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

        return view('public.blog.index', compact('posts', 'q'));
    }

    public function show(Post $post)
    {
        // pastikan ini blog
        if ($post->jenis !== 'blog') abort(404);

        $publishedStatuses = ['publish', 'published'];
        if (!in_array($post->status, $publishedStatuses, true)) abort(404);

        if ($post->published_at && $post->published_at->isFuture()) abort(404);

        return view('public.blog.show', compact('post'));
    }
}
