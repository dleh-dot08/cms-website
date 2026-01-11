@php
    $isHome  = request()->is('/');
    $isAbout = request()->routeIs('about') || request()->is('tentang-kami') || request()->is('about');
@endphp

<nav x-data="{ open:false, programOpen:false, karirOpen:false }"
     class="bg-white/95 backdrop-blur border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="h-16 flex items-center justify-between">
            {{-- Left logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('img/logo/logo_AA.webp') }}" alt="Logo Anagata Academy" class="h-9 w-auto">
            </a>

            {{-- Desktop menu --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}"
                   class="{{ $isHome ? 'text-gray-900 font-extrabold' : 'text-gray-700 hover:text-gray-900 font-semibold' }}">
                    Beranda
                </a>

                <a href="{{ route('about') }}"
                   class="{{ $isAbout ? 'text-gray-900 font-extrabold' : 'text-gray-700 hover:text-gray-900 font-semibold' }}">
                    Tentang Kami
                </a>

                {{-- Program dropdown desktop (hover) --}}
                <a href="{{ url('/program') }}"
                    class="text-gray-700 hover:text-gray-900 font-semibold">
                    Program
                </a>

                {{-- Karir dropdown desktop (hover) --}}
                <div class="relative group">
                    <button type="button"
                            class="inline-flex items-center gap-1 text-gray-700 hover:text-gray-900 font-semibold">
                        Karir
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div class="hidden group-hover:block absolute left-0 top-full mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                        <a href="{{ url('/recruitment') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Lowongan</a>
                        <a href="{{ url('/recruitment?work_type=internship') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Magang</a>
                        <a href="{{ url('/recruitment?work_type=freelance') }}" class="block px-4 py-3 text-gray-700 hover:bg-gray-50">Freelance</a>
                    </div>
                </div>
            </div>

            {{-- Right --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo/logo_Codingmu.webp') }}" alt="Logo Codingmu" class="hidden sm:block h-9 w-auto">

                {{-- Mobile button --}}
                <button type="button"
                        @click="open = !open"
                        class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:bg-gray-100"
                        aria-label="Toggle Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-transition class="md:hidden pb-4">
            <div class="pt-2 space-y-1">
                <a href="{{ url('/') }}" class="block px-3 py-2 rounded-lg text-gray-800 font-semibold hover:bg-gray-100">
                    Beranda
                </a>

                <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-gray-800 font-semibold hover:bg-gray-100">
                    Tentang Kami
                </a>

                <a href="{{ url('/program') }}"
                    class="block px-3 py-2 rounded-lg text-gray-800 font-semibold hover:bg-gray-100">
                    Program
                </a>

                {{-- Program accordion --}}
                <button type="button" @click="programOpen = !programOpen"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-gray-800 font-semibold hover:bg-gray-100">
                    <span>Program</span>
                    <svg class="w-4 h-4 transition-transform" :class="programOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                {{-- Karir accordion --}}
                <button type="button" @click="karirOpen = !karirOpen"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-gray-800 font-semibold hover:bg-gray-100">
                    <span>Karir</span>
                    <svg class="w-4 h-4 transition-transform" :class="karirOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="karirOpen" x-transition class="pl-3 space-y-1">
                    <a href="{{ url('/recruitment') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Lowongan</a>
                    <a href="{{ url('/recruitment?work_type=internship') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Magang</a>
                    <a href="{{ url('/recruitment?work_type=freelance') }}" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Freelance</a>
                </div>
            </div>
        </div>
    </div>
</nav>
