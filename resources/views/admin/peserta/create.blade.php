<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tambah Peserta
            </h2>

            <a href="{{ route('admin.peserta.index') }}"
               class="text-sm text-gray-600 dark:text-gray-300 hover:underline">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('admin.peserta.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="'Nama'" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                          :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="'Email'" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                          :value="old('email')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="'Password'" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                          required />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div class="flex items-center gap-3">
                            <x-primary-button>
                                Simpan
                            </x-primary-button>

                            <a href="{{ route('admin.peserta.index') }}"
                               class="text-sm text-gray-600 dark:text-gray-300 hover:underline">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
