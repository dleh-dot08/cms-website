<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                Management Data — Users
            </h2>

            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition">
                + Tambah User
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
                <div class="p-5">

                    <form method="GET" class="flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between mb-4">
                        <div class="w-full sm:w-96">
                            <input type="text" name="q" value="{{ $q }}"
                                   placeholder="Cari nama / email / role…"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500" />
                        </div>
                        <div class="flex gap-2">
                            <button class="px-4 py-2 rounded-md bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 text-sm font-semibold">
                                Cari
                            </button>
                            <a href="{{ route('admin.users.index') }}"
                               class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm font-semibold">
                                Reset
                            </a>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr class="text-left">
                                    <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Nama</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Email</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Role</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100">Dibuat</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 dark:text-gray-100 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @forelse ($users as $u)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $u->name }}</td>
                                        <td class="px-4 py-3 text-gray-900 dark:text-gray-100">{{ $u->email }}</td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold
                                                bg-indigo-100 text-indigo-900
                                                dark:bg-indigo-900/40 dark:text-indigo-100">
                                                {{ $u->role }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gray-800 dark:text-gray-200">
                                            {{ optional($u->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="inline-flex items-center gap-3">
                                                <a href="{{ route('admin.users.edit', $u) }}"
                                                   class="text-indigo-700 dark:text-indigo-300 font-semibold hover:underline">
                                                    Edit
                                                </a>

                                                <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                                      onsubmit="return confirm('Hapus user ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-700 dark:text-red-300 font-semibold hover:underline">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-800 dark:text-gray-200 font-medium">
                                            Belum ada user.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
