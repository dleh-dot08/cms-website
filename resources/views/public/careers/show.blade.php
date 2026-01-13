{{-- resources/views/public/careers/show.blade.php --}}
@php
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    $safeName = function ($obj, $fallback = '-') {
        if (is_object($obj) && isset($obj->nama)) return $obj->nama;
        if (is_string($obj) && strlen($obj)) return $obj;
        return $fallback;
    };

    // Konversi field bullet: bisa array, json string, atau text biasa per baris
    $toBullet = function ($val) {
        if (is_null($val)) return [];
        if (is_array($val)) return array_values(array_filter($val, fn($x)=>trim((string)$x)!==''));

        if (is_string($val)) {
            $decoded = json_decode($val, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_values(array_filter($decoded, fn($x)=>trim((string)$x)!=='' ));
            }
            $lines = preg_split("/\R/u", $val) ?: [];
            return array_values(array_filter(array_map('trim', $lines), fn($x)=>$x!==''));
        }

        return [];
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

    $resp = $toBullet($job->responsibilities ?? null);
    $req  = $toBullet($job->requirements ?? null);
    $ben  = $toBullet($job->benefits ?? null);

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
        $v = preg_replace('/\D+/', '', $applyValue); // ambil digit
        $applyHref = 'https://wa.me/' . $v;
    } elseif ($applyType === 'ats') {
        $applyLabel = 'Apply (ATS)';
    } else {
        $applyLabel = 'Apply';
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
        {{-- Breadcrumb --}}
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

                {{-- Sections --}}
                <div class="mt-8 space-y-8">
                    @if($job->deskripsi_role)
                        <div>
                            <h2 class="text-lg font-extrabold">Deskripsi Role</h2>
                            <div class="mt-2 text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $job->deskripsi_role }}
                            </div>
                        </div>
                    @endif

                    @if($job->jobdesk_detail)
                        <div>
                            <h2 class="text-lg font-extrabold">Detail Jobdesk</h2>
                            <div class="mt-2 text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $job->jobdesk_detail }}
                            </div>
                        </div>
                    @endif

                    @if($job->kualifikasi_detail)
                        <div>
                            <h2 class="text-lg font-extrabold">Detail Kualifikasi</h2>
                            <div class="mt-2 text-gray-700 leading-relaxed whitespace-pre-line">
                                {{ $job->kualifikasi_detail }}
                            </div>
                        </div>
                    @endif

                    {{-- Bullet columns --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="border border-gray-200 rounded-2xl p-5">
                            <h3 class="font-extrabold">Responsibilities</h3>
                            @if(count($resp))
                                <ul class="mt-3 list-disc pl-5 space-y-2 text-sm text-gray-700">
                                    @foreach($resp as $x)
                                        <li>{{ $x }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-3 text-sm text-gray-500">Belum diisi.</p>
                            @endif
                        </div>

                        <div class="border border-gray-200 rounded-2xl p-5">
                            <h3 class="font-extrabold">Requirements</h3>
                            @if(count($req))
                                <ul class="mt-3 list-disc pl-5 space-y-2 text-sm text-gray-700">
                                    @foreach($req as $x)
                                        <li>{{ $x }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-3 text-sm text-gray-500">Belum diisi.</p>
                            @endif
                        </div>

                        <div class="border border-gray-200 rounded-2xl p-5">
                            <h3 class="font-extrabold">Benefits</h3>
                            @if(count($ben))
                                <ul class="mt-3 list-disc pl-5 space-y-2 text-sm text-gray-700">
                                    @foreach($ben as $x)
                                        <li>{{ $x }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-3 text-sm text-gray-500">Belum diisi.</p>
                            @endif
                        </div>
                    </div>
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

                    {{-- Social + email --}}
                    <div class="mt-8 flex flex-col items-center gap-3">
                        <div class="flex items-center gap-3">
                            <a href="#" class="w-9 h-9 rounded-md bg-gray-900 text-white grid place-items-center font-bold">f</a>
                            <a href="#" class="w-9 h-9 rounded-md bg-gray-900 text-white grid place-items-center font-bold">X</a>
                            <a href="#" class="w-9 h-9 rounded-md bg-gray-900 text-white grid place-items-center font-bold">▶</a>
                            <a href="#" class="w-9 h-9 rounded-md bg-gray-900 text-white grid place-items-center font-bold">ig</a>
                            <a href="#" class="w-9 h-9 rounded-md bg-gray-900 text-white grid place-items-center font-bold">in</a>
                        </div>
                        <div class="text-sm font-medium">info.asn@anagataacademy.com</div>
                    </div>

                </div>
            </aside>
        </div>
    </main>

    @includeIf('layouts.partials.public-footer')
</body>
</html>
