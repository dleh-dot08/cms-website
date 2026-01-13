@php
  use Illuminate\Support\Facades\Storage;

  $imgUrl = function($path) {
      if (!$path) return asset('img/placeholder/course-cover.png');
      if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
      if (str_starts_with($path, '/storage/')) return url($path);
      if (str_starts_with($path, 'storage/')) return url('/'.$path);
      if (str_starts_with($path, 'img/') || str_starts_with($path, 'assets/') || str_starts_with($path, '/img/') || str_starts_with($path, '/assets/')) {
          return asset(ltrim($path, '/'));
      }
      return Storage::url($path);
  };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $post->judul }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

  @include('layouts.partials.public-header')

  <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <a href="{{ route('blog.index') }}" class="text-sm font-semibold text-gray-700 hover:underline">
      ← Kembali ke Blog
    </a>

    <article class="mt-5 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
      <div class="h-72 bg-gray-100">
        <img
          src="{{ $imgUrl($post->gambar_utama_path) }}"
          class="w-full h-full object-cover"
          alt="{{ $post->judul }}"
        />
      </div>

      <div class="p-6">
        <p class="text-sm text-gray-500 font-semibold">
          {{ $post->published_at ? $post->published_at->format('d M Y H:i') : '' }}
        </p>

        <h1 class="mt-1 text-3xl font-extrabold">{{ $post->judul }}</h1>

        @if($post->ringkasan)
          <p class="mt-4 text-gray-700 font-medium">{{ $post->ringkasan }}</p>
        @endif

        <div class="prose max-w-none mt-6">
          {!! nl2br(e($post->konten)) !!}
        </div>
      </div>
    </article>
  </main>

  @include('layouts.partials.public-footer')
</body>
</html>
