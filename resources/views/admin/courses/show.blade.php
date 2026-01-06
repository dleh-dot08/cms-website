<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Detail Kursus</h2>
                <p class="mt-1 text-sm text-gray-700 font-medium">
                    {{ $course->nama_kursus }}
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.courses.edit', $course) }}"
                   class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                    Edit
                </a>
                <a href="{{ route('admin.courses.index') }}"
                   class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Ringkasan --}}
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        @if($course->foto_kursus_path)
                            <div class="mb-5">
                                <div class="text-sm text-gray-600 mb-2">Foto Kursus</div>
                                <img src="{{ asset('storage/'.$course->foto_kursus_path) }}"
                                    class="w-full max-w-md h-56 object-cover rounded-lg border border-gray-200"
                                    alt="Foto kursus">
                            </div>
                        @endif
                        
                        <div>
                            <div class="text-sm text-gray-600">Kategori Program</div>
                            <div class="mt-1 font-semibold text-gray-900">
                                {{ $course->programCategory?->nama ?? '-' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Jenjang</div>
                            <div class="mt-1 font-semibold text-gray-900">
                                {{ $course->jenjang?->nama ?? '-' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Sub Program</div>
                            <div class="mt-1 font-semibold text-gray-900">
                                {{ $course->subProgram?->nama ?? '-' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Periode Waktu</div>
                            <div class="mt-1 font-semibold text-gray-900">
                                {{ $course->periode_waktu ?: '-' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Level</div>
                            <div class="mt-1 font-semibold text-gray-900">
                                {{ $course->level ?: '-' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Total Pertemuan</div>
                            <div class="mt-1 font-semibold text-gray-900">
                                {{ $course->total_pertemuan }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Durasi (menit/pertemuan)</div>
                            <div class="mt-1 font-semibold text-gray-900">
                                {{ $course->durasi_menit ?? '-' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Pelaksanaan</div>
                            <div class="mt-1 font-semibold text-gray-900">
                                {{ $course->pelaksanaan ?: '-' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Sertifikat</div>
                            <div class="mt-1">
                                @if($course->mendapatkan_sertifikat)
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-900">YA</span>
                                @else
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-bold bg-gray-200 text-gray-900">TIDAK</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Status</div>
                            <div class="mt-1">
                                @if($course->is_active)
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-900">AKTIF</span>
                                @else
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-bold bg-gray-200 text-gray-900">NONAKTIF</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Urutan</div>
                            <div class="mt-1 font-semibold text-gray-900">{{ $course->sort_order }}</div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-600">Dibuat oleh</div>
                            <div class="mt-1 font-semibold text-gray-900">
                                {{ $course->author?->name ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <div class="text-sm text-gray-600">Deskripsi Program</div>
                        <div class="mt-2 text-gray-900 leading-relaxed whitespace-pre-line">
                            {{ $course->deskripsi_program ?: '-' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pertemuan --}}
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between gap-3">
                        <h3 class="font-semibold text-lg text-gray-900">
                            Daftar Pertemuan
                        </h3>

                        <a href="{{ route('admin.course_meetings.create', $course) }}"
                           class="px-4 py-2 rounded-md bg-gray-900 hover:bg-black text-white text-sm font-semibold">
                            + Tambah Pertemuan
                        </a>
                    </div>

                    <div class="mt-4 overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-100">
                                <tr class="text-left">
                                    <th class="px-4 py-3 font-semibold text-gray-900">Ke</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Judul</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Materi Singkat</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900">Durasi</th>
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-right">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse($course->meetings as $m)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-semibold text-gray-900">
                                            {{ $m->pertemuan_ke }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-900">
                                            {{ $m->judul ?: '-' }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-800">
                                            {{ $m->materi_singkat ?: '-' }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-900">
                                            {{ $m->durasi_menit ? $m->durasi_menit.' menit' : '-' }}
                                        </td>

                                        <td class="px-4 py-3 text-right">
                                            <div class="inline-flex gap-3">
                                                <a href="{{ route('admin.course_meetings.edit', [$course, $m]) }}"
                                                   class="font-semibold text-indigo-700 hover:underline">
                                                    Edit
                                                </a>

                                                <form method="POST"
                                                      action="{{ route('admin.course_meetings.destroy', [$course, $m]) }}"
                                                      onsubmit="return confirm('Hapus pertemuan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="font-semibold text-red-700 hover:underline">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center font-medium text-gray-800">
                                            Belum ada pertemuan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Hapus kursus --}}
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h3 class="font-semibold text-lg text-gray-900">Hapus Kursus</h3>
                            <p class="text-sm text-gray-700">Aksi ini akan menghapus kursus beserta seluruh pertemuannya.</p>
                        </div>

                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                              onsubmit="return confirm('Yakin ingin menghapus kursus ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-5 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm font-semibold">
                                Delete Kursus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
