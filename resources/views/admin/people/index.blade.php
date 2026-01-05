@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
                Management Data — {{ $label }}
            </h2>

            <a href="{{ route($routeBase.'.create') }}"
               class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                + Tambah {{ $label }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 dark:border-green-800 bg-green-50 dark:bg-green-900/30 px-4 py-3">
                    <p class="text-sm font-medium text-green-900 dark:text-green-100">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="p-5 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-800">
                            <tr class="text-left">
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Foto</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Nama</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Title</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Ditampilkan di Beranda</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Aktif</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Urutan</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse ($items as $row)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-4 py-3">
                                        @if (!empty($row->foto_path))
                                            <img src="{{ Storage::url($row->foto_path) }}"
                                                 alt="Foto"
                                                 class="h-9 w-9 object-cover object-center rounded border border-gray-200 dark:border-gray-800" />
                                        @else
                                            <div class="h-9 w-9 rounded border border-gray-200 dark:border-gray-800
                                                        bg-gray-100 dark:bg-gray-800 flex items-center justify-center
                                                        text-[10px] font-bold text-gray-700 dark:text-gray-200">
                                                N/A
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                        {{ $row->name }}
                                    </td>

                                    <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                        {{ $row->title }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs font-bold
                                            {{ $row->ditampilkan_di_beranda
                                                ? 'bg-indigo-100 text-indigo-900 dark:bg-indigo-900/40 dark:text-indigo-100'
                                                : 'bg-gray-200 text-gray-900 dark:bg-gray-800 dark:text-gray-100' }}">
                                            {{ $row->ditampilkan_di_beranda ? 'YA' : 'TIDAK' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs font-bold
                                            {{ $row->is_active
                                                ? 'bg-green-100 text-green-900 dark:bg-green-900/40 dark:text-green-100'
                                                : 'bg-red-100 text-red-900 dark:bg-red-900/40 dark:text-red-100' }}">
                                            {{ $row->is_active ? 'AKTIF' : 'NONAKTIF' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                        {{ $row->sort_order }}
                                    </td>

                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex gap-3">
                                            <a href="{{ route($routeBase.'.edit', $row) }}"
                                               class="text-indigo-700 dark:text-indigo-300 font-semibold hover:underline">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route($routeBase.'.destroy', $row) }}"
                                                  onsubmit="return confirm('Hapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-700 dark:text-red-300 font-semibold hover:underline">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center font-medium text-gray-800 dark:text-gray-200">
                                        Belum ada data.
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
