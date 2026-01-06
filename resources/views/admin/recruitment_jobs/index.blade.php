<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Recruitment Jobs</h2>
                <p class="mt-1 text-sm text-gray-700 font-medium">Kelola lowongan kerja. Gunakan filter untuk memudahkan pencarian.</p>
            </div>
            <a href="{{ route('admin.recruitment_jobs.create') }}"
               class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                + Tambah Lowongan
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-semibold text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            {{-- FILTER --}}
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.recruitment_jobs.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide">Search</label>
                            <input type="text" name="q" value="{{ request('q') }}"
                                   placeholder="Cari judul / ringkasan..."
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide">Status</label>
                            <select name="status" class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua</option>
                                @foreach(['draft' => 'Draft', 'open' => 'Open', 'closed' => 'Closed'] as $k => $v)
                                    <option value="{{ $k }}" @selected(request('status') === $k)>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide">Divisi</label>
                            <select name="division_id" class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua</option>
                                @foreach($divisions as $d)
                                    <option value="{{ $d->id }}" @selected((string)request('division_id') === (string)$d->id)>{{ $d->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide">Tipe Kerja</label>
                            <select name="work_type_id" class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua</option>
                                @foreach($workTypes as $wt)
                                    <option value="{{ $wt->id }}" @selected((string)request('work_type_id') === (string)$wt->id)>{{ $wt->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide">Lokasi</label>
                            <select name="location_id" class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua</option>
                                @foreach($locations as $l)
                                    <option value="{{ $l->id }}" @selected((string)request('location_id') === (string)$l->id)>{{ $l->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide">Tag</label>
                            <select name="tag_ids" class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua</option>
                                @foreach($tags as $t)
                                    <option value="{{ $t->id }}" @selected((string)request('tag_ids') === (string)$t->id)>{{ $t->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-4 flex items-end gap-2">
                            <button type="submit"
                                    class="px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-semibold hover:bg-black">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('admin.recruitment_jobs.index') }}"
                               class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold hover:bg-gray-300">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- LIST --}}
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 text-gray-900">
                                    <th class="py-3 pr-4 text-left font-bold">Cover</th>
                                    <th class="py-3 pr-4 text-left font-bold">Judul</th>
                                    <th class="py-3 pr-4 text-left font-bold">Meta</th>
                                    <th class="py-3 pr-4 text-left font-bold">Status</th>
                                    <th class="py-3 pr-4 text-left font-bold">Deadline</th>
                                    <th class="py-3 text-right font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($jobs as $job)
                                    <tr class="text-gray-900">
                                        <td class="py-3 pr-4">
                                            @if($job->cover_image_url)
                                                <img src="{{ $job->cover_image_url }}"
                                                     alt="cover"
                                                     class="w-16 h-12 object-cover rounded border border-gray-200">
                                            @else
                                                <div class="w-16 h-12 rounded border border-gray-200 bg-gray-100 flex items-center justify-center text-xs text-gray-600 font-semibold">
                                                    No Image
                                                </div>
                                            @endif
                                        </td>

                                        <td class="py-3 pr-4">
                                            <div class="font-semibold text-gray-900">{{ $job->judul }}</div>
                                            <div class="text-xs text-gray-700 font-medium mt-1">{{ $job->slug }}</div>
                                            @if($job->ringkasan)
                                                <div class="text-xs text-gray-700 mt-2 line-clamp-2">
                                                    {{ \Illuminate\Support\Str::limit($job->ringkasan, 110) }}
                                                </div>
                                            @endif
                                        </td>

                                        <td class="py-3 pr-4 text-xs text-gray-800 font-medium">
                                            <div>Divisi: <span class="font-semibold">{{ $job->division?->nama }}</span></div>
                                            <div>Tipe: <span class="font-semibold">{{ $job->workType?->nama }}</span></div>
                                            <div>Lokasi: <span class="font-semibold">{{ $job->location?->nama }}</span></div>
                                            @if($job->tags && $job->tags->count())
                                                <div class="mt-2 flex flex-wrap gap-1">
                                                    @foreach($job->tags as $tg)
                                                        <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-800 text-[11px] font-bold border border-indigo-100">
                                                            {{ $tg->nama }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>

                                        <td class="py-3 pr-4">
                                            @php
                                                $badge = match($job->status) {
                                                    'open' => 'bg-green-100 text-green-800',
                                                    'closed' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-200 text-gray-900',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-1 rounded font-bold {{ $badge }}">
                                                {{ strtoupper($job->status) }}
                                            </span>
                                            @if($job->is_featured)
                                                <div class="mt-2">
                                                    <span class="inline-flex items-center px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs font-bold">
                                                        Featured
                                                    </span>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="py-3 pr-4 text-sm text-gray-900 font-semibold">
                                            {{ $job->deadline_at ? $job->deadline_at->format('d M Y') : '-' }}
                                        </td>

                                        <td class="py-3 text-right">
                                            <div class="inline-flex items-center gap-2">
                                                <a href="{{ route('admin.recruitment_jobs.show', $job) }}"
                                                   class="px-3 py-1.5 rounded-md bg-gray-900 text-white font-semibold hover:bg-black">
                                                    Show
                                                </a>
                                                <a href="{{ route('admin.recruitment_jobs.edit', $job) }}"
                                                   class="px-3 py-1.5 rounded-md bg-gray-200 text-gray-900 font-semibold hover:bg-gray-300">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.recruitment_jobs.destroy', $job) }}"
                                                      onsubmit="return confirm('Yakin hapus lowongan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-3 py-1.5 rounded-md bg-red-600 text-white font-semibold hover:bg-red-700">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-700 font-medium">
                                            Belum ada data lowongan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
