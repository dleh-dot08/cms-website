<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900">Management — Sub Program</h2>

            <a href="{{ route('admin.sub_programs.create') }}"
               class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                + Tambah Sub Program
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

            {{-- Filter --}}
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-5">
                    <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-900 mb-1">Cari</label>
                            <input type="text" name="q" value="{{ $q ?? request('q') }}"
                                   placeholder="Cari nama sub program..."
                                   class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-1">Kategori Program</label>
                            <select name="program_category_id"
                                    class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}"
                                        @selected((string)($programCategoryId ?? request('program_category_id')) === (string)$c->id)>
                                        {{ $c->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-3 flex gap-2">
                            <button class="px-4 py-2 rounded-md bg-gray-900 hover:bg-black text-white text-sm font-semibold">
                                Terapkan
                            </button>
                            <a href="{{ route('admin.sub_programs.index') }}"
                               class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-5 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr class="text-left">
                                <th class="px-4 py-3 font-semibold text-gray-900">Kategori Program</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Nama Sub Program</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Aktif</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Urutan</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse($items as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-900">
                                        {{ $row->programCategory?->nama ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 font-semibold text-gray-900">
                                        {{ $row->nama }}
                                    </td>

                                    <td class="px-4 py-3">
                                        @if($row->is_active)
                                            <span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-900">
                                                YA
                                            </span>
                                        @else
                                            <span class="px-2 py-1 rounded text-xs font-bold bg-gray-200 text-gray-900">
                                                TIDAK
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-gray-900">{{ $row->sort_order }}</td>

                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex gap-3">
                                            <a href="{{ route('admin.sub_programs.show', $row) }}"
                                               class="font-semibold text-gray-900 hover:underline">
                                                Show
                                            </a>
                                            <a href="{{ route('admin.sub_programs.edit', $row) }}"
                                               class="font-semibold text-indigo-700 hover:underline">
                                                Edit
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('admin.sub_programs.destroy', $row) }}"
                                                  onsubmit="return confirm('Hapus sub program ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="font-semibold text-red-700 hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center font-medium text-gray-800">
                                        Belum ada data sub program.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-5">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
