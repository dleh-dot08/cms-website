@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
                Edit {{ $label }}
            </h2>

            <a href="{{ route($routeBase.'.index') }}"
               class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:underline">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 dark:border-green-800 bg-green-50 dark:bg-green-900/30 px-4 py-3">
                    <p class="text-sm font-medium text-green-900 dark:text-green-100">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="p-6">
                    <form method="POST" action="{{ route($routeBase.'.update', $post) }}"
                          enctype="multipart/form-data"
                          class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="judul" :value="'Judul'" />
                            <x-text-input id="judul" name="judul" type="text"
                                class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100 dark:border-gray-700"
                                :value="old('judul', $post->judul)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('judul')" />
                        </div>

                        <div>
                            <x-input-label :value="'Slug (otomatis)'" />
                            <div class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                /{{ $post->slug }}
                            </div>
                        </div>

                        <div>
                            <x-input-label for="ringkasan" :value="'Ringkasan (opsional)'" />
                            <textarea id="ringkasan" name="ringkasan" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">{{ old('ringkasan', $post->ringkasan) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('ringkasan')" />
                        </div>

                        <div>
                            <x-input-label for="konten" :value="'Konten'" />
                            <textarea id="konten" name="konten" rows="10"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                                required>{{ old('konten', $post->konten) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('konten')" />
                        </div>

                        <div>
                            <x-input-label for="gambar_utama" :value="'Gambar Utama (Upload)'" />

                            @if (!empty($post->gambar_utama_path))
                                <div class="mt-2 mb-3">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                        Gambar Saat Ini:
                                    </p>
                                    <img src="{{ Storage::url($post->gambar_utama_path) }}"
                                         alt="Gambar"
                                         class="h-20 w-20 object-cover object-center rounded-md border border-gray-200 dark:border-gray-800">
                                </div>
                            @endif

                            <input id="gambar_utama" name="gambar_utama" type="file" accept="image/*"
                                   class="mt-1 block w-full text-gray-900 dark:text-gray-100
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-600 file:text-white
                                          hover:file:bg-indigo-700" />
                            <p class="mt-1 text-xs text-gray-700 dark:text-gray-300">
                                Upload gambar baru jika ingin mengganti. JPG/PNG/WebP max 2MB.
                            </p>
                            <x-input-error class="mt-2" :messages="$errors->get('gambar_utama')" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="status" :value="'Status'" />
                                <select id="status" name="status"
                                        class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="draft" @selected(old('status', $post->status)==='draft')>Draft</option>
                                    <option value="published" @selected(old('status', $post->status)==='published')>Published</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div>
                                <x-input-label for="published_at" :value="'Published At (opsional)'" />
                                <input id="published_at" name="published_at" type="datetime-local"
                                       value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('published_at')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="sort_order" :value="'Urutan (sort order)'" />
                                <x-text-input id="sort_order" name="sort_order" type="number" min="0"
                                    class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100 dark:border-gray-700"
                                    :value="old('sort_order', $post->sort_order ?? 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                            </div>

                            <div class="flex flex-col justify-end gap-3 pt-2">
                                <label class="inline-flex items-center gap-2 text-gray-900 dark:text-gray-100">
                                    <input type="checkbox" name="ditampilkan_di_beranda" value="1"
                                           class="rounded border-gray-300 dark:border-gray-700"
                                           @checked(old('ditampilkan_di_beranda', (bool)$post->ditampilkan_di_beranda))>
                                    <span class="text-sm font-semibold">Ditampilkan di Beranda</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <x-input-label :value="'Kategori (opsional)'" />
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @forelse($categories as $cat)
                                    <label class="flex items-center gap-2 text-gray-900 dark:text-gray-100">
                                        <input type="checkbox" name="categories[]"
                                               value="{{ $cat->id }}"
                                               class="rounded border-gray-300 dark:border-gray-700"
                                               @checked(in_array($cat->id, old('categories', $selectedCategoryIds ?? [])))>
                                        <span class="text-sm font-semibold">{{ $cat->nama }}</span>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        Belum ada kategori.
                                    </p>
                                @endforelse
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('categories')" />
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                                Update
                            </button>

                            <a href="{{ route($routeBase.'.index') }}"
                               class="px-5 py-2 rounded-md bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm font-semibold">
                                Batal
                            </a>
                        </div>
                    </form>

                    <div class="mt-6 border-t border-gray-200 dark:border-gray-800 pt-6">
                        <form method="POST" action="{{ route($routeBase.'.destroy', $post) }}"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-5 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm font-semibold">
                                Delete {{ $label }}
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
