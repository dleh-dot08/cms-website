<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Daftar Peserta
            </h2>

            <a href="{{ route('admin.peserta.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">
                + Tambah Peserta
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded">
                    <p class="text-green-800 dark:text-green-200 text-sm">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="py-3 pr-4">Nama</th>
                                    <th class="py-3 pr-4">Email</th>
                                    <th class="py-3 pr-4">Dibuat</th>
                                    <th class="py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($participants as $p)
                                    <tr>
                                        <td class="py-3 pr-4">{{ $p->name }}</td>
                                        <td class="py-3 pr-4">{{ $p->email }}</td>
                                        <td class="py-3 pr-4">{{ $p->created_at?->format('d M Y') }}</td>
                                        <td class="py-3 text-right">
                                            <form method="POST"
                                                  action="{{ route('admin.peserta.destroy', $p) }}"
                                                  onsubmit="return confirm('Hapus peserta ini?');"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 dark:text-red-400 hover:underline">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-gray-500 dark:text-gray-400">
                                            Belum ada peserta.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $participants->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
