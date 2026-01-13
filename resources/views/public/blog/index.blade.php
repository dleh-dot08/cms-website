@php
  use Illuminate\Support\Facades\Storage;

  $imgUrl = function($path) {
      if (!$path) return asset('img/placeholder/course-cover.png');

      // sudah url
      if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;

      // kalau sudah /storage/xxx atau storage/xxx
      if (str_starts_with($path, '/storage/')) return url($path);
      if (str_starts_with($path, 'storage/')) return url('/'.$path);

      // kalau disimpan relatif di public (img/assets)
      if (str_starts_with($path, 'img/') || str_starts_with($path, 'assets/') || str_starts_with($path, '/img/') || str_starts_with($path, '/assets/')) {
          return asset(ltrim($path, '/'));
      }

      // default: storage/app/public/...
      return Storage::url($path);
  };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

  @include('layouts.partials.public-header')

  <section class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <h1 class="text-3xl sm:text-4xl font-extrabold">Blog</h1>
      <p class="mt-2 text-gray-600 max-w-2xl">Artikel & insight terbaru.</p>

      <form method="GET" action="{{ route('blog.index') }}" class="mt-6 flex gap-2">
        <input name="q" value="{{ $q ?? '' }}" placeholder="Cari blog..."
               class="w-full max-w-lg rounded-xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500"/>
        <button class="rounded-xl bg-indigo-600 text-white font-bold px-4 py-2 hover:bg-indigo-700">
          Cari
        </button>
      </form>
    </div>
  </section>

  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if($posts->count() === 0)
      <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center">
        <p class="font-bold text-lg">Belum ada postingan blog.</p>
        <p class="text-gray-600 mt-2">Pastikan jenis=blog, status=publish/published, dan published_at tidak di masa depan.</p>
      </div>
    @else
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
          <article class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition overflow-hidden">
            <div class="h-40 bg-gray-100">
              <img
                src="{{ $imgUrl($post->gambar_utama_path) }}"
                class="w-full h-full object-cover"
                alt="{{ $post->judul }}"
                loading="lazy"
              />
            </div>

            <div class="p-5">
              <p class="text-xs font-semibold text-gray-500">
                {{ $post->published_at ? $post->published_at->format('d M Y H:i') : '' }}
              </p>

              <h3 class="mt-1 text-lg font-extrabold leading-snug">
                {{ $post->judul }}
              </h3>

              <p class="mt-2 text-sm text-gray-600 line-clamp-3">
                {{ $post->ringkasan }}
              </p>

              <a href="{{ route('blog.show', $post->slug) }}"
                 class="mt-4 inline-flex w-full justify-center rounded-xl bg-gray-900 text-white font-bold py-2.5 hover:bg-black">
                Baca Selengkapnya
              </a>
            </div>
          </article>
        @endforeach
      </div>

      <div class="mt-8">
        {{ $posts->links() }}
      </div>
    @endif
  </main>

  @include('layouts.partials.public-footer')
</body>
</html>
