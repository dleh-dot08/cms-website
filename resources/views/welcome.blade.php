<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Anagata Academy</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Breeze/Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">
    {{-- NAVBAR --}}
    @include('layouts.partials.public-header')

    {{-- HERO / CAROUSEL --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden">
            {{-- slides --}}
            <div class="js-slide block relative">
                <img src="{{ asset('img/homepage/MOU.jpg') }}" alt="Penandatanganan MOU"
                     class="w-full h-64 sm:h-80 md:h-[420px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                <div class="absolute bottom-6 inset-x-0 px-6 text-white">
                    <h2 class="text-xl sm:text-3xl font-bold">Penandatanganan MOU</h2>
                    <p class="text-sm sm:text-lg mt-1">PT ASN dengan Persyarikatan Muhammadiyah</p>
                    <p class="text-xs sm:text-base mt-2 opacity-90">5 Agustus 2022</p>
                </div>
            </div>

            <div class="js-slide hidden relative">
                <img src="{{ asset('img/homepage/lab-komputer.jpg') }}" alt="Penyerahan Lab CodingMU"
                     class="w-full h-64 sm:h-80 md:h-[420px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                <div class="absolute bottom-6 inset-x-0 px-6 text-white">
                    <h2 class="text-xl sm:text-3xl font-bold">Penyerahan Lab CodingMU</h2>
                    <p class="text-xs sm:text-base mt-2 opacity-90">23 Oktober 2024</p>
                </div>
            </div>

            <div class="js-slide hidden relative">
                <img src="{{ asset('img/homepage/bendi-cup.jpg') }}" alt="Bendi Cup"
                     class="w-full h-64 sm:h-80 md:h-[420px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                <div class="absolute bottom-6 inset-x-0 px-6 text-white">
                    <h2 class="text-xl sm:text-3xl font-bold">Bendi Cup Juara 1 & 2</h2>
                    <p class="text-xs sm:text-base mt-2 opacity-90">20 Oktober 2022</p>
                </div>
            </div>

            {{-- arrows --}}
            <button type="button" data-carousel-prev
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-900 rounded-full p-2 shadow">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button type="button" data-carousel-next
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-900 rounded-full p-2 shadow">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            {{-- indicators --}}
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                <button type="button" data-carousel-dot="0" class="js-dot w-3 h-3 rounded-full bg-white/80"></button>
                <button type="button" data-carousel-dot="1" class="js-dot w-3 h-3 rounded-full bg-white/40"></button>
                <button type="button" data-carousel-dot="2" class="js-dot w-3 h-3 rounded-full bg-white/40"></button>
            </div>
        </div>
    </section>

    {{-- VIDEO + TEXT --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid gap-8 lg:grid-cols-2 items-center">
            <div class="w-full overflow-hidden rounded-2xl shadow bg-white aspect-video">
                <iframe class="w-full h-full"
                        src="https://www.youtube.com/embed/Kd6jV1qO9ps"
                        title="Tentang ASN"
                        loading="lazy"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen></iframe>
            </div>

            <div class="bg-white rounded-2xl shadow p-6 sm:p-8">
                <img src="{{ asset('img/homepage/mitra berbakat.webp') }}" alt="Mitra Berbakat" class="w-full max-w-sm mx-auto lg:mx-0">
                <p class="text-sm sm:text-base text-gray-700 leading-relaxed mt-5">
                    Bersama Anagata Academy, siapkan bekal untuk masa depan dan ciptakan karya dengan kreativitas tanpa batas.
                </p>
            </div>
        </div>
    </section>

    {{-- STATS (COUNTER) --}}
    <section class="bg-[#12376F]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $stats = [
                        ['label' => 'Sekolah', 'value' => 498],
                        ['label' => 'User', 'value' => 498],
                        ['label' => 'Program', 'value' => 1000],
                        ['label' => 'Aktivitas', 'value' => 1000],
                    ];
                @endphp

                @foreach($stats as $s)
                    <div class="bg-white/5 rounded-2xl p-6 text-center border border-white/10">
                        <div class="text-3xl sm:text-4xl font-extrabold text-orange-400">
                            <span class="js-counter" data-target="{{ $s['value'] }}">0</span>
                        </div>
                        <p class="text-white text-base sm:text-lg font-semibold mt-2">{{ $s['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- BENEFITS --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-gray-900 mb-8">Spesial Benefits</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @for($i=1; $i<=4; $i++)
                <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
                    <img src="{{ asset('img/homepage/special-benefit.jpg') }}"
                         alt="Benefit"
                         class="w-full h-36 object-cover rounded-xl mb-4">
                    <h3 class="font-bold text-base sm:text-lg mb-2">Judul Benefit {{ $i }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Deskripsi singkat benefit untuk terlihat profesional dan mudah dipahami.
                    </p>
                </div>
            @endfor
        </div>
    </section>

    {{-- PROGRAM --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Program</h2>
            <a href="{{ url('/program') }}"
               class="inline-flex justify-center bg-purple-600 text-white px-5 py-2.5 rounded-full hover:bg-purple-700 transition font-semibold">
                Lihat Detail
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $programs = [
                    ['title' => 'Teknologi Digital', 'img' => 'img/homepage/teknologi-digital.webp'],
                    ['title' => 'Bahasa dan Sastra', 'img' => 'img/homepage/bahasa-dan-sastra.webp'],
                    ['title' => 'Soft Skill', 'img' => 'img/homepage/soft-skill.webp'],
                ];
            @endphp

            @foreach($programs as $p)
                <div class="flex flex-col items-center text-center">
                    <img 
                        src="{{ asset($p['img']) }}" 
                        alt="{{ $p['title'] }}" 
                        class="h-[320px] w-auto object-contain mb-6"
                    >

                    <h3 class="font-bold text-lg text-gray-900">
                        {{ $p['title'] }}
                    </h3>
                </div>
            @endforeach
        </div>
    </section>

    @include('layouts.partials.public-footer')

    {{-- JS (dari Vite/app.js -> import welcome.js) --}}
</body>
</html>
