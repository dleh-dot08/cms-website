<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\RecruitmentJob;
use App\Models\Division;
use App\Models\WorkType;
use App\Models\Location;
use App\Models\Tag;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $q         = trim((string) $request->get('q'));
        $division  = $request->get('division');
        $workType  = $request->get('work_type');
        $location  = $request->get('location');
        $tag       = $request->get('tag');

        $query = RecruitmentJob::query()
            ->with(['division','workType','location','tags'])
            ->where('status', 'open')
            // published_at: boleh null (langsung tampil), atau sudah waktunya tayang
            ->where(function ($w) {
                $w->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            // deadline: boleh null, atau belum lewat
            ->where(function ($w) {
                $w->whereNull('deadline_at')
                  ->orWhere('deadline_at', '>=', now()->toDateString());
            });

        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                  ->orWhere('ringkasan', 'like', "%{$q}%")
                  ->orWhere('deskripsi_role', 'like', "%{$q}%")
                  ->orWhere('jobdesk_detail', 'like', "%{$q}%");
            });
        }

        if ($division) $query->where('division_id', $division);
        if ($workType) $query->where('work_type_id', $workType);
        if ($location) $query->where('location_id', $location);

        if ($tag) {
            $query->whereHas('tags', fn($t) => $t->where('tags.id', $tag));
        }

        $jobs = $query
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('public.careers.index', [
            'jobs'      => $jobs,
            'divisions' => Division::orderBy('sort_order')->orderBy('nama')->get(),
            'workTypes' => WorkType::orderBy('sort_order')->orderBy('nama')->get(),
            'locations' => Location::orderBy('sort_order')->orderBy('nama')->get(),
            'tags'      => Tag::orderBy('sort_order')->orderBy('nama')->get(),
        ]);
    }

    public function show(RecruitmentJob $job)
    {
        // public hanya boleh lihat yang open
        abort_if($job->status !== 'open', 404);

        // published_at di masa depan => belum tampil
        if ($job->published_at && $job->published_at->isFuture()) abort(404);

        // deadline lewat => (opsional) sembunyikan
        if ($job->deadline_at && $job->deadline_at->lt(now()->toDateString())) abort(404);

        $job->load(['division','workType','location','tags']);

        return view('public.careers.show', compact('job'));
    }
}
