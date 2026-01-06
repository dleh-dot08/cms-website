<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenjang;
use App\Models\ProgramCategory;
use Illuminate\Http\Request;

class JenjangController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $programCategoryId = $request->get('program_category_id');

        $categories = ProgramCategory::orderBy('sort_order')->orderBy('nama')->get();

        $items = Jenjang::query()
            ->with('programCategory')
            ->when($q, fn($qr) => $qr->where('nama','like',"%{$q}%"))
            ->when($programCategoryId, fn($qr) => $qr->where('program_category_id', $programCategoryId))
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('admin.jenjangs.index', compact('items','q','programCategoryId','categories'));
    }

    public function create()
    {
        return view('admin.jenjangs.create', [
            'categories' => ProgramCategory::orderBy('sort_order')->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'program_category_id' => ['required','exists:program_categories,id'],
            'nama' => ['required','string','max:255'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        Jenjang::create($data);

        return redirect()->route('admin.jenjangs.index')->with('success','Jenjang berhasil ditambahkan.');
    }

    public function show(Jenjang $jenjang)
    {
        $jenjang->load('programCategory');

        return view('admin.jenjangs.show', compact('jenjang'));
    }

    public function edit(Jenjang $jenjang)
    {
        return view('admin.jenjangs.edit', [
            'jenjang' => $jenjang,
            'categories' => ProgramCategory::orderBy('sort_order')->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Jenjang $jenjang)
    {
        $data = $request->validate([
            'program_category_id' => ['required','exists:program_categories,id'],
            'nama' => ['required','string','max:255'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        $jenjang->update($data);

        return back()->with('success','Jenjang berhasil diupdate.');
    }

    public function destroy(Jenjang $jenjang)
    {
        $jenjang->delete();
        return back()->with('success','Jenjang berhasil dihapus.');
    }
}
