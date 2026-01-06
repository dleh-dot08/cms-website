<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $jenis = $request->get('jenis'); // blog|news|null

        $items = Category::query()
            ->when($q, fn($query) =>
                $query->where('nama', 'like', "%{$q}%")
                      ->orWhere('slug', 'like', "%{$q}%")
            )
            ->when($jenis !== null && $jenis !== '', fn($query) => $query->where('jenis', $jenis))
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('admin.categories.index', [
            'items' => $items,
            'q' => $q,
            'jenis' => $jenis,
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jenis' => ['nullable', 'in:blog,news'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        $data['slug'] = $this->generateUniqueSlug($data['nama']);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        $postsCount = $category->posts()->count();

        return view('admin.categories.show', [
            'category' => $category,
            'postsCount' => $postsCount,
        ]);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jenis' => ['nullable', 'in:blog,news'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        // Update slug jika nama berubah
        if ($data['nama'] !== $category->nama) {
            $data['slug'] = $this->generateUniqueSlug($data['nama'], $category->id);
        }

        $category->update($data);

        return back()->with('success', 'Category berhasil diupdate.');
    }

    public function destroy(Category $category)
    {
        // Pivot akan otomatis terhapus karena FK cascade (category_post)
        $category->delete();

        return back()->with('success', 'Category berhasil dihapus.');
    }

    private function generateUniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $base = Str::slug($nama);
        $slug = $base;
        $i = 2;

        while (
            Category::query()
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
