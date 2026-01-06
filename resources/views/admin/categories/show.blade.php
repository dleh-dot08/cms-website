<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">
                    Show Category
                </h2>
                <p class="text-sm text-gray-600">
                    {{ $category->nama }} ({{ $category->slug }})
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.categories.edit', $category) }}"
                   class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                    Edit
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6 space-y-3">
                    <div class="text-sm text-gray-600">Nama</div>
                    <div class="text-base font-semibold text-gray-900">{{ $category->nama }}</div>

                    <div class="text-sm text-gray-600 mt-3">Slug</div>
                    <div class="text-base font-semibold text-gray-900">{{ $category->slug }}</div>

                    <div class="text-sm text-gray-600 mt-3">Jenis</div>
                    <div class="text-base font-semibold text-gray-900">{{ $category->jenis ?? 'umum' }}</div>

                    <div class="text-sm text-gray-600 mt-3">Urutan</div>
                    <div class="text-base font-semibold text-gray-900">{{ $category->sort_order }}</div>

                    <div class="text-sm text-gray-600 mt-3">Total Post</div>
                    <div class="text-base font-semibold text-gray-900">{{ $postsCount }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
