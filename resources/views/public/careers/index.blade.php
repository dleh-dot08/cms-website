{{-- resources/views/public/careers/index.blade.php --}}
@php
    use Illuminate\Support\Carbon;

    $safeName = function ($obj, $fallback = '-') {
        if (is_object($obj) && isset($obj->nama)) return $obj->nama;
        if (is_string($obj) && strlen($obj)) return $obj;
        return $fallback;
    };

    $durasiText = function ($job) {
        $start = $job->published_at ?: $job->created_at;
        $end   = $job->deadline_at;

        try {
            $startTxt = $start ? Carbon::parse($start)->translatedFormat('F Y') : null;
            $endTxt   = $end ? Carbon::parse($end)->translatedFormat('F Y') : null;
        } catch (\Throwable $e) {
            $startTxt = null; $endTxt = null;
        }

        if ($startTxt && $endTxt) return "{$startTxt} - {$endTxt}";
        if ($endTxt) return "s.d. {$endTxt}";
        return '-';
    };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Karir</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">
    @include('layouts.partials.public-header')

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center">
            <div class="text-xs sm:text-sm font-semibold tracking-wide text-red-500">
                Anagata Sisedu Nusantara
            </div>
            <h1 class="mt-2 text-4xl sm:text-5xl font-extrabold">Officer</h1>
        </div>

        {{-- Filters --}}
        <div class="mt-8 flex flex-col md:flex-row items-center justify-center gap-4">
            <form method="GET" action="{{ route('careers.index') }}"
                  class="w-full flex flex-col md:flex-row items-center justify-center gap-4">

                <div class="w-full md:w-[260px]">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Cari Posisi Lowongan"
                        class="w-full rounded-full border border-gray-200 bg-gray-100 px-6 py-3 text-sm font-medium
                               placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300" />
                </div>

                <div class="w-full md:w-[260px]">
                    <select name="location"
                        class="w-full rounded-full border border-gray-900 bg-white px-6 py-3 text-sm font-semibold
                               focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-900">
                        <option value="">Pilih Lokasi</option>
                        @foreach(($locations ?? collect()) as $l)
                            <option value="{{ $l->id }}" @selected((string)request('location') === (string)$l->id)>
                                {{ $l->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-[260px]">
                    <input type="date" name="deadline" value="{{ request('deadline') }}"
                        class="w-full rounded-full border border-gray-200 bg-gray-100 px-6 py-3 text-sm font-medium text-gray-700
                               focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300"
                        aria-label="Batas Lamar" />
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="rounded-full bg-gray-900 text-white px-5 py-3 text-sm font-bold hover:bg-black">
                        Terapkan
                    </button>

                    <a href="{{ route('careers.index') }}"
                        class="rounded-full bg-gray-200 text-gray-900 px-5 py-3 text-sm font-bold hover:bg-gray-300">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="mt-8 overflow-x-auto">
            <table class="w-full border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-white">
                        <th class="text-left font-bold px-5 py-4 border-b border-gray-300">Posisi</th>
                        <th class="text-left font-bold px-5 py-4 border-b border-gray-300">Lokasi</th>
                        <th class="text-left font-bold px-5 py-4 border-b border-gray-300">Durasi</th>
                        <th class="text-left font-bold px-5 py-4 border-b border-gray-300 w-[120px]">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse(($jobs ?? collect()) as $job)
                        @php
                            $locName = $safeName($job->location ?? null, '-');
                            $workTypeName = $safeName($job->workType ?? null, '');
                            $lokasiText = $workTypeName ? "{$locName} / {$workTypeName}" : $locName;

                            $durasi = $durasiText($job);
                            $title  = $job->judul ?? '-';
                            $url    = route('careers.show', $job);
                        @endphp

                        <tr class="odd:bg-white even:bg-gray-50">
                            <td class="px-5 py-4 border-b border-gray-200 font-semibold">
                                <a href="{{ $url }}" class="hover:underline">
                                    {{ $title }}
                                </a>
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200">
                                {{ $lokasiText }}
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200">
                                {{ $durasi }}
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200">
                                <a href="{{ $url }}"
                                   class="inline-flex items-center justify-center rounded-full bg-gray-900 text-white px-4 py-2 text-xs font-bold hover:bg-black">
                                    Show
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-gray-600">
                                Belum ada lowongan yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($jobs) && method_exists($jobs, 'links'))
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
        @endif

        {{-- Footer mini --}}
        <div class="mt-14 flex flex-col items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="#" class="w-9 h-9 rounded-md bg-gray-900 text-white grid place-items-center font-bold">f</a>
                <a href="#" class="w-9 h-9 rounded-md bg-gray-900 text-white grid place-items-center font-bold">X</a>
                <a href="#" class="w-9 h-9 rounded-md bg-gray-900 text-white grid place-items-center font-bold">▶</a>
                <a href="#" class="w-9 h-9 rounded-md bg-gray-900 text-white grid place-items-center font-bold">ig</a>
                <a href="#" class="w-9 h-9 rounded-md bg-gray-900 text-white grid place-items-center font-bold">in</a>
            </div>
            <div class="text-sm font-medium">info.asn@anagataacademy.com</div>
        </div>
    </main>

    @includeIf('layouts.partials.public-footer')
</body>
</html>
