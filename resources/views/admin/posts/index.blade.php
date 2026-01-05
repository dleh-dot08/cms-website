@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
                Content — {{ $label }}
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

            {{-- Filter --}}
            <div class="bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="p-5">
                    <form method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-900 dark:text-gray-100 mb-1">Cari</label>
                            <input type="text" name="q" value="{{ $q }}"
                                   placeholder="Cari judul / slug..."
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 dark:text-gray-100 mb-1">Status</label>
                            <select name="status"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua</option>
                                <option value="draft" @selected($status==='draft')>Draft</option>
                                <option value="published" @selected($status==='published')>Published</option>
                            </select>
                        </div>

                        <div class="sm:col-span-3 flex gap-2">
                            <button class="px-4 py-2 rounded-md bg-gray-900 hover:bg-black text-white text-sm font-semibold">
                                Terapkan
                            </button>
                            <a href="{{ route($routeBase.'.index') }}"
                               class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm font-semibold">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="p-5 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-800">
                            <tr class="text-left">
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Gambar</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Judul</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Status</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Beranda</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Publish</th>
                                <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            @forelse ($items as $row)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-4 py-3">
                                        @if (!empty($row->gambar_utama_path))
                                            <img src="{{ Storage::url($row->gambar_utama_path) }}"
                                                 alt="Gambar"
                                                 class="h-9 w-9 object-cover object-center rounded border border-gray-200 dark:border-gray-800">
                                        @else
                                            <div class="h-9 w-9 rounded border border-gray-200 dark:border-gray-800
                                                        bg-gray-100 dark:bg-gray-800 flex items-center justify-center
                                                        text-[10px] font-bold text-gray-700 dark:text-gray-200">
                                                N/A
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $row->judul }}
                                        </div>
                                        <div class="text-xs text-gray-700 dark:text-gray-300">
                                            /{{ $row->slug }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs font-bold
                                            {{ $row->status === 'published'
                                                ? 'bg-green-100 text-green-900 dark:bg-green-900/40 dark:text-green-100'
                                                : 'bg-yellow-100 text-yellow-900 dark:bg-yellow-900/40 dark:text-yellow-100' }}">
                                            {{ strtoupper($row->status) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs font-bold
                                            {{ $row->ditampilkan_di_beranda
                                                ? 'bg-indigo-100 text-indigo-900 dark:bg-indigo-900/40 dark:text-indigo-100'
                                                : 'bg-gray-200 text-gray-900 dark:bg-gray-800 dark:text-gray-100' }}">
                                            {{ $row->ditampilkan_di_beranda ? 'YA' : 'TIDAK' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-gray-900 dark:text-gray-100">
                                        {{ $row->published_at?->format('Y-m-d H:i') ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-right">
                                        <div class="inline-flex gap-3">
                                            <a href="{{ route($routeBase.'.show', $row) }}"
                                               class="text-gray-900 dark:text-gray-100 font-semibold hover:underline">
                                                Show
                                            </a>
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
                                    <td colspan="6" class="px-4 py-8 text-center font-medium text-gray-800 dark:text-gray-200">
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
