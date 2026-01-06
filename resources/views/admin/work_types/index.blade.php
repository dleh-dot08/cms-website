<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Tipe Kerja</h2>
                <p class="mt-1 text-sm text-gray-700 font-medium">Kelola tipe kerja untuk filter recruitment.</p>
            </div>
            <a href="{{ route('admin.work_types.create') }}"
               class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                + Tambah Tipe Kerja
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-semibold text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 text-gray-900">
                                    <th class="py-3 pr-4 text-left font-bold">Nama</th>
                                    <th class="py-3 pr-4 text-left font-bold">Status</th>
                                    <th class="py-3 pr-4 text-left font-bold">Urutan</th>
                                    <th class="py-3 text-right font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($workTypes as $workType)
                                    <tr class="text-gray-900">
                                        <td class="py-3 pr-4 font-semibold">{{ $workType->nama }}</td>
                                        <td class="py-3 pr-4">
                                            @if($workType->is_active)
                                                <span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-800 font-semibold">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded bg-gray-200 text-gray-800 font-semibold">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-4">{{ $workType->sort_order }}</td>
                                        <td class="py-3 text-right">
                                            <div class="inline-flex items-center gap-2">
                                                <a href="{{ route('admin.work_types.edit', $workType) }}"
                                                   class="px-3 py-1.5 rounded-md bg-gray-200 text-gray-900 font-semibold hover:bg-gray-300">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.work_types.destroy', $workType) }}"
                                                      onsubmit="return confirm('Yakin hapus tipe kerja ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-3 py-1.5 rounded-md bg-red-600 text-white font-semibold hover:bg-red-700">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-gray-700 font-medium">
                                            Belum ada data tipe kerja.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $workTypes->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
