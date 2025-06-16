<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Profile Informasi
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Update informasi nama, nama pengguna, foto profile
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" enctype="multipart/form-data" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="username" value="Nama Pengguna" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full"
                value="{{ old('username', $user->username) }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>
        <div class="form-control">
            <input type="file" class="file-input file-input-bordered file-input-primary w-full max-w-xs" name="files[]" multiple class="file-input file-input-bordered w-full"
                onchange="previewFiles(this)" />
            <div id="filePreview" class="grid grid-cols-4 gap-2 mt-4"></div>
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>function previewFiles(input) {
    const preview = document.getElementById('filePreview');
    preview.innerHTML = '';

    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.className = 'relative group';

            if (file.type.startsWith('image/')) {
                div.innerHTML = `
            <div class="aspect-square rounded-xl overflow-hidden">
                <img src="${e.target.result}" class="w-full h-full object-cover"/>
            </div>`;
            } else {
                div.innerHTML = `
            <div class="aspect-square rounded-xl border-2 border-base-300 flex flex-col items-center justify-center p-4">
                <i class="fa-solid fa-file-lines text-3xl text-primary"></i>
                <span class="mt-2 text-sm text-center line-clamp-2">${file.name}</span>
            </div>`;
            }

            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}</script>
