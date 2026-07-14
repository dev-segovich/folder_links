@extends('layouts.app-no-sidebar')

@section('title', 'Tickets')

@section('topbar')
<div>
    <h1 class="text-xl font-bold tracking-tight">Tickets</h1>
    <p class="text-sm text-faint">{{ $tickets->total() }} {{ Str::plural('ticket', $tickets->total()) }}</p>
</div>
<a href="{{ route('tickets.create') }}" class="btn btn-primary ml-auto">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
    Crear Ticket
</a>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
    {{-- Filters --}}
    @include('partials._filters_bar', [
        'action' => route('tickets.index'),
        'filters' => [
            ['name' => 'search', 'type' => 'text', 'label' => 'Buscar', 'placeholder' => 'Buscar por título, descripción o ID...', 'value' => request('search')],
            ['name' => 'project', 'type' => 'select', 'label' => 'Proyecto', 'options' => array_merge(['' => 'Todos los proyectos'], $projects->mapWithKeys(fn($p) => [$p->id => $p->name])->toArray()), 'value' => request('project')],
            ['name' => 'status', 'type' => 'select', 'label' => 'Estado', 'options' => ['' => 'Todos los estados', 'backlog' => 'Backlog', 'en_progreso' => 'En Progreso', 'en_revision' => 'En Revisión', 'done' => 'Done'], 'value' => request('status')],
            ['name' => 'priority', 'type' => 'select', 'label' => 'Prioridad', 'options' => ['' => 'Todas las prioridades', 'baja' => 'Baja', 'media' => 'Media', 'alta' => 'Alta', 'critica' => 'Crítica'], 'value' => request('priority')],
            ['name' => 'sort', 'type' => 'select', 'label' => 'Orden', 'options' => ['created_desc' => 'Más reciente', 'created_asc' => 'Más antiguo', 'deadline' => 'Deadline', 'priority' => 'Prioridad'], 'value' => request('sort')],
            ['name' => 'filter_by', 'type' => 'select', 'label' => 'Filtrar por', 'options' => ['' => 'Todos', 'assigned_to_me' => 'Asignados a mí', 'completed' => 'Completados'], 'value' => request('filter_by')],
        ],
        'buttons' => [
            ['type' => 'submit', 'text' => 'Filtrar', 'class' => 'btn btn-primary'],
            ...(request()->anyFilled(['search', 'project', 'status', 'priority', 'sort', 'filter_by'])) ? [['type' => 'link', 'text' => 'Limpiar', 'href' => route('tickets.index'), 'class' => 'btn btn-secondary']] : [],
        ]
    ])

    {{-- Tickets List --}}
    @if($tickets->isEmpty())
        <div class="card p-12 text-center">
            <span class="w-12 h-12 rounded-full bg-surface-2 flex items-center justify-center mx-auto mb-4 text-faint" aria-hidden="true">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </span>
            <p class="text-muted mb-5">No se encontraron tickets con estos filtros.</p>
            <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm">Crear primer ticket</a>
        </div>
    @else
        <div class="space-y-3 mb-6">
            @foreach($tickets as $ticket)
                @include('partials._ticket_row', ['ticket' => $ticket])
            @endforeach
        </div>

        {{-- Pagination --}}
        <div>
            {{ $tickets->appends(request()->query())->links('partials._pagination') }}
        </div>
    @endif
</div>
@endsection
