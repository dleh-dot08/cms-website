<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-900">
                Content — Categories
            </h2>

            <a href="{{ route('admin.categories.create') }}"
               class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                + Tambah Category
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-medium text-green-900">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- Filter --}}
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-5">
                    <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-900 mb-1">Cari</label>
                            <input type="text" name="q" value="{{ $q }}"
                                   placeholder="Cari nama / slug..."
                                   class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-1">Jenis</label>
                            <select name="jenis"
                                    class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua</option>
                                <option value="blog" @selected($jenis==='blog')>Blog</option>
                                <option value="news" @selected($jenis==='news')>News</option>
                            </select>
                        </div>

                        <div class="sm:col-span-3 flex gap-2">
                            <button class="px-4 py-2 rounded-md bg-gray-900 hover:bg-black text-white text-sm font-semibold">
                                Terapkan
                            </button>
                            <a href="{{ route('admin.categories.index') }}"
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
                                <th class="px-4 py-3 font-semibold text-gray-900">Nama</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Slug</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Jenis</th>
                                <th class="px-4 py-3 font-semibold text-gray-900">Urutan</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse($items as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-semibold text-gray-900">{{ $row->nama }}</td>
                                    <td class="px-4 py-3 text-gray-800">{{ $row->slug }}</td>
                                    <td class="px-4 py-3 text-gray-800">{{ $row->jenis ?? 'umum' }}</td>
                                    <td class="px-4 py-3 text-gray-900">{{ $row->sort_order }}</td>

                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex gap-3">
                                            <a href="{{ route('admin.categories.show', $row) }}"
                                               class="text-gray-900 font-semibold hover:underline">
                                                Show
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $row) }}"
                                               class="text-indigo-700 font-semibold hover:underline">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route('admin.categories.destroy', $row) }}"
                                                  onsubmit="return confirm('Hapus category ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-700 font-semibold hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center font-medium text-gray-800">
                                        Belum ada category.
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
