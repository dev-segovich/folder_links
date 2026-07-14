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
    <div class="flex h-full">
        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-surface border-r border-line transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out lg:static lg:inset-auto lg:transform-none flex flex-col">
            {{-- Logo --}}
            <div class="flex items-center justify-between h-16 px-5 border-b border-line">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-[#2563eb] flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </span>
                    <span class="text-lg font-bold tracking-tight">Kernel</span>
                </a>
                <button id="sidebarClose" class="lg:hidden icon-btn" aria-label="Cerrar menú">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto" aria-label="Principal">
                @include('partials._nav_links')
            </nav>

            {{-- Bottom: acting identity --}}
            <div class="px-4 py-4 border-t border-line">
                <div class="flex items-center gap-2 px-2 py-1 text-xs">
                    <span class="w-2 h-2 rounded-full {{ auth()->check() ? 'bg-brand' : 'bg-faint' }}" aria-hidden="true"></span>
                    <span class="text-faint">Viendo como</span>
                    <span class="font-semibold truncate">{{ acting_user()?->name ?? 'Rey' }}</span>
                </div>
            </div>
        </aside>

        {{-- Overlay for mobile --}}
        <div id="sidebarOverlay" class="fixed inset-0 z-40 bg-black/50 lg:hidden hidden"></div>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-30 h-16 bg-bg/85 backdrop-blur-lg border-b border-line flex items-center px-4 lg:px-6 gap-4">
                <button id="sidebarToggle" class="lg:hidden icon-btn -ml-1" aria-label="Abrir menú">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                @yield('topbar')
                @include('partials._auth_widget')
            </header>

            {{-- Page Content --}}
            <main class="flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
