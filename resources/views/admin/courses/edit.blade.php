<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900">Edit Kursus</h2>
            <a href="{{ route('admin.courses.index') }}" class="text-sm font-semibold text-gray-900 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Form update --}}
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="space-y-5">
                        @csrf @method('PUT')

                        {{-- ===== MASTER RELATION ===== --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Kategori Program</label>
                                <select name="program_category_id" required
                                        class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- pilih --</option>
                                    @foreach($categories as $c)
                                        <option value="{{ $c->id }}"
                                            @selected(old('program_category_id', $course->program_category_id) == $c->id)>
                                            {{ $c->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('program_category_id')" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Jenjang</label>
                                <select name="jenjang_id" required
                                        class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- pilih --</option>
                                    @foreach($jenjangs as $j)
                                        <option value="{{ $j->id }}"
                                            @selected(old('jenjang_id', $course->jenjang_id) == $j->id)>
                                            {{ $j->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jenjang_id')" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Sub Program</label>
                                <select name="sub_program_id" required
                                        class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- pilih --</option>
                                    @foreach($subPrograms as $sp)
                                        <option value="{{ $sp->id }}"
                                            @selected(old('sub_program_id', $course->sub_program_id) == $sp->id)>
                                            {{ $sp->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('sub_program_id')" />
                            </div>
                        </div>

                        <div class="border-t border-gray-200"></div>

                        {{-- ===== DATA KURSUS ===== --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-gray-900">Nama Kursus</label>
                                <input type="text" name="nama_kursus" required
                                       value="{{ old('nama_kursus', $course->nama_kursus) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="contoh: Kelas 11 - Intrakurikuler">
                                <x-input-error class="mt-2" :messages="$errors->get('nama_kursus')" />
                            </div>

                            {{-- FOTO KURSUS --}}
                            <div class="sm:col-span-2 space-y-3">
                                <label class="block text-sm font-semibold text-gray-900">Foto Kursus</label>

                                @if($course->foto_kursus_path)
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset('storage/'.$course->foto_kursus_path) }}"
                                             class="w-48 h-28 object-cover rounded-md border border-gray-200"
                                             alt="Foto kursus">
                                        <label class="inline-flex items-center gap-2 text-gray-900">
                                            <input type="checkbox" name="hapus_foto" value="1" class="rounded border-gray-300">
                                            <span class="text-sm font-semibold">Hapus foto</span>
                                        </label>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-700">Belum ada foto.</p>
                                @endif

                                <input type="file" name="foto_kursus" accept="image/*"
                                       class="block w-full text-sm text-gray-900
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-md file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-gray-200 file:text-gray-900
                                              hover:file:bg-gray-300">
                                <p class="text-xs text-gray-600">Upload baru untuk mengganti foto lama. JPG/PNG/WEBP, max 2MB.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('foto_kursus')" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Periode Waktu</label>
                                <input type="text" name="periode_waktu"
                                       value="{{ old('periode_waktu', $course->periode_waktu) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="contoh: 1 Semester / 3 Bulan">
                                <x-input-error class="mt-2" :messages="$errors->get('periode_waktu')" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Level</label>
                                <input type="text" name="level"
                                       value="{{ old('level', $course->level) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="contoh: Beginner / Intermediate / Advanced">
                                <x-input-error class="mt-2" :messages="$errors->get('level')" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Total Pertemuan</label>
                                <input type="number" min="1" name="total_pertemuan" required
                                       value="{{ old('total_pertemuan', $course->total_pertemuan) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('total_pertemuan')" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Durasi (menit/pertemuan)</label>
                                <input type="number" min="1" name="durasi_menit"
                                       value="{{ old('durasi_menit', $course->durasi_menit) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="contoh: 90">
                                <x-input-error class="mt-2" :messages="$errors->get('durasi_menit')" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Pelaksanaan</label>
                                <select name="pelaksanaan"
                                        class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    @php
                                        $pel = old('pelaksanaan', $course->pelaksanaan);
                                    @endphp
                                    <option value="">-- pilih --</option>
                                    <option value="online" @selected($pel === 'online')>Online</option>
                                    <option value="offline" @selected($pel === 'offline')>Offline</option>
                                    <option value="hybrid" @selected($pel === 'hybrid')>Hybrid</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('pelaksanaan')" />
                            </div>

                            <div class="flex items-end">
                                <label class="inline-flex items-center gap-2 text-gray-900">
                                    <input type="checkbox" name="mendapatkan_sertifikat" value="1"
                                           class="rounded border-gray-300"
                                           @checked(old('mendapatkan_sertifikat', (bool)$course->mendapatkan_sertifikat))>
                                    <span class="text-sm font-semibold">Mendapatkan Sertifikat</span>
                                </label>
                                <x-input-error class="mt-2" :messages="$errors->get('mendapatkan_sertifikat')" />
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-gray-900">Deskripsi Program</label>
                                <textarea name="deskripsi_program" rows="5"
                                          class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Tulis deskripsi program...">{{ old('deskripsi_program', $course->deskripsi_program) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_program')" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Urutan</label>
                                <input type="number" min="0" name="sort_order"
                                       value="{{ old('sort_order', $course->sort_order) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                            </div>

                            <div class="flex items-end">
                                <label class="inline-flex items-center gap-2 text-gray-900">
                                    <input type="checkbox" name="is_active" value="1"
                                           class="rounded border-gray-300"
                                           @checked(old('is_active', (bool)$course->is_active))>
                                    <span class="text-sm font-semibold">Aktif</span>
                                </label>
                                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Nama Kursus</label>
                            <input name="nama_kursus" type="text" value="{{ old('nama_kursus', $course->nama_kursus) }}" required
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="flex gap-2">
                            <button class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Pertemuan --}}
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-lg text-gray-900">Pertemuan ({{ $course->total_pertemuan }})</h3>
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
                                    <th class="px-4 py-3 font-semibold text-gray-900 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($course->meetings as $m)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $m->pertemuan_ke }}</td>
                                        <td class="px-4 py-3 text-gray-900">{{ $m->judul }}</td>
                                        <td class="px-4 py-3 text-gray-800">{{ $m->materi_singkat }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="inline-flex gap-3">
                                                <a class="font-semibold text-indigo-700 hover:underline"
                                                   href="{{ route('admin.course_meetings.edit', [$course, $m]) }}">Edit</a>
                                                <form method="POST" action="{{ route('admin.course_meetings.destroy', [$course, $m]) }}"
                                                      onsubmit="return confirm('Hapus pertemuan ini?');">
                                                    @csrf @method('DELETE')
                                                    <button class="font-semibold text-red-700 hover:underline">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-800 font-medium">Belum ada pertemuan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
