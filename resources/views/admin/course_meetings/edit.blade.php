{{-- resources/views/admin/course_meetings/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Edit Pertemuan</h2>
                <p class="text-sm text-gray-600 mt-1">
                    Kursus: <span class="font-semibold">{{ $course->nama_kursus ?? $course->nama ?? '-' }}</span>
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.courses.show', $course) }}"
                   class="text-sm font-semibold text-gray-900 hover:underline">
                    ← Kembali ke Kursus
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST"
                          action="{{ route('admin.course_meetings.update', [$course, $meeting]) }}"
                          class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Pertemuan Ke</label>
                                <input name="pertemuan_ke" type="number" min="1"
                                       value="{{ old('pertemuan_ke', $meeting->pertemuan_ke) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
                                <x-input-error class="mt-2" :messages="$errors->get('pertemuan_ke')" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Durasi (menit)</label>
                                <input name="durasi_menit" type="number" min="0"
                                       value="{{ old('durasi_menit', $meeting->durasi_menit) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('durasi_menit')" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Judul</label>
                            <input name="judul" type="text"
                                   value="{{ old('judul', $meeting->judul) }}"
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Contoh: Pengenalan Robotik">
                            <x-input-error class="mt-2" :messages="$errors->get('judul')" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Materi Singkat</label>
                            <textarea name="materi_singkat" rows="3"
                                      class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Ringkasan 2-4 kalimat...">{{ old('materi_singkat', $meeting->materi_singkat) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('materi_singkat')" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Materi Detail</label>
                            <textarea name="materi_detail" rows="8"
                                      class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Boleh isi detail materi lengkap...">{{ old('materi_detail', $meeting->materi_detail) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('materi_detail')" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Urutan</label>
                                <input name="sort_order" type="number" min="0"
                                       value="{{ old('sort_order', $meeting->sort_order ?? 0) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                            </div>

                            <div class="flex items-end">
                                <label class="inline-flex items-center gap-2 text-gray-900">
                                    <input type="checkbox" name="is_active" value="1"
                                           class="rounded border-gray-300"
                                           @checked(old('is_active', (bool)($meeting->is_active ?? true)))>
                                    <span class="text-sm font-semibold">Aktif (Tampil di Public)</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                                Simpan Perubahan
                            </button>

                            <a href="{{ route('admin.courses.show', $course) }}"
                               class="px-5 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">
                                Batal
                            </a>

                            <button type="button"
                                    onclick="if(confirm('Hapus pertemuan ini?')) document.getElementById('deleteForm').submit();"
                                    class="ml-auto px-5 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm font-semibold">
                                Hapus
                            </button>
                        </div>
                    </form>

                    <form id="deleteForm" method="POST"
                          action="{{ route('admin.course_meetings.destroy', [$course, $meeting]) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
