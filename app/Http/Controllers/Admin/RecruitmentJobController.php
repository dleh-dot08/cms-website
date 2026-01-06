<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Location;
use App\Models\RecruitmentJob;
use App\Models\Tag;
use App\Models\WorkType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecruitmentJobController extends Controller
{
    private function parseLinesToArray($value): ?array
    {
        if (is_array($value)) {
            $items = array_values(array_filter(array_map('trim', $value)));
            return $items ?: null;
        }

        if (!is_string($value) || trim($value) === '') return null;

        $lines = preg_split("/\r\n|\n|\r/", $value);
        $items = array_values(array_filter(array_map('trim', $lines)));
        return $items ?: null;
    }

    private function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $slug = Str::slug($judul);
        if ($slug === '') $slug = 'job';

        $base = $slug;
        $i = 2;

        $q = RecruitmentJob::query()->where('slug', $slug);
        if ($ignoreId) $q->where('id', '!=', $ignoreId);

        while ($q->exists()) {
            $slug = $base.'-'.$i;
            $i++;

            $q = RecruitmentJob::query()->where('slug', $slug);
            if ($ignoreId) $q->where('id', '!=', $ignoreId);
        }

        return $slug;
    }

    public function index(Request $request)
    {
        $query = RecruitmentJob::query()
            ->with(['division','workType','location','tags','author'])
            ->orderByDesc('updated_at');

        // filters
        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                  ->orWhere('ringkasan', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('division_id')) {
            $query->where('division_id', (int) $request->division_id);
        }

        if ($request->filled('work_type_id')) {
            $query->where('work_type_id', (int) $request->work_type_id);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', (int) $request->location_id);
        }

        // tag filter (support single or multiple)
        $tagIds = $request->input('tag_ids');
        if ($tagIds) {
            $ids = is_array($tagIds) ? $tagIds : [$tagIds];
            $ids = array_values(array_filter(array_map('intval', $ids)));

            if (!empty($ids)) {
                $query->whereHas('tags', function ($t) use ($ids) {
                    $t->whereIn('tags.id', $ids);
                });
            }
        }

        $jobs = $query->paginate(15)->withQueryString();

        // dropdown data untuk filter
        $divisions = Division::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();
        $workTypes = WorkType::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();
        $locations = Location::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();
        $tags = Tag::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();

        return view('admin.recruitment_jobs.index', compact('jobs','divisions','workTypes','locations','tags'));
    }

    public function create()
    {
        $divisions = Division::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();
        $workTypes = WorkType::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();
        $locations = Location::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();
        $tags = Tag::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();

        return view('admin.recruitment_jobs.create', compact('divisions','workTypes','locations','tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'division_id' => ['required','integer','exists:divisions,id'],
            'work_type_id' => ['required','integer','exists:work_types,id'],
            'location_id' => ['required','integer','exists:locations,id'],

            'judul' => ['required','string','max:255'],
            'ringkasan' => ['nullable','string'],

            'deskripsi_role' => ['nullable','string'],
            'jobdesk_detail' => ['nullable','string'],
            'kualifikasi_detail' => ['nullable','string'],

            // bisa textarea (string) atau array
            'responsibilities' => ['nullable'],
            'requirements' => ['nullable'],
            'benefits' => ['nullable'],

            'salary_min' => ['nullable','integer','min:0'],
            'salary_max' => ['nullable','integer','min:0'],
            'salary_note' => ['nullable','string','max:255'],

            'deadline_at' => ['nullable','date'],
            'status' => ['required','in:draft,open,closed'],

            'apply_type' => ['required','in:link,email,whatsapp,ats'],
            'apply_value' => ['nullable','string','max:500'],

            'dokumen_diminta' => ['nullable'],

            'pic_name' => ['nullable','string','max:255'],
            'pic_contact' => ['nullable','string','max:255'],

            // cover upload
            'cover_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],

            'is_featured' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],

            // tag multi
            'tag_ids' => ['nullable','array'],
            'tag_ids.*' => ['integer','exists:tags,id'],
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['judul']);
        $data['responsibilities'] = $this->parseLinesToArray($request->input('responsibilities'));
        $data['requirements'] = $this->parseLinesToArray($request->input('requirements'));
        $data['benefits'] = $this->parseLinesToArray($request->input('benefits'));
        $data['dokumen_diminta'] = $this->parseLinesToArray($request->input('dokumen_diminta'));

        $data['is_featured'] = (bool) $request->boolean('is_featured');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        // published_at auto
        if ($data['status'] === 'open') {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = null;
        }

        // upload cover
        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('recruitment', 'public');
        }

        $data['user_id'] = auth()->id();

        $job = RecruitmentJob::create($data);

        // sync tags
        $job->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.recruitment_jobs.show', $job)
            ->with('success', 'Lowongan berhasil dibuat.');
    }

    public function show(RecruitmentJob $job)
    {
        $job->load(['division','workType','location','tags','author']);
        return view('admin.recruitment_jobs.show', compact('job'));
    }

    public function edit(RecruitmentJob $job)
    {
        $divisions = Division::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();
        $workTypes = WorkType::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();
        $locations = Location::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();
        $tags = Tag::where('is_active', true)->orderBy('sort_order')->orderBy('nama')->get();

        $job->load('tags');

        return view('admin.recruitment_jobs.edit', compact('job','divisions','workTypes','locations','tags'));
    }

    public function update(Request $request, RecruitmentJob $job)
    {
        $data = $request->validate([
            'division_id' => ['required','integer','exists:divisions,id'],
            'work_type_id' => ['required','integer','exists:work_types,id'],
            'location_id' => ['required','integer','exists:locations,id'],

            'judul' => ['required','string','max:255'],
            'ringkasan' => ['nullable','string'],

            'deskripsi_role' => ['nullable','string'],
            'jobdesk_detail' => ['nullable','string'],
            'kualifikasi_detail' => ['nullable','string'],

            'responsibilities' => ['nullable'],
            'requirements' => ['nullable'],
            'benefits' => ['nullable'],

            'salary_min' => ['nullable','integer','min:0'],
            'salary_max' => ['nullable','integer','min:0'],
            'salary_note' => ['nullable','string','max:255'],

            'deadline_at' => ['nullable','date'],
            'status' => ['required','in:draft,open,closed'],

            'apply_type' => ['required','in:link,email,whatsapp,ats'],
            'apply_value' => ['nullable','string','max:500'],

            'dokumen_diminta' => ['nullable'],

            'pic_name' => ['nullable','string','max:255'],
            'pic_contact' => ['nullable','string','max:255'],

            'cover_image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'hapus_cover' => ['nullable','boolean'],

            'is_featured' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],

            'tag_ids' => ['nullable','array'],
            'tag_ids.*' => ['integer','exists:tags,id'],
        ]);

        // slug update kalau judul berubah
        if ($data['judul'] !== $job->judul) {
            $data['slug'] = $this->generateUniqueSlug($data['judul'], $job->id);
        }

        $data['responsibilities'] = $this->parseLinesToArray($request->input('responsibilities'));
        $data['requirements'] = $this->parseLinesToArray($request->input('requirements'));
        $data['benefits'] = $this->parseLinesToArray($request->input('benefits'));
        $data['dokumen_diminta'] = $this->parseLinesToArray($request->input('dokumen_diminta'));

        $data['is_featured'] = (bool) $request->boolean('is_featured');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        // published_at logic
        if ($data['status'] === 'open' && !$job->published_at) {
            $data['published_at'] = now();
        }
        if ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        // hapus cover
        if ($request->boolean('hapus_cover') && $job->cover_image_path) {
            Storage::disk('public')->delete($job->cover_image_path);
            $data['cover_image_path'] = null;
        }

        // upload cover baru
        if ($request->hasFile('cover_image')) {
            if ($job->cover_image_path) {
                Storage::disk('public')->delete($job->cover_image_path);
            }
            $data['cover_image_path'] = $request->file('cover_image')->store('recruitment', 'public');
        }

        $job->update($data);

        $job->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.recruitment_jobs.show', $job)
            ->with('success', 'Lowongan berhasil diupdate.');
    }

    public function destroy(RecruitmentJob $job)
    {
        if ($job->cover_image_path) {
            Storage::disk('public')->delete($job->cover_image_path);
        }

        $job->delete();

        return redirect()->route('admin.recruitment_jobs.index')
            ->with('success', 'Lowongan berhasil dihapus.');
    }
}
