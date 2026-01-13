{{-- resources/views/public/news/index.blade.php --}}
@php
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    $coverUrl = function($post) {
        $path = $post->gambar_utama_path ?? null;
        if (!$path) return asset('img/placeholder/news-cover.png');

        if (Str::startsWith($path, ['http://','https://'])) return $path;
        if (Str::startsWith($path, ['assets/','img/','/assets/','/img/'])) return asset(ltrim($path,'/'));

        return Storage::url($path);
    };

    $pubDate = function($post) {
        $d = $post->published_at ?: $post->created_at;
        try {
            return $d ? Carbon::parse($d)->translatedFormat('d M Y') : '';
        } catch (\Throwable $e) {
            return '';
        }
    };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News</title>
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
            <h1 class="mt-2 text-4xl sm:text-5xl font-extrabold">News</h1>
            <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                Update kegiatan, informasi, dan pengumuman terbaru.
            </p>
        </div>

        {{-- Filters --}}
        <div class="mt-8 flex flex-col md:flex-row items-center justify-center gap-4">
            <form method="GET" action="{{ route('news.index') }}"
                  class="w-full flex flex-col md:flex-row items-center justify-center gap-4">

                <div class="w-full md:w-[320px]">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Cari judul / ringkasan..."
                        class="w-full rounded-full border border-gray-200 bg-gray-100 px-6 py-3 text-sm font-medium
                               placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900/10 focus:border-gray-300" />
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="rounded-full bg-gray-900 text-white px-5 py-3 text-sm font-bold hover:bg-black">
                        Terapkan
                    </button>

                    <a href="{{ route('news.index') }}"
                        class="rounded-full bg-gray-200 text-gray-900 px-5 py-3 text-sm font-bold hover:bg-gray-300">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- List cards --}}
        <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(($posts ?? collect()) as $post)
                @php
                    $img = $coverUrl($post);
                    $date = $pubDate($post);
                    $cats = ($post->relationLoaded('categories') ? $post->categories : collect());
                @endphp

                <article class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-md transition">
                    <a href="{{ route('news.show', $post) }}" class="block">
                        <div class="h-44 bg-gray-100 overflow-hidden">
                            <img src="{{ $img }}" alt="{{ $post->judul }}"
                                 class="w-full h-full object-cover" loading="lazy">
                        </div>
                    </a>

                    <div class="p-5">
                        <div class="flex items-center justify-between gap-3 text-xs font-semibold text-gray-500">
                            <span>{{ $date }}</span>
                            @if($post->ditampilkan_di_beranda)
                                <span class="px-2 py-1 rounded-full bg-red-50 text-red-600 border border-red-100">
                                    Featured
                                </span>
                            @endif
                        </div>

                        <h3 class="mt-2 text-lg font-extrabold leading-snug">
                            <a href="{{ route('news.show', $post) }}" class="hover:underline">
                                {{ $post->judul }}
                            </a>
                        </h3>

                        <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                            {{ $post->ringkasan ?: Str::limit(strip_tags($post->konten ?? ''), 140) }}
                        </p>

                        @if($cats->count())
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach($cats->take(3) as $c)
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                        {{ $c->nama }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('news.show', $post) }}"
                               class="inline-flex w-full justify-center rounded-full bg-gray-900 text-white px-5 py-2.5 text-sm font-extrabold hover:bg-black">
                                Show
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full">
                    <div class="border border-gray-200 rounded-2xl p-10 text-center text-gray-600">
                        Belum ada berita yang tersedia.
                    </div>
                </div>
            @endforelse
        </div>

        @if(isset($posts) && method_exists($posts, 'links'))
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @endif
    </main>

    @includeIf('layouts.partials.public-footer')
</body>
</html>
