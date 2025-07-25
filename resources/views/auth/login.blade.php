<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/favicon.png') }}" type="image/png">
    <title>
        {{ config('app.name', 'Laravel') }} - Login
    </title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body
    class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-all duration-500 min-h-screen flex items-center justify-center">

    <div class="absolute top-4 right-4">
        <button id="darkToggle" class="p-2 bg-white dark:bg-gray-800 rounded-full shadow-md hover:shadow-lg transition">
            🌙
        </button>
    </div>

    <div
        class="w-full max-w-3xl mx-auto flex flex-col md:flex-row bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden transition-all duration-500">

        <!-- Left Branding -->
        <div class="hidden md:flex w-1/2 text-white flex-col items-center justify-center p-10 bg-center bg-cover bg-no-repeat"
            style="background-image: url('{{ asset('images/logo.jpg') }}');">
            <h2 class="text-3xl font-extrabold px-4 py-2 rounded mt-60">
                {{ config('app.name', 'Laravel') }}
            </h2>
            <p class="mt-2 text-sm text-center bg-black bg-opacity-40 px-3 py-1 rounded">
                Selamat datang kembali 👋<br>Masuk untuk melanjutkan ke dashboard.
            </p>
        </div>

        <!-- Right Form -->
        <div class="w-full md:w-1/2 p-8 md:p-12 bg-gray-50 dark:bg-gray-900 transition-all">
            <div class="mb-6 text-center md:hidden">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-16 h-16 rounded-full mx-auto mb-2">
                <h2 class="text-xl font-bold">{{ config('app.name', 'Laravel') }}</h2>
            </div>

            <h3 class="text-2xl font-extrabold mb-2">Masuk ke Akun</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Gunakan email dan password Anda.</p>

            <!-- Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full dark:bg-gray-800 dark:border-gray-700 dark:text-white" type="email"
                        name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full dark:bg-gray-800 dark:border-gray-700 dark:text-white" type="password"
                        name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember -->
                <div class="flex items-center mb-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Ingat saya') }}</span>
                    </label>
                </div>

                <!-- Tombol Login -->
                <button type="submit"
                    class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow-md hover:shadow-xl transition duration-300">
                    {{ __('Log In') }}
                </button>
            </form>
        </div>
    </div>

    <script>
        const toggle = document.getElementById('darkToggle');
        toggle.addEventListener('click', () => {
            const html = document.documentElement;
            html.classList.toggle('dark');
            localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
        });
    </script>
</body>

</html>
