<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Edit Lokasi</h2>
                <p class="mt-1 text-sm text-gray-700 font-medium">{{ $location->nama }}</p>
            </div>
            <a href="{{ route('admin.locations.index') }}"
               class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-semibold text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.locations.update', $location) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Nama Lokasi</label>
                            <input type="text" name="nama" required
                                   value="{{ old('nama', $location->nama) }}"
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Urutan</label>
                            <input type="number" min="0" name="sort_order"
                                   value="{{ old('sort_order', $location->sort_order) }}"
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" value="1"
                                   class="rounded border-gray-300"
                                   @checked(old('is_active', (bool)$location->is_active))>
                            <label class="text-sm font-semibold text-gray-900">Aktif</label>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                    class="px-5 py-2 rounded-md bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                                Update
                            </button>
                            <a href="{{ route('admin.locations.index') }}"
                               class="px-5 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold hover:bg-gray-300">
                                Batal
                            </a>
                        </div>
                    </form>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="font-semibold text-gray-900">Hapus Lokasi</h3>
                                <p class="text-sm text-gray-700">Jika lokasi dipakai oleh lowongan, data terkait ikut terhapus (cascade).</p>
                            </div>
                            <form method="POST" action="{{ route('admin.locations.destroy', $location) }}"
                                  onsubmit="return confirm('Yakin hapus lokasi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-5 py-2 rounded-md bg-red-600 text-white text-sm font-semibold hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
