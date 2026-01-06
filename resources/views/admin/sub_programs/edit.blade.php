<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900">Edit Sub Program</h2>

            <a href="{{ route('admin.sub_programs.index') }}"
               class="text-sm font-semibold text-gray-900 hover:underline">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 bg-green-50 px-4 py-3">
                    <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.sub_programs.update', $subProgram) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Kategori Program</label>
                            <select name="program_category_id" required
                                    class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}"
                                        @selected(old('program_category_id', $subProgram->program_category_id)==$c->id)>
                                        {{ $c->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('program_category_id')" />
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900">Nama Sub Program</label>
                            <input name="nama" type="text" value="{{ old('nama', $subProgram->nama) }}" required
                                   class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900">Urutan</label>
                                <input name="sort_order" type="number" min="0"
                                       value="{{ old('sort_order', $subProgram->sort_order) }}"
                                       class="mt-1 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                            </div>

                            <div class="flex items-end">
                                <label class="inline-flex items-center gap-2 text-gray-900">
                                    <input type="checkbox" name="is_active" value="1"
                                           class="rounded border-gray-300"
                                           @checked(old('is_active', (bool)$subProgram->is_active))>
                                    <span class="text-sm font-semibold">Aktif</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="submit"
                                    class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                                Update
                            </button>
                            <a href="{{ route('admin.sub_programs.index') }}"
                               class="px-5 py-2 rounded-md bg-gray-200 text-gray-900 text-sm font-semibold">
                                Batal
                            </a>
                        </div>
                    </form>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <form method="POST" action="{{ route('admin.sub_programs.destroy', $subProgram) }}"
                              onsubmit="return confirm('Yakin ingin menghapus sub program ini?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="px-5 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white text-sm font-semibold">
                                Delete Sub Program
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
