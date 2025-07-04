<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RCA</title>

      <!-- JavaScript to prevent flickering -->
      <script>
        // Function to apply or remove the dark theme
        function updateTheme(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
    
        // Check the initial theme preference
        const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        updateTheme(darkModeMediaQuery.matches);
    
        // Listen for changes in the theme preference
        darkModeMediaQuery.addEventListener('change', (event) => {
            updateTheme(event.matches);
        });
      </script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png"/>
    <!-- Scripts -->
   

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Define root properties */
    </style>

    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-white dark:bg-gray-900">

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

    </div>
    @livewireScripts
    @once
    @livewire('chat-dialog')
   @endonce
</body>

</html>
