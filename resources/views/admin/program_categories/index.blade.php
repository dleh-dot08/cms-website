<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900">Management — Kategori Program</h2>
            <a href="{{ route('admin.program_categories.create') }}"
               class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                + Tambah
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-5">
                    <form method="GET" class="flex gap-2">
                        <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama..."
                               class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <button class="px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-semibold">Cari</button>
                        <a href="{{ route('admin.program_categories.index') }}"
                           class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">Reset</a>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-5 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr class="text-left">
                                <th class="px-4 py-3 font-semibold text-gray-900">Nama</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Aktif</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Urutan</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($items as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $row->nama }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs font-bold {{ $row->is_active ? 'bg-green-100 text-green-900' : 'bg-gray-200 text-gray-900' }}">
                                            {{ $row->is_active ? 'YA' : 'TIDAK' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-900">{{ $row->sort_order }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex gap-3">
                                            <a class="font-semibold text-gray-900 hover:underline" href="{{ route('admin.program_categories.show', $row) }}">Show</a>
                                            <a class="font-semibold text-indigo-700 hover:underline" href="{{ route('admin.program_categories.edit', $row) }}">Edit</a>
                                            <form method="POST" action="{{ route('admin.program_categories.destroy', $row) }}" onsubmit="return confirm('Hapus data ini?');">
                                                @csrf @method('DELETE')
                                                <button class="font-semibold text-red-700 hover:underline">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-8 text-center font-medium text-gray-800">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-5">{{ $items->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
