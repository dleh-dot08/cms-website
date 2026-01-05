<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                Edit User
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-gray-900 dark:text-gray-100 hover:underline">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="rounded-md border border-green-300 dark:border-green-800 bg-green-50 dark:bg-green-900/30 px-4 py-3">
                    <p class="text-sm font-medium text-green-900 dark:text-green-100">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-900 shadow sm:rounded-lg border border-gray-200 dark:border-gray-800">
                <div class="p-6 space-y-6">

                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="'Nama'" />
                            <x-text-input id="name" name="name" type="text"
                                          class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100"
                                          :value="old('name', $user->name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="'Email'" />
                            <x-text-input id="email" name="email" type="email"
                                          class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100"
                                          :value="old('email', $user->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="role" :value="'Role'" />
                            <select id="role" name="role"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                                @foreach ($roles as $r)
                                    <option value="{{ $r }}" @selected(old('role', $user->role) === $r)>{{ $r }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="'Password Baru (opsional)'" />
                            <x-text-input id="password" name="password" type="password"
                                          class="mt-1 block w-full dark:bg-gray-950 dark:text-gray-100"
                                          placeholder="Kosongkan jika tidak ingin ganti password" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold">
                                Update
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
