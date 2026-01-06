<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('sort_order')->orderBy('nama')->paginate(15);
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255','unique:locations,nama'],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['is_active'] = (bool) $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        Location::create($data);

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'nama' => ['required','string','max:255','unique:locations,nama,'.$location->id],
            'is_active' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['is_active'] = (bool) $request->boolean('is_active');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $location->update($data);

        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil diupdate.');
    }

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->route('admin.locations.index')->with('success', 'Lokasi berhasil dihapus.');
    }

    public function show(Location $location)
    {
        return redirect()->route('admin.locations.edit', $location);
    }
}
