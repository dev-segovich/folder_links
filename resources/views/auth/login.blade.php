@extends('layouts.guest')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="w-full max-w-sm">
    {{-- Brand --}}
    <div class="flex flex-col items-center mb-8">
        <span class="w-12 h-12 rounded-xl bg-[#2563eb] flex items-center justify-center text-white mb-4">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </span>
        <h1 class="text-2xl font-bold tracking-tight">Kernel</h1>
        <p class="text-sm text-muted mt-1">Gestión de proyectos y tickets</p>
    </div>

    <div class="card p-6 sm:p-8">
        <h2 class="text-lg font-semibold mb-1">Iniciar sesión</h2>
        <p class="text-sm text-muted mb-6">Accede para gestionar los elementos ocultos.</p>

        @if ($errors->any())
            @include('partials._alert', ['type' => 'error', 'message' => $errors->first()])
        @endif

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
            @csrf
            <div>
                <label for="login" class="label">Usuario o Email</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus
                    autocomplete="username" placeholder="segovich o jesus@kernel.local" class="field @error('login') !border-danger @enderror">
                @error('login')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="password" class="label">Contraseña</label>
                <input type="password" id="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••" class="field">
            </div>
            <label class="flex items-center gap-2 text-sm text-muted cursor-pointer select-none">
                <input type="checkbox" name="remember" class="accent-brand w-4 h-4">
                Recordarme
            </label>
            <button type="submit" class="btn btn-primary w-full">Iniciar Sesión</button>
        </form>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-muted hover:text-ink transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Continuar como Rey (sin iniciar sesión)
        </a>
    </div>
</div>
@endsection
