<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900">Tambah Pertemuan</h2>
            <a href="{{ route('admin.courses.edit', $course) }}" class="text-sm font-semibold text-gray-900 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.course_meetings.store', $course) }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Pertemuan Ke</label>
                            <input name="pertemuan_ke" type="number" min="1" value="{{ old('pertemuan_ke', 1) }}" required
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Judul</label>
                            <input name="judul" type="text" value="{{ old('judul') }}"
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Materi Singkat</label>
                            <textarea name="materi_singkat" rows="3"
                                      class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('materi_singkat') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Materi Detail</label>
                            <textarea name="materi_detail" rows="8"
                                      class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('materi_detail') }}</textarea>
                        </div>

                        <div class="flex gap-2">
                            <button class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">Simpan</button>
                            <a href="{{ route('admin.courses.edit', $course) }}" class="px-5 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
