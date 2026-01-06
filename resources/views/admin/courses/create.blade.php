<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900">Tambah Kursus</h2>
            <a href="{{ route('admin.courses.index') }}" class="text-sm font-semibold text-gray-900 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.courses.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Kategori Program</label>
                            <select id="program_category_id" name="program_category_id"
                                    class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">-- pilih --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" @selected(old('program_category_id')==$c->id)>{{ $c->nama }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('program_category_id')" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Jenjang</label>
                                <select id="jenjang_id" name="jenjang_id"
                                        class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">-- pilih --</option>
                                    @foreach($jenjangs as $j)
                                        <option value="{{ $j->id }}"
                                                data-cat="{{ $j->program_category_id }}"
                                                @selected(old('jenjang_id')==$j->id)>
                                            {{ $j->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('jenjang_id')" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Sub Program</label>
                                <select id="sub_program_id" name="sub_program_id"
                                        class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="">-- pilih --</option>
                                    @foreach($subPrograms as $sp)
                                        <option value="{{ $sp->id }}"
                                                data-cat="{{ $sp->program_category_id }}"
                                                @selected(old('sub_program_id')==$sp->id)>
                                            {{ $sp->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('sub_program_id')" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Nama Kursus</label>
                            <input name="nama_kursus" type="text" value="{{ old('nama_kursus') }}" required
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <x-input-error class="mt-2" :messages="$errors->get('nama_kursus')" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Foto Kursus</label>
                            <input type="file" name="foto_kursus" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-900
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-gray-200 file:text-gray-900
                                        hover:file:bg-gray-300">
                            <p class="mt-1 text-xs text-gray-600">JPG/PNG/WEBP, max 2MB.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('foto_kursus')" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Periode Waktu</label>
                                <input name="periode_waktu" type="text" value="{{ old('periode_waktu') }}"
                                       placeholder="contoh: Jan–Mar 2026"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Level</label>
                                <input name="level" type="text" value="{{ old('level') }}"
                                       placeholder="contoh: Beginner / Level 1"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Durasi (menit/pertemuan)</label>
                                <input name="durasi_menit" type="number" min="0" value="{{ old('durasi_menit') }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Pelaksanaan</label>
                                <input name="pelaksanaan" type="text" value="{{ old('pelaksanaan') }}"
                                       placeholder="Online / Offline / Hybrid"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="inline-flex items-center gap-2 text-gray-900">
                                <input type="checkbox" name="mendapatkan_sertifikat" value="1" class="rounded border-gray-300"
                                       @checked(old('mendapatkan_sertifikat'))>
                                <span class="text-sm font-semibold">Mendapatkan Sertifikat</span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Deskripsi Program</label>
                            <textarea name="deskripsi_program" rows="5"
                                      class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi_program') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Urutan</label>
                                <input name="sort_order" type="number" min="0" value="{{ old('sort_order',0) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div class="flex items-end">
                                <label class="inline-flex items-center gap-2 text-gray-900">
                                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300" @checked(old('is_active', true))>
                                    <span class="text-sm font-semibold">Aktif</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">Simpan</button>
                            <a href="{{ route('admin.courses.index') }}" class="px-5 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">Batal</a>
                        </div>
                    </form>

                    <script>
                        function filterOptions() {
                            const cat = document.getElementById('program_category_id').value;
                            const jenjang = document.getElementById('jenjang_id');
                            const sub = document.getElementById('sub_program_id');

                            const filterSelect = (select) => {
                                let hasSelectedVisible = false;
                                [...select.options].forEach((opt, i) => {
                                    if (i === 0) return; // placeholder
                                    const ok = opt.dataset.cat === cat;
                                    opt.hidden = !ok;
                                    if (ok && opt.selected) hasSelectedVisible = true;
                                });
                                if (!hasSelectedVisible) select.value = '';
                            };

                            filterSelect(jenjang);
                            filterSelect(sub);
                        }

                        document.getElementById('program_category_id').addEventListener('change', filterOptions);
                        window.addEventListener('DOMContentLoaded', filterOptions);
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
