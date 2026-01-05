<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
                Tambah {{ $label }}
            </h2>

            <a href="{{ route($routeBase.'.index') }}"
               class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:underline">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="p-6">
                    <form method="POST" action="{{ route($routeBase.'.store') }}"
                          enctype="multipart/form-data"
                          class="space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="judul" :value="'Judul'" />
                            <x-text-input id="judul" name="judul" type="text"
                                class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100 dark:border-gray-700"
                                :value="old('judul')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('judul')" />
                        </div>

                        <div>
                            <x-input-label for="ringkasan" :value="'Ringkasan (opsional)'" />
                            <textarea id="ringkasan" name="ringkasan" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">{{ old('ringkasan') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('ringkasan')" />
                        </div>

                        <div>
                            <x-input-label for="konten" :value="'Konten'" />
                            <textarea id="konten" name="konten" rows="10"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                                required>{{ old('konten') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('konten')" />
                        </div>

                        <div>
                            <x-input-label for="gambar_utama" :value="'Gambar Utama (Upload)'" />
                            <input id="gambar_utama" name="gambar_utama" type="file" accept="image/*"
                                   class="mt-1 block w-full text-gray-900 dark:text-gray-100
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-600 file:text-white
                                          hover:file:bg-indigo-700" />
                            <p class="mt-1 text-xs text-gray-700 dark:text-gray-300">JPG/PNG/WebP, max 2MB.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('gambar_utama')" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="status" :value="'Status'" />
                                <select id="status" name="status"
                                        class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="draft" @selected(old('status','draft')==='draft')>Draft</option>
                                    <option value="published" @selected(old('status')==='published')>Published</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div>
                                <x-input-label for="published_at" :value="'Published At (opsional)'" />
                                <input id="published_at" name="published_at" type="datetime-local"
                                       value="{{ old('published_at') }}"
                                       class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="mt-1 text-xs text-gray-700 dark:text-gray-300">
                                    Kalau status Published dan ini kosong, otomatis pakai waktu sekarang.
                                </p>
                                <x-input-error class="mt-2" :messages="$errors->get('published_at')" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="sort_order" :value="'Urutan (sort order)'" />
                                <x-text-input id="sort_order" name="sort_order" type="number" min="0"
                                    class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100 dark:border-gray-700"
                                    :value="old('sort_order', 0)" />
                                <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                            </div>

                            <div class="flex flex-col justify-end gap-3 pt-2">
                                <label class="inline-flex items-center gap-2 text-gray-900 dark:text-gray-100">
                                    <input type="checkbox" name="ditampilkan_di_beranda" value="1"
                                           class="rounded border-gray-300 dark:border-gray-700"
                                           @checked(old('ditampilkan_di_beranda'))>
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
                                               @checked(is_array(old('categories')) && in_array($cat->id, old('categories')))>
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
                                Simpan
                            </button>

                            <a href="{{ route($routeBase.'.index') }}"
                               class="px-5 py-2 rounded-md bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm font-semibold">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
