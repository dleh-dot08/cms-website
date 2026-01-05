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
                            <x-input-label for="name" :value="'Nama'" />
                            <x-text-input id="name" name="name" type="text"
                                class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100 dark:border-gray-700"
                                :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="title" :value="'Title / Jabatan'" />
                            <x-text-input id="title" name="title" type="text"
                                class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100 dark:border-gray-700"
                                :value="old('title')" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div>
                            <x-input-label for="foto" :value="'Foto (Upload)'" />
                            <input id="foto" name="foto" type="file" accept="image/*"
                                   class="mt-1 block w-full text-gray-900 dark:text-gray-100
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-600 file:text-white
                                          hover:file:bg-indigo-700" />
                            <p class="mt-1 text-xs text-gray-700 dark:text-gray-300">
                                JPG/PNG/WebP, max 2MB.
                            </p>
                            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
                        </div>

                        <div>
                            <x-input-label for="bio" :value="'Bio'" />
                            <textarea id="bio" name="bio" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">{{ old('bio') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
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

                                <label class="inline-flex items-center gap-2 text-gray-900 dark:text-gray-100">
                                    <input type="checkbox" name="is_active" value="1"
                                           class="rounded border-gray-300 dark:border-gray-700"
                                           @checked(old('is_active', true))>
                                    <span class="text-sm font-semibold">Aktif</span>
                                </label>
                            </div>
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
