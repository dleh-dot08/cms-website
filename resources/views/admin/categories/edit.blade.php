<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900">
                Edit Category
            </h2>

            <a href="{{ route('admin.categories.index') }}"
               class="text-sm font-semibold text-gray-900 hover:underline">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-medium text-green-900">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nama" :value="'Nama Category'" />
                            <x-text-input id="nama" name="nama" type="text"
                                          class="mt-1 block w-full"
                                          :value="old('nama', $category->nama)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <div>
                            <x-input-label :value="'Slug (otomatis)'" />
                            <div class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $category->slug }}
                            </div>
                            <p class="mt-1 text-xs text-gray-600">
                                Slug akan berubah otomatis jika Nama berubah.
                            </p>
                        </div>

                        <div>
                            <x-input-label for="jenis" :value="'Jenis (opsional)'" />
                            <select id="jenis" name="jenis"
                                    class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="" @selected(old('jenis', $category->jenis)==='')>Umum</option>
                                <option value="blog" @selected(old('jenis', $category->jenis)==='blog')>Blog</option>
                                <option value="news" @selected(old('jenis', $category->jenis)==='news')>News</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis')" />
                        </div>

                        <div>
                            <x-input-label for="sort_order" :value="'Urutan (sort order)'" />
                            <x-text-input id="sort_order" name="sort_order" type="number" min="0"
                                          class="mt-1 block w-full"
                                          :value="old('sort_order', $category->sort_order ?? 0)" />
                            <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                    class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                                Update
                            </button>

                            <a href="{{ route('admin.categories.index') }}"
                               class="px-5 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">
                                Batal
                            </a>
                        </div>
                    </form>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                              onsubmit="return confirm('Yakin ingin menghapus category ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-5 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm font-semibold">
                                Delete Category
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
