<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900">Tambah Jenjang</h2>

            <a href="{{ route('admin.jenjangs.index') }}"
               class="text-sm font-semibold text-gray-900 hover:underline">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.jenjangs.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Kategori Program</label>
                            <select name="program_category_id" required
                                    class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- pilih --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" @selected(old('program_category_id')==$c->id)>
                                        {{ $c->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('program_category_id')" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Nama Jenjang</label>
                            <input name="nama" type="text" value="{{ old('nama') }}" required
                                   placeholder="contoh: TK / SD / SMP / SMA / SMK / UNIV / UMUM"
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Urutan</label>
                                <input name="sort_order" type="number" min="0" value="{{ old('sort_order', 0) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                            </div>

                            <div class="flex items-end">
                                <label class="inline-flex items-center gap-2 text-gray-900">
                                    <input type="checkbox" name="is_active" value="1"
                                           class="rounded border-gray-300"
                                           @checked(old('is_active', true))>
                                    <span class="text-sm font-semibold">Aktif</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="submit"
                                    class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                                Simpan
                            </button>
                            <a href="{{ route('admin.jenjangs.index') }}"
                               class="px-5 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
