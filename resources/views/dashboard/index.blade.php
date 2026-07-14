@extends('layouts.app-no-sidebar')

@section('title', 'Dashboard')

@section('topbar')
<div>
    <h1 class="text-xl font-bold tracking-tight">Dashboard</h1>
    <p class="text-sm text-faint">Resumen de tickets y proyectos</p>
</div>
<a href="{{ route('tickets.create') }}" class="btn btn-primary ml-auto">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    Crear Ticket
</a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8 space-y-8 lg:space-y-10">
    {{-- Stats --}}
    @include('partials._stats_grid', ['items' => [
        ['value' => $activeTickets, 'label' => 'Activos', 'accent' => 'bg-brand/12 text-brand', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['value' => $inProgressTickets, 'label' => 'En Progreso', 'accent' => 'bg-info/12 text-info', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
        ['value' => $inReviewTickets, 'label' => 'En Revisión', 'accent' => 'bg-purple/15 text-purple', 'icon' => 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z'],
    ]])

    {{-- Recent Tickets --}}
    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold">Últimos tickets modificados</h2>
            <a href="{{ route('tickets.index') }}" class="text-sm font-medium text-brand hover:text-brand-strong transition-colors">Ver todos →</a>
        </div>

        @if($recentTickets->isEmpty())
            <div class="card p-10 text-center">
                <p class="text-muted">Aún no hay tickets.</p>
                <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm mt-4">Crear el primero</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($recentTickets as $ticket)
                    @include('partials._ticket_row', ['ticket' => $ticket, 'showUpdated' => true])
                @endforeach
            </div>
        @endif
    </section>

    {{-- Projects --}}
    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold">Proyectos</h2>
            <a href="{{ route('projects.index') }}" class="text-sm font-medium text-brand hover:text-brand-strong transition-colors">Directorio →</a>
        </div>
        @if($projects->isEmpty())
            <div class="card p-10 text-center">
                <p class="text-muted">No hay proyectos visibles.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach($projects as $project)
                    @include('partials._project_card_compact', ['project' => $project])
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
