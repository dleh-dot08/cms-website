<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900">Management — Kursus</h2>
            <a href="{{ route('admin.courses.create') }}"
               class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                + Tambah Kursus
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-5">
                    <form method="GET" class="flex gap-2">
                        <input type="text" name="q" value="{{ $q }}"
                               placeholder="Cari nama kursus..."
                               class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <button class="px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-semibold">Cari</button>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-5 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr class="text-left">
                                <th class="px-4 py-3 font-semibold text-gray-900">Nama</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Kategori</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Jenjang</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Sub Program</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Total Pertemuan</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($items as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $row->nama_kursus }}</td>
                                    <td class="px-4 py-3 text-gray-800">{{ $row->programCategory?->nama }}</td>
                                    <td class="px-4 py-3 text-gray-800">{{ $row->jenjang?->nama }}</td>
                                    <td class="px-4 py-3 text-gray-800">{{ $row->subProgram?->nama }}</td>
                                    <td class="px-4 py-3 text-gray-900">{{ $row->total_pertemuan }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex gap-3">
                                            <a class="font-semibold text-gray-900 hover:underline"
                                               href="{{ route('admin.courses.show', $row) }}">Show</a>
                                            <a class="font-semibold text-indigo-700 hover:underline"
                                               href="{{ route('admin.courses.edit', $row) }}">Edit</a>
                                            <form method="POST" action="{{ route('admin.courses.destroy', $row) }}"
                                                  onsubmit="return confirm('Hapus kursus ini?');">
                                                @csrf @method('DELETE')
                                                <button class="font-semibold text-red-700 hover:underline">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-800 font-medium">Belum ada kursus.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-5">{{ $items->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
