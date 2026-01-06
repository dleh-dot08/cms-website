<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900">Divisi</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg border border-gray-200 p-6">
                <p class="text-gray-900 font-semibold">Halaman show tidak digunakan.</p>
                <a href="{{ route('admin.divisions.index') }}"
                   class="mt-3 inline-block px-4 py-2 rounded-md bg-gray-200 text-gray-900 font-semibold hover:bg-gray-300">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
