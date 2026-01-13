{{-- resources/views/public/news/show.blade.php --}}
@php
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    $coverUrl = function($post) {
        $path = $post->gambar_utama_path ?? null;
        if (!$path) return null;

        if (Str::startsWith($path, ['http://','https://'])) return $path;
        if (Str::startsWith($path, ['assets/','img/','/assets/','/img/'])) return asset(ltrim($path,'/'));

        return Storage::url($path);
    };

    $dateText = function($post) {
        $d = $post->published_at ?: $post->created_at;
        try {
            return $d ? Carbon::parse($d)->translatedFormat('d F Y') : '';
        } catch (\Throwable $e) {
            return '';
        }
    };

    $img = $coverUrl($post);
    $date = $dateText($post);
    $cats = ($post->relationLoaded('categories') ? $post->categories : collect());
    $author = $post->relationLoaded('author') ? $post->author : null;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $post->judul }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">
    @include('layouts.partials.public-header')

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-6">
            <a href="{{ route('news.index') }}" class="text-sm font-semibold text-gray-700 hover:underline">
                ← Kembali ke News
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Content --}}
            <section class="lg:col-span-8">
                <div class="text-xs font-semibold tracking-wide text-red-500">
                    Anagata Sisedu Nusantara
                </div>

                <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold">
                    {{ $post->judul }}
                </h1>

                <div class="mt-3 flex flex-wrap items-center gap-2 text-sm text-gray-600 font-medium">
                    @if($date)
                        <span>{{ $date }}</span>
                    @endif
                    @if($author && isset($author->name))
                        <span class="text-gray-400">•</span>
                        <span>Oleh {{ $author->name }}</span>
                    @endif
                </div>

                @if($cats->count())
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($cats as $c)
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                {{ $c->nama }}
                            </span>
                        @endforeach
                    </div>
                @endif

                @if($post->ringkasan)
                    <p class="mt-6 text-gray-700 leading-relaxed">
                        {{ $post->ringkasan }}
                    </p>
                @endif

                <div class="mt-8 prose max-w-none">
                    {{-- Jika konten kamu HTML dari editor: --}}
                    {!! $post->konten !!}

                    {{-- Jika konten kamu TEXT biasa (opsional ganti):
                    {!! nl2br(e($post->konten)) !!}
                    --}}
                </div>
            </section>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4">
                <div class="border border-gray-200 rounded-2xl p-6 sticky top-24">
                    @if($img)
                        <img src="{{ $img }}" alt="Cover"
                             class="w-full h-56 object-cover rounded-2xl border border-gray-200">
                    @else
                        <div class="w-full h-56 rounded-2xl bg-gray-100 border border-gray-200 grid place-items-center text-gray-500 text-sm">
                            Cover belum ada
                        </div>
                    @endif

                    <h3 class="mt-6 text-xl font-extrabold text-center">Info News</h3>

                    <div class="mt-5 space-y-3 text-sm">
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-600 font-semibold">Status</span>
                            <span class="text-gray-900 font-bold text-right">{{ $post->status }}</span>
                        </div>

                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-600 font-semibold">Tanggal</span>
                            <span class="text-gray-900 font-bold text-right">{{ $date ?: '-' }}</span>
                        </div>

                        <div class="pt-2 border-t border-gray-200"></div>

                        <div class="flex items-start justify-between gap-4">
                            <span class="text-gray-600 font-semibold">Jenis</span>
                            <span class="text-gray-900 font-bold text-right">{{ $post->jenis }}</span>
                        </div>

                        @if($post->ditampilkan_di_beranda)
                            <div class="flex items-start justify-between gap-4">
                                <span class="text-gray-600 font-semibold">Featured</span>
                                <span class="text-red-600 font-extrabold text-right">Yes</span>
                            </div>
                        @endif
                    </div>

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
