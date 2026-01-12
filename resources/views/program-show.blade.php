{{-- resources/views/program-show.blade.php --}}
@php
    use Illuminate\Support\Facades\Storage;

    $cover = $course->cover_url ?? (
        !empty($course->foto_kursus_path) ? Storage::url($course->foto_kursus_path) : asset('img/placeholder/course-cover.png')
    );

    $catName = $course->programCategory?->nama ?? '-';
    $jenjangName = $course->jenjang?->nama ?? '-';
    $subName = $course->subProgram?->nama ?? '-';

    $title = $course->nama_kursus ?? $course->nama ?? 'Program';
    $desc = $course->deskripsi_program ?? $course->description ?? '';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">
    @include('layouts.partials.public-header')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-12 lg:divide-x lg:divide-gray-200">
            {{-- LEFT: Title + Desc + Accordion --}}
            <section class="lg:pr-12">
                <h1 class="text-4xl font-extrabold tracking-tight">{{ $title }}</h1>

                <div class="mt-6 space-y-6 text-[15px] leading-relaxed text-gray-800">
                    @if($desc)
                        <p class="whitespace-pre-line">{{ $desc }}</p>
                    @else
                        <p class="text-gray-600">Deskripsi program belum diisi.</p>
                    @endif
                </div>

                {{-- Accordion Chapters --}}
                <div class="mt-10" x-data="{ openId: {{ $meetings->first()?->id ?? 0 }} }">
                    <div class="space-y-2">
                        @forelse($meetings as $m)
                            @php
                                $label = $m->judul ?: ('Chapter ' . $m->pertemuan_ke);
                            @endphp

                            <div class="border border-gray-200 overflow-hidden">
                                <button type="button"
                                        class="w-full flex items-center justify-between px-6 py-4 bg-gray-200/70 text-gray-900 font-medium"
                                        @click="openId = (openId === {{ $m->id }} ? 0 : {{ $m->id }})">
                                    <span>{{ $label }}</span>
                                    <span class="text-2xl leading-none"
                                          x-text="openId === {{ $m->id }} ? '−' : '+'"></span>
                                </button>

                                <div x-show="openId === {{ $m->id }}" x-transition
                                     class="px-6 py-4 bg-white border-t border-gray-200">
                                    @if($m->materi_singkat)
                                        <p class="text-gray-800">{{ $m->materi_singkat }}</p>
                                    @endif

                                    @if($m->materi_detail)
                                        <div class="mt-3 text-gray-700 whitespace-pre-line">
                                            {{ $m->materi_detail }}
                                        </div>
                                    @endif

                                    @if($m->durasi_menit)
                                        <p class="mt-3 text-sm text-gray-600">
                                            Durasi: <span class="font-semibold">{{ $m->durasi_menit }}</span> menit
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="border border-gray-200 rounded-xl p-6 text-gray-600">
                                Chapter/Meeting belum ada.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- RIGHT: Cover + Info Program --}}
            <aside class="lg:pl-12 mt-10 lg:mt-0">
                <div class="flex justify-center">
                    <div class="w-[340px] sm:w-[380px] rounded-[32px] overflow-hidden shadow-sm bg-orange-500">
                        <img src="{{ $cover }}" alt="{{ $title }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='{{ asset('img/placeholder/course-cover.png') }}'">
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <h2 class="text-3xl font-extrabold">Info Program</h2>
                    <div class="mx-auto mt-2 h-1 w-44 bg-orange-500 rounded-full"></div>
                </div>

                <div class="mt-6 bg-white">
                    <dl class="space-y-3 text-[15px]">
                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-600">Kategori</dt>
                            <dd class="font-semibold text-gray-900">{{ $catName }}</dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-600">Jenjang</dt>
                            <dd class="font-semibold text-gray-900">{{ $jenjangName }}</dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-600">Sub Program</dt>
                            <dd class="font-semibold text-gray-900">{{ $subName }}</dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-600">Periode</dt>
                            <dd class="font-semibold text-gray-900">{{ $course->periode_waktu ?: '-' }}</dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-600">Level</dt>
                            <dd class="font-semibold text-gray-900">{{ $course->level ?: '-' }}</dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-600">Total Pertemuan</dt>
                            <dd class="font-semibold text-gray-900">{{ $course->total_pertemuan ?: $meetings->count() }}</dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-600">Durasi</dt>
                            <dd class="font-semibold text-gray-900">
                                {{ $course->durasi_menit ? ($course->durasi_menit . ' menit/pertemuan') : '-' }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-600">Pelaksanaan</dt>
                            <dd class="font-semibold text-gray-900">{{ $course->pelaksanaan ?: '-' }}</dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-600">Sertifikat</dt>
                            <dd class="font-semibold text-gray-900">
                                {{ $course->mendapatkan_sertifikat ? 'Ya' : 'Tidak' }}
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-8 flex gap-3">
                        <a href="{{ route('program.index') }}"
                           class="flex-1 inline-flex justify-center rounded-xl border border-gray-300 px-4 py-3 font-semibold hover:bg-gray-50">
                            Kembali
                        </a>
                        <a href="{{ url('/contact') }}"
                           class="flex-1 inline-flex justify-center rounded-xl bg-gray-900 text-white px-4 py-3 font-semibold hover:bg-black">
                            Tanya Admin
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </main>

    @include('layouts.partials.public-footer')
</body>
</html>
