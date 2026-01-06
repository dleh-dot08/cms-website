<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Detail Lowongan</h2>
                <p class="mt-1 text-sm text-gray-700 font-medium">{{ $job->judul }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.recruitment_jobs.edit', $job) }}"
                   class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold hover:bg-gray-300">
                    Edit
                </a>
                <a href="{{ route('admin.recruitment_jobs.index') }}"
                   class="px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-semibold hover:bg-black">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-semibold text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6 space-y-6">

                    {{-- TOP --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide">Cover</label>
                            @if($job->cover_image_url)
                                <img src="{{ $job->cover_image_url }}" alt="cover"
                                     class="mt-2 w-full h-48 object-cover rounded border border-gray-200">
                            @else
                                <div class="mt-2 w-full h-48 rounded border border-gray-200 bg-gray-100 flex items-center justify-center text-sm text-gray-600 font-semibold">
                                    No Image
                                </div>
                            @endif
                        </div>

                        <div class="md:col-span-2 space-y-3">
                            <div>
                                <div class="text-sm text-gray-700 font-medium">Slug</div>
                                <div class="text-gray-900 font-semibold">{{ $job->slug }}</div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <div class="text-sm text-gray-700 font-medium">Divisi</div>
                                    <div class="text-gray-900 font-semibold">{{ $job->division?->nama }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-700 font-medium">Tipe Kerja</div>
                                    <div class="text-gray-900 font-semibold">{{ $job->workType?->nama }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-700 font-medium">Lokasi</div>
                                    <div class="text-gray-900 font-semibold">{{ $job->location?->nama }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-700 font-medium">Status</div>
                                    <div class="text-gray-900 font-semibold">{{ strtoupper($job->status) }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-700 font-medium">Deadline</div>
                                    <div class="text-gray-900 font-semibold">{{ $job->deadline_at ? $job->deadline_at->format('d M Y') : '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-700 font-medium">Featured</div>
                                    <div class="text-gray-900 font-semibold">{{ $job->is_featured ? 'Ya' : 'Tidak' }}</div>
                                </div>
                            </div>

                            @if($job->tags && $job->tags->count())
                                <div>
                                    <div class="text-sm text-gray-700 font-medium">Tag</div>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @foreach($job->tags as $tg)
                                            <span class="px-2 py-1 rounded bg-indigo-50 text-indigo-800 text-xs font-bold border border-indigo-100">
                                                {{ $tg->nama }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- RINGKASAN --}}
                    @if($job->ringkasan)
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="font-bold text-gray-900">Ringkasan</h3>
                            <p class="mt-2 text-gray-800 font-medium whitespace-pre-line">{{ $job->ringkasan }}</p>
                        </div>
                    @endif

                    {{-- NARASI --}}
                    <div class="border-t border-gray-200 pt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-bold text-gray-900">Deskripsi Role</h3>
                            <p class="mt-2 text-gray-800 font-medium whitespace-pre-line">{{ $job->deskripsi_role ?: '-' }}</p>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Detail Jobdesk</h3>
                            <p class="mt-2 text-gray-800 font-medium whitespace-pre-line">{{ $job->jobdesk_detail ?: '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <h3 class="font-bold text-gray-900">Detail Kualifikasi</h3>
                            <p class="mt-2 text-gray-800 font-medium whitespace-pre-line">{{ $job->kualifikasi_detail ?: '-' }}</p>
                        </div>
                    </div>

                    {{-- BULLETS --}}
                    <div class="border-t border-gray-200 pt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h3 class="font-bold text-gray-900">Responsibilities</h3>
                            @php $items = $job->responsibilities ?? []; @endphp
                            @if(count($items))
                                <ul class="mt-2 list-disc list-inside text-gray-800 font-medium space-y-1">
                                    @foreach($items as $it)
                                        <li>{{ $it }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-2 text-gray-700 font-medium">-</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-900">Requirements</h3>
                            @php $items = $job->requirements ?? []; @endphp
                            @if(count($items))
                                <ul class="mt-2 list-disc list-inside text-gray-800 font-medium space-y-1">
                                    @foreach($items as $it)
                                        <li>{{ $it }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-2 text-gray-700 font-medium">-</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-900">Benefits</h3>
                            @php $items = $job->benefits ?? []; @endphp
                            @if(count($items))
                                <ul class="mt-2 list-disc list-inside text-gray-800 font-medium space-y-1">
                                    @foreach($items as $it)
                                        <li>{{ $it }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-2 text-gray-700 font-medium">-</p>
                            @endif
                        </div>
                    </div>

                    {{-- APPLY + SALARY + PIC --}}
                    <div class="border-t border-gray-200 pt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h3 class="font-bold text-gray-900">Cara Melamar</h3>
                            <p class="mt-2 text-gray-800 font-medium">Tipe: <span class="font-semibold">{{ strtoupper($job->apply_type) }}</span></p>
                            <p class="mt-1 text-gray-800 font-medium break-words">
                                {{ $job->apply_value ?: '-' }}
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-900">Gaji</h3>
                            <p class="mt-2 text-gray-800 font-medium">
                                Min: <span class="font-semibold">{{ $job->salary_min ? number_format($job->salary_min) : '-' }}</span><br>
                                Max: <span class="font-semibold">{{ $job->salary_max ? number_format($job->salary_max) : '-' }}</span><br>
                                Note: <span class="font-semibold">{{ $job->salary_note ?: '-' }}</span>
                            </p>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-900">PIC</h3>
                            <p class="mt-2 text-gray-800 font-medium">
                                Nama: <span class="font-semibold">{{ $job->pic_name ?: '-' }}</span><br>
                                Kontak: <span class="font-semibold">{{ $job->pic_contact ?: '-' }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- DOKUMEN --}}
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="font-bold text-gray-900">Dokumen Diminta</h3>
                        @php $docs = $job->dokumen_diminta ?? []; @endphp
                        @if(count($docs))
                            <ul class="mt-2 list-disc list-inside text-gray-800 font-medium space-y-1">
                                @foreach($docs as $d)
                                    <li>{{ $d }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mt-2 text-gray-700 font-medium">-</p>
                        @endif
                    </div>

                    <div class="text-xs text-gray-600 font-medium">
                        Dibuat oleh: <span class="font-semibold text-gray-900">{{ $job->author?->name ?? '-' }}</span> •
                        Updated: <span class="font-semibold text-gray-900">{{ $job->updated_at->format('d M Y H:i') }}</span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
