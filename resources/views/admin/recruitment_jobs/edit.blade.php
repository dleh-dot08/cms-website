{{-- resources/views/admin/recruitment_jobs/edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900">Edit Lowongan</h2>
                <p class="mt-1 text-sm text-gray-700 font-medium">{{ $job->judul }}</p>
            </div>
            <a href="{{ route('admin.recruitment_jobs.index') }}"
               class="px-4 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold hover:bg-gray-300">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-semibold text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST"
                          action="{{ route('admin.recruitment_jobs.update', $job) }}"
                          enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- MASTER FILTER --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Divisi</label>
                                <select name="division_id" required class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Pilih</option>
                                    @foreach($divisions as $d)
                                        <option value="{{ $d->id }}" @selected((string)old('division_id', $job->division_id) === (string)$d->id)>{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('division_id')" />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-900">Tipe Kerja</label>
                                <select name="work_type_id" required class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Pilih</option>
                                    @foreach($workTypes as $wt)
                                        <option value="{{ $wt->id }}" @selected((string)old('work_type_id', $job->work_type_id) === (string)$wt->id)>{{ $wt->nama }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('work_type_id')" />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-900">Lokasi</label>
                                <select name="location_id" required class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Pilih</option>
                                    @foreach($locations as $l)
                                        <option value="{{ $l->id }}" @selected((string)old('location_id', $job->location_id) === (string)$l->id)>{{ $l->nama }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('location_id')" />
                            </div>
                        </div>

                        {{-- JUDUL + STATUS --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-900">Judul Posisi</label>
                                <input type="text" name="judul" required value="{{ old('judul', $job->judul) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('judul')" />
                                <p class="mt-1 text-xs text-gray-600">
                                    Slug otomatis:
                                    <span class="font-semibold text-gray-900">{{ $job->slug }}</span>
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-900">Status</label>
                                <select name="status" required class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="draft" @selected(old('status', $job->status) === 'draft')>Draft</option>
                                    <option value="open" @selected(old('status', $job->status) === 'open')>Open</option>
                                    <option value="closed" @selected(old('status', $job->status) === 'closed')>Closed</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>
                        </div>

                        {{-- RINGKASAN --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-900">Ringkasan (1–2 kalimat)</label>
                            <textarea name="ringkasan" rows="3"
                                      class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('ringkasan', $job->ringkasan) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('ringkasan')" />
                        </div>

                        {{-- COVER + TAG --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Cover / Thumbnail</label>

                                @if(!empty($job->cover_image_url))
                                    <div class="mt-2 flex items-center gap-3">
                                        <img src="{{ $job->cover_image_url }}" alt="cover"
                                             class="w-32 h-20 object-cover rounded border border-gray-200">
                                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-gray-900">
                                            <input type="checkbox" name="hapus_cover" value="1" class="rounded border-gray-300">
                                            Hapus cover
                                        </label>
                                    </div>
                                @else
                                    <p class="mt-2 text-sm text-gray-700 font-medium">Belum ada cover.</p>
                                @endif

                                <input type="file" name="cover_image" accept="image/*"
                                       class="mt-3 w-full rounded-md border border-gray-300 p-2">
                                <p class="mt-1 text-xs text-gray-600">Upload baru akan mengganti cover lama.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-900">Tag (opsional)</label>
                                <select name="tag_ids[]" multiple
                                        class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    @php
                                        $selectedTags = collect(old('tag_ids', $job->tags?->pluck('id')->toArray() ?? []));
                                    @endphp
                                    @foreach($tags as $t)
                                        <option value="{{ $t->id }}" @selected($selectedTags->contains($t->id))>
                                            {{ $t->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-600">Tekan Ctrl (Windows) untuk pilih lebih dari satu.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('tag_ids')" />
                            </div>
                        </div>

                        {{-- DEADLINE + FEATURED --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Deadline (opsional)</label>
                                <input type="date" name="deadline_at"
                                       value="{{ old('deadline_at', optional($job->deadline_at)->format('Y-m-d')) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('deadline_at')" />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-900">Urutan (opsional)</label>
                                <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $job->sort_order) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                            </div>

                            <div class="flex items-center gap-2 mt-7">
                                <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300"
                                       @checked(old('is_featured', (bool)$job->is_featured))>
                                <label class="text-sm font-bold text-gray-900">Featured</label>
                            </div>
                        </div>

                        {{-- DETAIL NARASI --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Deskripsi Role (narasi)</label>
                                <textarea name="deskripsi_role" rows="6"
                                          class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi_role', $job->deskripsi_role) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('deskripsi_role')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Detail Jobdesk (narasi)</label>
                                <textarea name="jobdesk_detail" rows="6"
                                          class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('jobdesk_detail', $job->jobdesk_detail) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('jobdesk_detail')" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-900">Detail Kualifikasi (narasi)</label>
                            <textarea name="kualifikasi_detail" rows="6"
                                      class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('kualifikasi_detail', $job->kualifikasi_detail) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('kualifikasi_detail')" />
                        </div>

                        @php
                            /**
                             * Normalizer: array/json/string -> teks 1 baris 1 poin
                             * - Prioritas: old()
                             * - Jika DB string JSON -> decode
                             * - Jika DB string biasa -> split per baris
                             */
                            $normalizeLines = function (string $oldKey, $value) {
                                $oldVal = old($oldKey);
                                if (!is_null($oldVal)) return $oldVal;

                                $val = $value ?? [];

                                if (is_string($val)) {
                                    $decoded = json_decode($val, true);
                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                        $val = $decoded;
                                    } else {
                                        $val = preg_split("/\R/u", $val) ?: [];
                                    }
                                }

                                return is_array($val) ? implode(PHP_EOL, $val) : (string) $val;
                            };

                            $respText = $normalizeLines('responsibilities', $job->responsibilities ?? []);
                            $reqText  = $normalizeLines('requirements',      $job->requirements ?? []);
                            $benText  = $normalizeLines('benefits',          $job->benefits ?? []);
                            $dokText  = $normalizeLines('dokumen_diminta',   $job->dokumen_diminta ?? []);
                        @endphp

                        {{-- BULLET LIST --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Responsibilities (1 baris 1 poin)</label>
                                <textarea name="responsibilities" rows="8"
                                          class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ $respText }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('responsibilities')" />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-900">Requirements (1 baris 1 poin)</label>
                                <textarea name="requirements" rows="8"
                                          class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ $reqText }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('requirements')" />
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-900">Benefits (1 baris 1 poin)</label>
                                <textarea name="benefits" rows="8"
                                          class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ $benText }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('benefits')" />
                            </div>
                        </div>

                        {{-- SALARY --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Gaji Min (opsional)</label>
                                <input type="number" min="0" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('salary_min')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Gaji Max (opsional)</label>
                                <input type="number" min="0" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('salary_max')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Catatan Gaji</label>
                                <input type="text" name="salary_note" value="{{ old('salary_note', $job->salary_note) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('salary_note')" />
                            </div>
                        </div>

                        {{-- APPLY --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Cara Melamar</label>
                                <select name="apply_type" class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    @foreach(['link'=>'Link', 'email'=>'Email', 'whatsapp'=>'WhatsApp', 'ats'=>'ATS'] as $k => $v)
                                        <option value="{{ $k }}" @selected(old('apply_type', $job->apply_type) === $k)>{{ $v }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('apply_type')" />
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-900">Alamat / Link Melamar</label>
                                <input type="text" name="apply_value" value="{{ old('apply_value', $job->apply_value) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('apply_value')" />
                            </div>
                        </div>

                        {{-- DOKUMEN + PIC --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Dokumen Diminta (1 baris 1 item)</label>
                                <textarea name="dokumen_diminta" rows="5"
                                          class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ $dokText }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('dokumen_diminta')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Nama PIC (opsional)</label>
                                <input type="text" name="pic_name" value="{{ old('pic_name', $job->pic_name) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('pic_name')" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900">Kontak PIC (opsional)</label>
                                <input type="text" name="pic_contact" value="{{ old('pic_contact', $job->pic_contact) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('pic_contact')" />
                            </div>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="submit"
                                    class="px-5 py-2 rounded-md bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                                Update
                            </button>

                            <a href="{{ route('admin.recruitment_jobs.show', $job) }}"
                               class="px-5 py-2 rounded-md bg-gray-900 text-white text-sm font-semibold hover:bg-black">
                                Lihat Detail
                            </a>

                            <a href="{{ route('admin.recruitment_jobs.index') }}"
                               class="px-5 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold hover:bg-gray-300">
                                Batal
                            </a>
                        </div>

                    </form>

                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="font-semibold text-gray-900">Hapus Lowongan</h3>
                                <p class="text-sm text-gray-700">Data akan terhapus permanen.</p>
                            </div>
                            <form method="POST" action="{{ route('admin.recruitment_jobs.destroy', $job) }}"
                                  onsubmit="return confirm('Yakin hapus lowongan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-5 py-2 rounded-md bg-red-600 text-white text-sm font-semibold hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
