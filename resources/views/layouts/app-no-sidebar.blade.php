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
    <div class="flex flex-col min-h-screen">
        {{-- Top Bar --}}
        <header class="sticky top-0 z-30 bg-bg/85 backdrop-blur-lg border-b border-line">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="h-16 flex items-center gap-4">
                    {{-- Brand --}}
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 shrink-0">
                        <span class="w-8 h-8 rounded-lg bg-[#2563eb] flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </span>
                        <span class="text-lg font-bold tracking-tight">Kernel</span>
                    </a>

                    {{-- Primary nav --}}
                    <nav class="flex items-center gap-1 overflow-x-auto -mx-1 px-1" aria-label="Principal">
                        @include('partials._nav_links')
                    </nav>

                    @include('partials._auth_widget')
                </div>
            </div>
        </header>

        {{-- Optional page sub-header (title / actions) --}}
        @hasSection('topbar')
            <div class="border-b border-line bg-surface/40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="min-h-14 py-3 flex flex-wrap items-center gap-x-4 gap-y-2">
                        @yield('topbar')
                    </div>
                </div>
            </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
