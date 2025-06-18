<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-primary">{{ __('Buat User Baru') }}</h2>
        </div>
    </x-slot>

    <div class="">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form method="POST" action="{{ route('users.store') }}" class="space-y-3 sm:space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="name" class="text-sm" />Name
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-sm" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
                        </div>

                        <div>
                            <x-input-label for="username" class="text-sm" />Username
                            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full text-sm" required />
                            <x-input-error :messages="$errors->get('username')" class="mt-1 text-xs" />
                        </div>

                        <div>
                            <x-input-label for="email" class="text-sm" />Email (Optional)
                            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full text-sm" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
                        </div>

                        <div>
                            <x-input-label for="password" class="text-sm" />Kata Sandi
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full text-sm" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" class="text-sm" />Konfirmasi Kata Sandi
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full text-sm" required />
                        </div>

                        <div style="display: none;">
                            <x-input-label for="role" value="Role" class="text-sm" />
                            <select name="role" id="role" class="mt-1 block w-full text-sm border-gray-300 rounded-md shadow-sm">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $role->name === 'TeamAdmin' ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-4 pt-2">
                            <x-primary-button class="w-full sm:w-auto justify-center">Tambah User</x-primary-button>
                            <a href="{{ route('users.index') }}" class="w-full sm:w-auto text-center btn btn-ghost">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
