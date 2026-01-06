<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Show Kategori Program</h2>
                <p class="text-sm text-gray-600">{{ $programCategory->nama }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.program_categories.edit', $programCategory) }}"
                   class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">Edit</a>
                <a href="{{ route('admin.program_categories.index') }}"
                   class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">Kembali</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6 space-y-3">
                    <div class="text-sm text-gray-600">Nama</div>
                    <div class="font-semibold text-gray-900">{{ $programCategory->nama }}</div>

                    <div class="text-sm text-gray-600">Aktif</div>
                    <div class="font-semibold text-gray-900">{{ $programCategory->is_active ? 'YA' : 'TIDAK' }}</div>

                    <div class="text-sm text-gray-600">Urutan</div>
                    <div class="font-semibold text-gray-900">{{ $programCategory->sort_order }}</div>

                    <div class="text-sm text-gray-600">Total Jenjang</div>
                    <div class="font-semibold text-gray-900">{{ $programCategory->jenjangs_count }}</div>

                    <div class="text-sm text-gray-600">Total Sub Program</div>
                    <div class="font-semibold text-gray-900">{{ $programCategory->sub_programs_count }}</div>

                    <div class="text-sm text-gray-600">Total Kursus</div>
                    <div class="font-semibold text-gray-900">{{ $programCategory->courses_count }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
