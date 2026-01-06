<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;

class ProgramCategoryController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $items = ProgramCategory::query()
            ->when($q, fn($qr) => $qr->where('nama','like',"%{$q}%"))
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('admin.program_categories.index', compact('items','q'));
    }

    public function create()
    {
        return view('admin.program_categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        ProgramCategory::create($data);

        return redirect()->route('admin.program_categories.index')->with('success','Kategori Program berhasil ditambahkan.');
    }

    public function show(ProgramCategory $programCategory)
    {
        $programCategory->loadCount(['jenjangs','subPrograms','courses']);

        return view('admin.program_categories.show', compact('programCategory'));
    }

    public function edit(ProgramCategory $programCategory)
    {
        return view('admin.program_categories.edit', compact('programCategory'));
    }

    public function update(Request $request, ProgramCategory $programCategory)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        $programCategory->update($data);

        return back()->with('success','Kategori Program berhasil diupdate.');
    }

    public function destroy(ProgramCategory $programCategory)
    {
        $programCategory->delete();
        return back()->with('success','Kategori Program berhasil dihapus.');
    }
}
