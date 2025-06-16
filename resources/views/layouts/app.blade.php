<!DOCTYPE html>
<html data-theme="" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RCA</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@4/dist/Chart.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png"/>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body data-theme="" class="font-sans antialiased">
    <div data-theme="" class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header data-theme="" class="border-b-4 border-accent rounded-md">
                <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-bold text-base-content">
                        {{ $header }}
                    </h1>
                </div>
            </header>
        @endisset


        <!-- Page Content -->
        <main data-theme="" class="border-accent rounded-md">
            {{ $slot }}
        </main>
    </div>
    <script>
        const themeSelector = document.getElementById('theme-selector');

        // Load theme on page load
        document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') ||
            'emerald'); // 'default' is the fallback

        themeSelector.addEventListener('change', function() {
            const selectedTheme = this.value;
            document.documentElement.setAttribute('data-theme', selectedTheme);
            localStorage.setItem('theme', selectedTheme);
        });
    </script>
</body>

</html>
