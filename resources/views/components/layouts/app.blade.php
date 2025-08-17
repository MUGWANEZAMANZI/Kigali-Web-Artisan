<!-- resources/views/components/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo/logo.jpg') }}" type="image/x-icon">
    <title>{{ $title ?? 'Kigali Web Artisans' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen">
    <header class="w-full text-sm mb-6 py-4 px-6 bg-white shadow">
        <a href="/"><h1 class="text-2xl font-bold">Kigali Web Artisans</h1></a>
    </header>
    <main class="flex-1 w-full flex flex-col items-center justify-center">
        @yield('content')
    </main>
    <footer class="w-full text-sm mt-6 py-4 px-6 bg-gray-100 text-center">
        <p>© 2023 Kigali Web Artisans. All rights reserved.</p>
    </footer>
    @livewireScripts
</body>
</html>
