<x-app-layout>
    <x-slot name="header">
        <h2 class="text-primary font-semibold text-2xl leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4"></h2>

                    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" value="Name" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                value="{{ old('name', $user->name) }}" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="username" value="Username" />
                            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                                value="{{ old('username', $user->username) }}" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                value="{{ old('email', $user->email) }}" autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" value="Password" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            <p class="text-sm text-gray-600 mt-1">Kosongkan password jika tidak ingin menggantinya.</p>
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" value="Confirm Password" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="role" value="Role" />
                            <select name="role" id="role"
                                class="mt-2 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($roles as $role)
                                    @if($role->name !== 'dev')
                                        <option class="ml-1" value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="is_active" value="Status" />
                            <div class="mt-2">
                                <label class="inline-flex items-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        value="1" {{ $user->is_active ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">
                                        {{ $user->is_active ? 'Akun Aktif' : 'Akun Nonaktif' }}
                                    </span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('status harus aktif')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit"
                                class="btn btn-primary hover:scale-105 transition-transform duration-200 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z"
                                        clip-rule="evenodd" />
                                </svg>
                                Update User
                            </button>

                            <a href="{{ url('users') }}"
                                class="btn btn-ghost hover:bg-gray-400 transition-colors duration-200">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>