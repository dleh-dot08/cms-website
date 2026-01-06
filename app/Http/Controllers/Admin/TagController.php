<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('sort_order')->orderBy('nama')->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255','unique:tags,nama'],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['slug'] = Str::slug($data['nama']);
        // jaga-jaga kalau slug tabrakan
        $base = $data['slug'];
        $i = 2;
        while (Tag::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $base.'-'.$i;
            $i++;
        }

        $data['is_active'] = (bool) $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        Tag::create($data);

        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil ditambahkan.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255','unique:tags,nama,'.$tag->id],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $newSlug = Str::slug($data['nama']);
        if ($newSlug !== $tag->slug) {
            $base = $newSlug;
            $i = 2;
            while (Tag::where('slug', $newSlug)->where('id','!=',$tag->id)->exists()) {
                $newSlug = $base.'-'.$i;
                $i++;
            }
            $data['slug'] = $newSlug;
        }

        $data['is_active'] = (bool) $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $tag->update($data);

        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil diupdate.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil dihapus.');
    }

    public function show(Tag $tag)
    {
        return redirect()->route('admin.tags.edit', $tag);
    }
}
