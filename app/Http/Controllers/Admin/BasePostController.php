<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

abstract class BasePostController extends Controller
{
    protected string $jenis;
    protected string $label;
    protected string $routeBase;

    public function index(Request $request)
    {
        $q = $request->get('q');
        $status = $request->get('status'); // draft/published/null

        $items = Post::query()
            ->where('jenis', $this->jenis)
            ->when($q, function ($query) use ($q) {
                $query->where('judul', 'like', "%{$q}%")
                      ->orWhere('slug', 'like', "%{$q}%");
            })
            ->when($status, fn($query) => $query->where('status', $status))
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.posts.index', [
            'items' => $items,
            'label' => $this->label,
            'routeBase' => $this->routeBase,
            'q' => $q,
            'status' => $status,
        ]);
    }

    public function create()
    {
        $categories = Category::query()
            ->where(function ($q) {
                $q->whereNull('jenis')->orWhere('jenis', $this->jenis);
            })
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->get();

        return view('admin.posts.create', [
            'label' => $this->label,
            'routeBase' => $this->routeBase,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => ['required','string','max:255'],
            'ringkasan' => ['nullable','string'],
            'konten' => ['required','string'],

            'gambar_utama' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],

            'status' => ['required','in:'.Post::STATUS_DRAFT.','.Post::STATUS_PUBLISHED],
            'published_at' => ['nullable','date'],

            'ditampilkan_di_beranda' => ['nullable'],
            'sort_order' => ['nullable','integer','min:0'],

            'categories' => ['nullable','array'],
            'categories.*' => ['integer','exists:categories,id'],
        ]);

        $data['jenis'] = $this->jenis;
        $data['user_id'] = auth()->id();

        $data['slug'] = Post::generateUniqueSlug($data['judul']);

        $data['ditampilkan_di_beranda'] = $request->boolean('ditampilkan_di_beranda');
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        // published_at rule:
        if ($data['status'] === Post::STATUS_PUBLISHED && empty($data['published_at'])) {
            $data['published_at'] = now();
        }
        if ($data['status'] === Post::STATUS_DRAFT) {
            $data['published_at'] = null;
        }

        if ($request->hasFile('gambar_utama')) {
            $data['gambar_utama_path'] = $request->file('gambar_utama')->store('posts', 'public');
        }

        $post = Post::create($data);

        // categories sync
        $post->categories()->sync($data['categories'] ?? []);

        return redirect()->route($this->routeBase.'.index')->with('success', $this->label.' berhasil ditambahkan.');
    }

    public function edit(Post $post)
    {
        abort_unless($post->jenis === $this->jenis, 404);

        $categories = Category::query()
            ->where(function ($q) {
                $q->whereNull('jenis')->orWhere('jenis', $this->jenis);
            })
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->get();

        $selectedCategoryIds = $post->categories()->pluck('categories.id')->toArray();

        return view('admin.posts.edit', [
            'post' => $post,
            'label' => $this->label,
            'routeBase' => $this->routeBase,
            'categories' => $categories,
            'selectedCategoryIds' => $selectedCategoryIds,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        abort_unless($post->jenis === $this->jenis, 404);

        $data = $request->validate([
            'judul' => ['required','string','max:255'],
            'ringkasan' => ['nullable','string'],
            'konten' => ['required','string'],

            'gambar_utama' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],

            'status' => ['required','in:'.Post::STATUS_DRAFT.','.Post::STATUS_PUBLISHED],
            'published_at' => ['nullable','date'],

            'ditampilkan_di_beranda' => ['nullable'],
            'sort_order' => ['nullable','integer','min:0'],

            'categories' => ['nullable','array'],
            'categories.*' => ['integer','exists:categories,id'],
        ]);

        // Update slug jika judul berubah
        if ($data['judul'] !== $post->judul) {
            $data['slug'] = Post::generateUniqueSlug($data['judul'], $post->id);
        }

        $data['ditampilkan_di_beranda'] = $request->boolean('ditampilkan_di_beranda');
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        if ($data['status'] === Post::STATUS_PUBLISHED && empty($data['published_at'])) {
            $data['published_at'] = $post->published_at ?? now();
        }
        if ($data['status'] === Post::STATUS_DRAFT) {
            $data['published_at'] = null;
        }

        if ($request->hasFile('gambar_utama')) {
            if (!empty($post->gambar_utama_path)) {
                Storage::disk('public')->delete($post->gambar_utama_path);
            }
            $data['gambar_utama_path'] = $request->file('gambar_utama')->store('posts', 'public');
        }

        $post->update($data);
        $post->categories()->sync($data['categories'] ?? []);

        return back()->with('success', $this->label.' berhasil diupdate.');
    }

    public function destroy(Post $post)
    {
        abort_unless($post->jenis === $this->jenis, 404);

        if (!empty($post->gambar_utama_path)) {
            Storage::disk('public')->delete($post->gambar_utama_path);
        }

        $post->categories()->detach();
        $post->delete();

        return back()->with('success', $this->label.' berhasil dihapus.');
    }

    public function show(Post $post)
    {
        abort_unless($post->jenis === $this->jenis, 404);

        $post->load(['author', 'categories']);

        return view('admin.posts.show', [
            'post' => $post,
            'label' => $this->label,
            'routeBase' => $this->routeBase,
        ]);
    }
}
