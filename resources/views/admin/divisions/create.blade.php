<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Tambah Divisi</h2>
                <p class="mt-1 text-sm text-gray-700 font-medium">Buat divisi baru untuk recruitment.</p>
            </div>
            <a href="{{ route('admin.divisions.index') }}"
               class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.divisions.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Nama Divisi</label>
                            <input type="text" name="nama" required
                                   value="{{ old('nama') }}"
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="contoh: Edu, Marketing, Tech">
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Urutan</label>
                            <input type="number" min="0" name="sort_order"
                                   value="{{ old('sort_order', 0) }}"
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" value="1"
                                   class="rounded border-gray-300"
                                   @checked(old('is_active', true))>
                            <label class="text-sm font-semibold text-gray-900">Aktif</label>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                    class="px-5 py-2 rounded-md bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                                Simpan
                            </button>
                            <a href="{{ route('admin.divisions.index') }}"
                               class="px-5 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold hover:bg-gray-300">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
