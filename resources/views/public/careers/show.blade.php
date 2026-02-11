@php
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    $safeName = function ($obj, $fallback = '-') {
        if (is_object($obj) && isset($obj->nama)) return $obj->nama;
        if (is_string($obj) && strlen($obj)) return $obj;
        return $fallback;
    };

    $coverUrl = function($job) {
        $path = $job->cover_image_path ?? null;
        if (!$path) return null;

        if (Str::startsWith($path, ['http://','https://'])) return $path;
        if (Str::startsWith($path, ['assets/','img/','/assets/','/img/'])) return asset(ltrim($path,'/'));

        return Storage::url($path);
    };

    $title = $job->judul ?? 'Detail Lowongan';
    $division  = $safeName($job->division ?? null, '-');
    $workType  = $safeName($job->workType ?? null, '-');
    $location  = $safeName($job->location ?? null, '-');

    $deadline = $job->deadline_at ? Carbon::parse($job->deadline_at)->translatedFormat('d F Y') : null;
    $cover = $coverUrl($job);

    // Apply button
    $applyType  = $job->apply_type ?? 'link';
    $applyValue = $job->apply_value ?? null;

    $applyLabel = 'Apply';
    $applyHref  = $applyValue;

    if ($applyType === 'email' && $applyValue) {
        $applyLabel = 'Kirim Email';
        $applyHref  = 'mailto:' . $applyValue;
    } elseif ($applyType === 'whatsapp' && $applyValue) {
        $applyLabel = 'Chat WhatsApp';
        $v = preg_replace('/\D+/', '', $applyValue);
        $applyHref = 'https://wa.me/' . $v;
    } elseif ($applyType === 'ats') {
        $applyLabel = 'Apply (ATS)';
    }

    if (!$applyHref) $applyHref = '#';
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

<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6">
        <a href="{{ route('careers.index') }}" class="text-sm font-semibold text-gray-700 hover:underline">
            ← Kembali ke Karir
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Left: Content --}}
        <section class="lg:col-span-7">
            <div class="text-xs font-semibold tracking-wide text-red-500">
                Anagata Sisedu Nusantara
            </div>

            <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold">
                {{ $title }}
            </h1>

            <div class="mt-4 flex flex-wrap gap-2">
                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-xs font-bold border border-gray-200">
                    {{ $division }}
                </span>
                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-xs font-bold border border-gray-200">
                    {{ $workType }}
                </span>
                <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 text-xs font-bold border border-gray-200">
                    {{ $location }}
                </span>
                @if($deadline)
                    <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-700 text-xs font-bold border border-orange-100">
                        Batas Lamar: {{ $deadline }}
                    </span>
                @endif
            </div>

            @if($job->ringkasan)
                <p class="mt-5 text-gray-700 leading-relaxed">
                    {{ $job->ringkasan }}
                </p>
            @endif

            {{-- TOR Viewer --}}
            <div class="mt-8">
                <h2 class="text-lg font-extrabold">Term of Reference</h2>

                @if($job->tor_pdf_url)
                    <div class="mt-3 rounded-2xl border border-gray-200 overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <p class="text-sm font-semibold text-gray-800">
                                Dokumen ditampilkan untuk dibaca.
                            </p>
                        </div>

                        <div class="w-full" style="height: 80vh;">
                            <iframe
                                src="{{ $job->tor_pdf_url }}#toolbar=0&navpanes=0&scrollbar=1&view=FitH"
                                class="w-full h-full"
                                style="border:0;"
                                loading="lazy"
                            ></iframe>
                        </div>
                    </div>

                    @if($job->tor_pdf_name)
                        <p class="mt-2 text-xs text-gray-600">
                            File: <span class="font-semibold text-gray-900">{{ $job->tor_pdf_name }}</span>
                        </p>
                    @endif
                @else
                    <div class="mt-3 rounded-2xl border border-yellow-200 bg-yellow-50 p-4">
                        <p class="text-sm font-semibold text-yellow-900">Term of Reference belum tersedia untuk lowongan ini.</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Right: Cover + Info --}}
        <aside class="lg:col-span-5">
            <div class="border border-gray-200 rounded-2xl p-6 sticky top-24">
                @if($cover)
                    <img src="{{ $cover }}" alt="Cover"
                         class="w-full h-56 object-cover rounded-2xl border border-gray-200">
                @else
                    <div class="w-full h-56 rounded-2xl bg-gray-100 border border-gray-200 grid place-items-center text-gray-500 text-sm">
                        Cover belum ada
                    </div>
                @endif

                <h3 class="mt-6 text-xl font-extrabold text-center">Info Program</h3>

                <div class="mt-5 space-y-3 text-sm">
                    <div class="flex items-start justify-between gap-4">
                        <span class="text-gray-600 font-semibold">Divisi</span>
                        <span class="text-gray-900 font-bold text-right">{{ $division }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <span class="text-gray-600 font-semibold">Tipe Kerja</span>
                        <span class="text-gray-900 font-bold text-right">{{ $workType }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-4">
                        <span class="text-gray-600 font-semibold">Lokasi</span>
                        <span class="text-gray-900 font-bold text-right">{{ $location }}</span>
                    </div>

                    @if($deadline)
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-600 font-semibold">Batas Lamar</span>
                            <span class="text-gray-900 font-bold text-right">{{ $deadline }}</span>
                        </div>
                    @endif

                    @if($job->salary_min || $job->salary_max || $job->salary_note)
                        <div class="pt-2 border-t border-gray-200"></div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-600 font-semibold">Gaji</span>
                            <span class="text-gray-900 font-bold text-right">
                                @php
                                    $min = $job->salary_min ? number_format($job->salary_min,0,',','.') : null;
                                    $max = $job->salary_max ? number_format($job->salary_max,0,',','.') : null;
                                @endphp

                                @if($min && $max)
                                    Rp {{ $min }} - Rp {{ $max }}
                                @elseif($min)
                                    Mulai Rp {{ $min }}
                                @elseif($max)
                                    Hingga Rp {{ $max }}
                                @else
                                    -
                                @endif

                                @if($job->salary_note)
                                    <div class="text-xs text-gray-600 font-semibold mt-1">{{ $job->salary_note }}</div>
                                @endif
                            </span>
                        </div>
                    @endif
                </div>

                <div class="mt-6">
                    <a href="{{ $applyHref }}"
                       @if($applyHref !== '#') target="_blank" rel="noopener" @endif
                       class="inline-flex w-full justify-center rounded-full bg-gray-900 text-white px-5 py-3 text-sm font-extrabold hover:bg-black">
                        {{ $applyLabel }}
                    </a>

                    @if($job->apply_value)
                        <p class="mt-3 text-xs text-gray-600 text-center break-words">
                            {{ $job->apply_value }}
                        </p>
                    @endif
                </div>

                <div class="mt-8 flex flex-col items-center gap-3">
                    <div class="text-sm font-medium">info.asn@anagataacademy.com</div>
                </div>

            </div>
        </aside>
    </div>
</main>

@includeIf('layouts.partials.public-footer')
</body>
</html>
