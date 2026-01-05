<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

abstract class BasePeopleController extends Controller
{
    protected string $type;
    protected string $label;
    protected string $routeBase;

    public function index()
    {
        $items = Person::where('type', $this->type)
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15);

        return view('admin.people.index', [
            'items' => $items,
            'label' => $this->label,
            'routeBase' => $this->routeBase,
        ]);
    }

    public function create()
    {
        return view('admin.people.create', [
            'label' => $this->label,
            'routeBase' => $this->routeBase,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'title' => ['nullable','string','max:255'],
            'bio' => ['nullable','string'],
            'foto' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'ditampilkan_di_beranda' => ['nullable'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['type'] = $this->type;
        $data['ditampilkan_di_beranda'] = $request->boolean('ditampilkan_di_beranda');
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('people', 'public');
        }

        Person::create($data);

        return redirect()->route($this->routeBase.'.index')->with('success', $this->label.' berhasil ditambahkan.');
    }

    public function edit(Person $person)
    {
        abort_unless($person->type === $this->type, 404);

        return view('admin.people.edit', [
            'person' => $person,
            'label' => $this->label,
            'routeBase' => $this->routeBase,
        ]);
    }

    public function update(Request $request, Person $person)
    {
        abort_unless($person->type === $this->type, 404);

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'title' => ['nullable','string','max:255'],
            'bio' => ['nullable','string'],
            'foto' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'ditampilkan_di_beranda' => ['nullable'],
            'sort_order' => ['nullable','integer','min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['ditampilkan_di_beranda'] = $request->boolean('ditampilkan_di_beranda');
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);

        if ($request->hasFile('foto')) {
            // hapus file lama
            if (!empty($person->foto_path)) {
                Storage::disk('public')->delete($person->foto_path);
            }
            $data['foto_path'] = $request->file('foto')->store('people', 'public');
        }

        $person->update($data);

        return back()->with('success', $this->label.' berhasil diupdate.');
    }

    public function destroy(Person $person)
    {
        abort_unless($person->type === $this->type, 404);

        $person->delete();
        return back()->with('success', $this->label.' berhasil dihapus.');
    }
}
