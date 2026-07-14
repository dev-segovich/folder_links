{{-- Shared primary navigation links --}}
@php
    $items = [
        ['route' => 'dashboard', 'active' => request()->routeIs('dashboard'), 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'projects.index', 'active' => request()->routeIs('projects.*'), 'label' => 'Proyectos', 'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'],
        ['route' => 'tickets.index', 'active' => request()->routeIs('tickets.*'), 'label' => 'Tickets', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
    ];
@endphp

@foreach($items as $item)
    <a href="{{ route($item['route']) }}"
       @if($item['active']) aria-current="page" @endif
       class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-colors {{ $item['active'] ? 'bg-brand/12 text-brand' : 'text-muted hover:text-ink hover:bg-surface-2' }}">
        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
        </svg>
        {{ $item['label'] }}
    </a>
@endforeach
