<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kernel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials._fonts')
    @stack('styles')
</head>
<body class="h-full bg-bg text-ink font-sans antialiased">
    <div class="min-h-full flex flex-col">
        <main class="flex-1 flex items-center justify-center px-4 py-10">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
