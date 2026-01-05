<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                Tambah User
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:underline">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="p-6 space-y-6">

                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="'Nama'" />
                            <x-text-input id="name" name="name" type="text"
                                          class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100"
                                          :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="'Email'" />
                            <x-text-input id="email" name="email" type="email"
                                          class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100"
                                          :value="old('email')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="role" :value="'Role'" />
                            <select id="role" name="role"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                                <option value="" disabled selected>Pilih role</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r }}" @selected(old('role') === $r)>{{ $r }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="'Password'" />
                            <x-text-input id="password" name="password" type="password"
                                          class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100"
                                          required />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                                Simpan
                            </button>
                            <a href="{{ route('admin.users.index') }}"
                               class="px-5 py-2 rounded-md bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm font-semibold">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
