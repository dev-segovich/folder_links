{{-- Top-right auth control: username + logout when logged in, login button otherwise --}}
<div class="ml-auto flex items-center gap-2 shrink-0">
    @auth
        <div class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-full bg-brand/15 text-brand flex items-center justify-center text-sm font-bold" aria-hidden="true">
                {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
            </span>
            <span class="text-sm font-semibold hidden sm:inline">{{ auth()->user()->name }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm" aria-label="Cerrar sesión">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span class="hidden sm:inline">Salir</span>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Iniciar Sesión
        </a>
    @endauth
</div>
