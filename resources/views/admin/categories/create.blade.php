<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900">
                Tambah Category
            </h2>

            <a href="{{ route('admin.categories.index') }}"
               class="text-sm font-semibold text-gray-900 hover:underline">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="nama" :value="'Nama Category'" />
                            <x-text-input id="nama" name="nama" type="text"
                                          class="mt-1 block w-full"
                                          :value="old('nama')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <div>
                            <x-input-label for="jenis" :value="'Jenis (opsional)'" />
                            <select id="jenis" name="jenis"
                                    class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" @selected(old('jenis')==='')>Umum</option>
                                <option value="blog" @selected(old('jenis')==='blog')>Blog</option>
                                <option value="news" @selected(old('jenis')==='news')>News</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-600">Kalau Umum, category bisa dipakai untuk Blog/News.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis')" />
                        </div>

                        <div>
                            <x-input-label for="sort_order" :value="'Urutan (sort order)'" />
                            <x-text-input id="sort_order" name="sort_order" type="number" min="0"
                                          class="mt-1 block w-full"
                                          :value="old('sort_order', 0)" />
                            <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                    class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                                Simpan
                            </button>

                            <a href="{{ route('admin.categories.index') }}"
                               class="px-5 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">
                                Batal
                            </a>
                        </div>

                        <p class="text-xs text-gray-600">
                            Slug akan dibuat otomatis dari nama dan dibuat unik.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
