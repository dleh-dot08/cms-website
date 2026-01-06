<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkType;
use Illuminate\Http\Request;

class WorkTypeController extends Controller
{
    public function index()
    {
        $workTypes = WorkType::orderBy('sort_order')->orderBy('nama')->paginate(15);
        return view('admin.work_types.index', compact('workTypes'));
    }

    public function create()
    {
        return view('admin.work_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255','unique:work_types,nama'],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['is_active'] = (bool) $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        WorkType::create($data);

        return redirect()->route('admin.work_types.index')->with('success', 'Tipe kerja berhasil ditambahkan.');
    }

    public function edit(WorkType $workType)
    {
        return view('admin.work_types.edit', compact('workType'));
    }

    public function update(Request $request, WorkType $workType)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255','unique:work_types,nama,'.$workType->id],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['is_active'] = (bool) $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $workType->update($data);

        return redirect()->route('admin.work_types.index')->with('success', 'Tipe kerja berhasil diupdate.');
    }

    public function destroy(WorkType $workType)
    {
        $workType->delete();
        return redirect()->route('admin.work_types.index')->with('success', 'Tipe kerja berhasil dihapus.');
    }

    public function show(WorkType $workType)
    {
        return redirect()->route('admin.work_types.edit', $workType);
    }
}
