{{-- resources/views/program.blade.php --}}
@php
    use Illuminate\Support\Facades\Storage;

    /**
     * Helper kecil biar aman ambil nama/deskripsi/cover dari course,
     * walaupun kamu belum bikin accessor di model.
     */
    $getCourseName = function($course) {
        return $course->nama ?? $course->nama_kursus ?? $course->name ?? 'Nama program belum diisi';
    };

    $getCourseDesc = function($course) {
        return $course->description ?? $course->deskripsi_program ?? $course->deskripsi ?? '';
    };

    $getCoverUrl = function($course) {
        $path = $course->foto_kursus_path ?? $course->foto_path ?? null;

        if (empty($path)) return asset('img/placeholder/course-cover.png');

        // sudah URL
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;

        // path public asset
        if (str_starts_with($path, 'assets/') || str_starts_with($path, 'img/') || str_starts_with($path, '/assets/') || str_starts_with($path, '/img/')) {
            return asset(ltrim($path, '/'));
        }

        // ==== NORMALIZE STORAGE PATH ====
        $path = ltrim($path, '/');

        // kalau ada yang nyimpan "storage/xxx.png" atau "/storage/xxx.png"
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        // kalau DB cuma simpan filename "xxxx.png", paksa masuk folder courses/
        if ($path && !str_contains($path, '/')) {
            $path = 'courses/'.$path;
        }

        return Storage::disk('public')->url($path);
    };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Program</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">
    {{-- Header --}}
    @include('layouts.partials.public-header')

    {{-- HEADER SECTION --}}
    <section class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col gap-3">
                <h1 class="text-3xl sm:text-4xl font-extrabold">Program</h1>
                <p class="text-gray-600 max-w-2xl">
                    Cari program berdasarkan kategori, jenjang, dan sub program. Gunakan pencarian untuk cepat menemukan kursus.
                </p>
            </div>
        </div>
    </section>

    {{-- MAIN --}}
    <main x-data="{ filterOpen:false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- MOBILE FILTER BUTTON --}}
            <div class="lg:hidden">
                <button type="button"
                        @click="filterOpen = true"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-3 font-semibold hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 12.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17V12.414L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filter & Pencarian
                </button>
            </div>

            {{-- SIDEBAR (DESKTOP) --}}
            <aside class="hidden lg:block lg:col-span-4">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 sticky top-24">
                    <form method="GET" action="{{ route('program.index') }}" class="space-y-4">
                        <div>
                            <label class="text-sm font-bold text-gray-800">Search</label>
                            <input type="text" name="q" value="{{ request('q') }}"
                                   placeholder="Cari program..."
                                   class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label class="text-sm font-bold text-gray-800">Kategori Program</label>
                            <select name="category" id="filterCategory"
                                    class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" @selected((string)request('category') === (string)$c->id)>
                                        {{ $c->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-bold text-gray-800">Jenjang</label>
                            <select name="level" id="filterLevel"
                                    class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua</option>
                                @foreach($levels as $l)
                                    <option value="{{ $l->id }}" @selected((string)request('level') === (string)$l->id)>
                                        {{ $l->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-bold text-gray-800">Sub Program</label>
                            <select name="sub" id="filterSub"
                                    class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua</option>
                                @foreach($subPrograms as $s)
                                    <option value="{{ $s->id }}"
                                            data-category="{{ $s->program_category_id }}"
                                            @selected((string)request('sub') === (string)$s->id)>
                                        {{ $s->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-2 text-xs text-gray-500">Sub program akan menyesuaikan kategori.</p>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="submit"
                                    class="flex-1 rounded-xl bg-indigo-600 text-white font-bold py-2.5 hover:bg-indigo-700">
                                Terapkan
                            </button>

                            <a href="{{ route('program.index') }}"
                               class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 font-bold text-gray-700 hover:bg-gray-50">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            {{-- CONTENT --}}
            <section class="lg:col-span-8">
                {{-- ACTIVE FILTER CHIPS (AMAN) --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    @if(request('q'))
                        <span class="px-3 py-1 rounded-full bg-gray-900 text-white text-sm font-semibold">
                            Search: "{{ request('q') }}"
                        </span>
                    @endif

                    @if(request('category'))
                        @php $catObj = $categories->firstWhere('id', (int)request('category')); @endphp
                        <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-sm font-semibold border border-indigo-100">
                            Kategori: {{ $catObj?->nama ?? '-' }}
                        </span>
                    @endif

                    @if(request('level'))
                        @php $lvlObj = $levels->firstWhere('id', (int)request('level')); @endphp
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold border border-emerald-100">
                            Jenjang: {{ $lvlObj?->nama ?? '-' }}
                        </span>
                    @endif

                    @if(request('sub'))
                        @php $subObj = $subPrograms->firstWhere('id', (int)request('sub')); @endphp
                        <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-700 text-sm font-semibold border border-orange-100">
                            Sub: {{ $subObj?->nama ?? '-' }}
                        </span>
                    @endif
                </div>

                {{-- LIST COURSES --}}
                @if(($courses ?? collect())->count() === 0)
                    <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center">
                        <p class="font-bold text-lg">Belum ada program yang cocok.</p>
                        <p class="text-gray-600 mt-2">Coba ubah filter atau kata kunci.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($courses as $course)
                            @php
                                $name = $getCourseName($course);
                                $desc = $getCourseDesc($course);
                                $cover = $getCoverUrl($course);

                                // AMAN: relasi bisa object atau kebetulan string, jadi kita cek is_object
                                $catRel = $course->category ?? null;
                                $lvlRel = $course->level ?? null;
                                $subRel = $course->subProgram ?? null;

                                $catName = (is_object($catRel) && isset($catRel->nama)) ? $catRel->nama : null;
                                $lvlName = (is_object($lvlRel) && isset($lvlRel->nama)) ? $lvlRel->nama : null;
                                $subName = (is_object($subRel) && isset($subRel->nama)) ? $subRel->nama : null;

                                $detailUrl = '#';
                                if (\Illuminate\Support\Facades\Route::has('courses.show')) {
                                    $detailUrl = route('courses.show', $course);
                                } else {
                                    $detailUrl = url('/courses/'.$course->id);
                                }
                            @endphp

                            <article class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden">
                                <div class="h-40 bg-gray-100 overflow-hidden">
                                    <img
                                        src="{{ $cover }}"
                                        alt="{{ $name }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                    />
                                </div>

                                <div class="p-5">
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        @if($catName)
                                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                {{ $catName }}
                                            </span>
                                        @endif

                                        @if($lvlName)
                                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                {{ $lvlName }}
                                            </span>
                                        @endif

                                        @if($subName)
                                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-orange-50 text-orange-700 border border-orange-100">
                                                {{ $subName }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="text-lg font-extrabold leading-snug">
                                        {{ $name }}
                                    </h3>

                                    <p class="text-sm text-gray-600 mt-2 line-clamp-3">
                                        {{ $desc ?: 'Deskripsi program belum diisi.' }}
                                    </p>

                                    <div class="mt-4">
                                        <a href="{{ $detailUrl }}"
                                           class="inline-flex w-full justify-center rounded-xl bg-gray-900 text-white font-bold py-2.5 hover:bg-black">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $courses->links() }}
                    </div>
                @endif
            </section>
        </div>

        {{-- MOBILE FILTER DRAWER --}}
        <div x-show="filterOpen" x-transition class="fixed inset-0 z-[60] lg:hidden">
            <div class="absolute inset-0 bg-black/40" @click="filterOpen=false"></div>
            <div class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-xl p-5 overflow-y-auto">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-extrabold">Filter & Search</h3>
                    <button @click="filterOpen=false" class="w-10 h-10 rounded-lg hover:bg-gray-100 grid place-items-center">
                        ✕
                    </button>
                </div>

                <form method="GET" action="{{ route('program.index') }}" class="mt-4 space-y-4">
                    <div>
                        <label class="text-sm font-bold text-gray-800">Search</label>
                        <input type="text" name="q" value="{{ request('q') }}"
                               placeholder="Cari program..."
                               class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-800">Kategori Program</label>
                        <select name="category" id="filterCategoryMobile"
                                class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" @selected((string)request('category') === (string)$c->id)>
                                    {{ $c->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-800">Jenjang</label>
                        <select name="level" id="filterLevelMobile"
                                class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua</option>
                            @foreach($levels as $l)
                                <option value="{{ $l->id }}" @selected((string)request('level') === (string)$l->id)>
                                    {{ $l->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-bold text-gray-800">Sub Program</label>
                        <select name="sub" id="filterSubMobile"
                                class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua</option>
                            @foreach($subPrograms as $s)
                                <option value="{{ $s->id }}"
                                        data-category="{{ $s->program_category_id }}"
                                        @selected((string)request('sub') === (string)$s->id)>
                                    {{ $s->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                                class="flex-1 rounded-xl bg-indigo-600 text-white font-bold py-2.5 hover:bg-indigo-700">
                            Terapkan
                        </button>
                        <a href="{{ route('program.index') }}"
                           class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 font-bold text-gray-700 hover:bg-gray-50">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    @include('layouts.partials.public-footer')

    {{-- Dependent Sub Program by Category --}}
    <script>
        (function () {
            function bindDependentSub(categoryEl, subEl) {
                if (!categoryEl || !subEl) return;

                const allOptions = Array.from(subEl.querySelectorAll('option'));
                const base = allOptions[0]; // "Semua"

                const apply = () => {
                    const cat = categoryEl.value;
                    const current = subEl.value;

                    subEl.innerHTML = '';
                    subEl.appendChild(base.cloneNode(true));

                    allOptions.slice(1).forEach(opt => {
                        const optCat = opt.getAttribute('data-category');
                        if (!cat || optCat === cat) {
                            subEl.appendChild(opt.cloneNode(true));
                        }
                    });

                    const stillExists = Array.from(subEl.querySelectorAll('option')).some(o => o.value === current);
                    subEl.value = stillExists ? current : '';
                };

                categoryEl.addEventListener('change', apply);
                apply();
            }

            bindDependentSub(document.getElementById('filterCategory'), document.getElementById('filterSub'));
            bindDependentSub(document.getElementById('filterCategoryMobile'), document.getElementById('filterSubMobile'));
        })();
    </script>
</body>
</html>
