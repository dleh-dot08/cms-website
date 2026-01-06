<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Detail Jenjang</h2>
                <p class="text-sm text-gray-600">{{ $jenjang->nama }}</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.jenjangs.edit', $jenjang) }}"
                   class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                    Edit
                </a>
                <a href="{{ route('admin.jenjangs.index') }}"
                   class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6 space-y-4">
                    <div>
                        <div class="text-sm text-gray-600">Kategori Program</div>
                        <div class="text-base font-semibold text-gray-900">{{ $jenjang->programCategory?->nama ?? '-' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">Nama Jenjang</div>
                        <div class="text-base font-semibold text-gray-900">{{ $jenjang->nama }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">Aktif</div>
                        <div class="text-base font-semibold text-gray-900">{{ $jenjang->is_active ? 'YA' : 'TIDAK' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600">Urutan</div>
                        <div class="text-base font-semibold text-gray-900">{{ $jenjang->sort_order }}</div>
                    </div>

                    <div class="pt-2">
                        <form method="POST" action="{{ route('admin.jenjangs.destroy', $jenjang) }}"
                              onsubmit="return confirm('Yakin ingin menghapus jenjang ini?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="px-5 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm font-semibold">
                                Delete Jenjang
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
