@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
                    Show {{ $label }}
                </h2>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    /{{ $post->slug }}
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route($routeBase.'.edit', $post) }}"
                   class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                    Edit
                </a>
                <a href="{{ route($routeBase.'.index') }}"
                   class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm font-semibold">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="p-6 space-y-4">
                    <div class="flex items-start gap-4">
                        @if (!empty($post->gambar_utama_path))
                            <img src="{{ Storage::url($post->gambar_utama_path) }}"
                                 class="h-24 w-24 object-cover object-center rounded-md border border-gray-200 dark:border-gray-800"
                                 alt="Gambar utama">
                        @else
                            <div class="h-24 w-24 rounded-md border border-gray-200 dark:border-gray-800
                                        bg-gray-100 dark:bg-gray-800 flex items-center justify-center
                                        text-xs font-bold text-gray-700 dark:text-gray-200">
                                N/A
                            </div>
                        @endif

                        <div class="flex-1">
                            <div class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $post->judul }}
                            </div>
                            <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                Author: <span class="font-semibold">{{ $post->author?->name ?? '-' }}</span> |
                                Status: <span class="font-semibold">{{ strtoupper($post->status) }}</span> |
                                Publish: <span class="font-semibold">{{ $post->published_at?->format('Y-m-d H:i') ?? '-' }}</span>
                            </div>

                            <div class="mt-2 flex flex-wrap gap-2">
                                <span class="px-2 py-1 rounded text-xs font-bold
                                    {{ $post->ditampilkan_di_beranda ? 'bg-indigo-100 text-indigo-900 dark:bg-indigo-900/40 dark:text-indigo-100'
                                                                    : 'bg-gray-200 text-gray-900 dark:bg-gray-800 dark:text-gray-100' }}">
                                    {{ $post->ditampilkan_di_beranda ? 'Ditampilkan di Beranda' : 'Tidak di Beranda' }}
                                </span>

                                @foreach($post->categories as $cat)
                                    <span class="px-2 py-1 rounded text-xs font-bold bg-gray-200 text-gray-900 dark:bg-gray-800 dark:text-gray-100">
                                        {{ $cat->nama }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if(!empty($post->ringkasan))
                        <div>
                            <div class="text-sm font-bold text-gray-900 dark:text-gray-100">Ringkasan</div>
                            <p class="mt-1 text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line">
                                {{ $post->ringkasan }}
                            </p>
                        </div>
                    @endif

                    <div class="border-t border-gray-200 dark:border-gray-800 pt-4">
                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">Konten</div>

                        {{-- Konten disimpan HTML? --}}
                        <div class="prose dark:prose-invert max-w-none mt-2">
                            {!! $post->konten !!}
                        </div>

                        {{-- Kalau konten kamu masih plain text (bukan HTML),
                             ganti blok di atas menjadi:
                             <pre class="mt-2 whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-200">{{ $post->konten }}</pre>
                        --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
