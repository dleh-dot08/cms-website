<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramCategory;
use App\Models\SubProgram;
use Illuminate\Http\Request;

class SubProgramController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $programCategoryId = $request->get('program_category_id');

        $categories = ProgramCategory::orderBy('sort_order')->orderBy('nama')->get();

        $items = SubProgram::query()
            ->with('programCategory')
            ->when($q, fn($qr) => $qr->where('nama','like',"%{$q}%"))
            ->when($programCategoryId, fn($qr) => $qr->where('program_category_id', $programCategoryId))
            ->orderBy('sort_order')
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('admin.sub_programs.index', compact('items','q','programCategoryId','categories'));
    }

    public function create()
    {
        return view('admin.sub_programs.create', [
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

        SubProgram::create($data);

        return redirect()->route('admin.sub_programs.index')->with('success','Sub Program berhasil ditambahkan.');
    }

    public function show(SubProgram $subProgram)
    {
        $subProgram->load('programCategory');

        return view('admin.sub_programs.show', compact('subProgram'));
    }

    public function edit(SubProgram $subProgram)
    {
        return view('admin.sub_programs.edit', [
            'subProgram' => $subProgram,
            'categories' => ProgramCategory::orderBy('sort_order')->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, SubProgram $subProgram)
    {
        $data = $request->validate([
            'program_category_id' => ['required','exists:program_categories,id'],
            'nama' => ['required','string','max:255'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        $subProgram->update($data);

        return back()->with('success','Sub Program berhasil diupdate.');
    }

    public function destroy(SubProgram $subProgram)
    {
        $subProgram->delete();
        return back()->with('success','Sub Program berhasil dihapus.');
    }
}
