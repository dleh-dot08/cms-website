<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::orderBy('sort_order')->orderBy('nama')->paginate(15);
        return view('admin.divisions.index', compact('divisions'));
    }

    public function create()
    {
        return view('admin.divisions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255','unique:divisions,nama'],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['is_active'] = (bool) $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        Division::create($data);

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function edit(Division $division)
    {
        return view('admin.divisions.edit', compact('division'));
    }

    public function update(Request $request, Division $division)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255','unique:divisions,nama,'.$division->id],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['is_active'] = (bool) $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $division->update($data);

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil diupdate.');
    }

    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil dihapus.');
    }

    public function show(Division $division)
    {
        return redirect()->route('admin.divisions.edit', $division);
    }
}
