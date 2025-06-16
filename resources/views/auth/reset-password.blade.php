<div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg">
    <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Reset Password
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Please enter your new password
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="mt-8 space-y-6">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                Email Address
            </label>
            <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1">
            <label for="password" class="block text-sm font-medium text-gray-700">
                New Password
            </label>
            <input type="password" id="password" name="password" required
                class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Enter your new password">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                Confirm Password
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400
                focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Confirm your new password">
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium
                text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                focus:ring-blue-500 transition-colors duration-200">
                Reset Password
            </button>
        </div>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-500">
            Back to login
        </a>
    </div>
</div>
</div>

<!-- Password Requirements -->
<div class="fixed bottom-4 right-4 bg-white p-4 rounded-lg shadow-lg max-w-xs text-sm">
<h3 class="font-medium text-gray-900 mb-2">Password Requirements:</h3>
<ul class="text-gray-600 space-y-1 list-disc list-inside">
    <li>At least 8 characters long</li>
    <li>Must contain at least one uppercase letter</li>
    <li>Must contain at least one number</li>
    <li>Must contain at least one special character</li>
</ul>
</div>
