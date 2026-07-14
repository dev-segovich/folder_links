{{-- Project Card Component — Accordion --}}
@php
    $href = $href ?? route('tickets.index', ['project' => $project->id]);
    $activeCount = $project->activeTicketsCount();
    $completedCount = $project->completedTicketsCount();
    $cardId = 'proj_' . $project->id;
    $hasLinks = $project->links && count($project->links) > 0;
@endphp

<div class="card card-hover overflow-hidden">
    {{-- Accordion Header (clickable) --}}
    <button type="button" id="{{ $cardId }}_trigger" onclick="toggleAccordion('{{ $cardId }}')"
            aria-expanded="false" aria-controls="{{ $cardId }}_body"
            class="w-full flex items-center gap-4 p-4 sm:p-5 text-left cursor-pointer transition-colors hover:bg-surface-2/50">

        {{-- Logo --}}
        @if($project->image)
            <img src="{{ asset('storage/' . $project->image) }}" alt="" class="w-14 h-14 shrink-0 object-contain rounded-lg bg-bg p-1">
        @else
            <div class="w-14 h-14 shrink-0 bg-bg rounded-lg flex items-center justify-center text-base font-bold text-faint" aria-hidden="true">
                {{ strtoupper(substr($project->name, 0, 2)) }}
            </div>
        @endif

        {{-- Name + Badges + counts --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 mb-2 flex-wrap">
                <h3 class="text-base font-semibold truncate">{{ $project->name }}</h3>
                @if($project->env === 'prod')
                    @include('partials._badge', ['type' => 'prod', 'text' => 'PROD'])
                @elseif($project->env === 'qa')
                    @include('partials._badge', ['type' => 'qa', 'text' => 'QA'])
                @endif
                @if(can_see_hidden() && $project->hidden_from_boss)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-semibold bg-surface-2 text-faint" title="Oculto para Rey">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        Oculto
                    </span>
                @endif
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span class="inline-flex items-center gap-1.5 text-muted">
                    <span class="w-1.5 h-1.5 rounded-full bg-info" aria-hidden="true"></span>
                    <span class="tabular-nums font-medium text-ink">{{ $activeCount }}</span> pendientes
                </span>
                <span class="inline-flex items-center gap-1.5 text-muted">
                    <span class="w-1.5 h-1.5 rounded-full bg-success" aria-hidden="true"></span>
                    <span class="tabular-nums font-medium text-ink">{{ $completedCount }}</span> listos
                </span>
            </div>
        </div>

        {{-- Chevron --}}
        <svg id="{{ $cardId }}_chevron" class="w-5 h-5 text-faint shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- Accordion Body (hidden) --}}
    <div id="{{ $cardId }}_body" class="hidden border-t border-line">
        {{-- Actions --}}
        <div class="px-4 sm:px-5 pb-4 sm:pb-6 flex items-center gap-2 pt-4">
            <a href="{{ $href }}" class="btn btn-secondary btn-sm">
                Ver tickets
            </a>
            
            @if($hasLinks)
                <a href="{{ $project->env === 'prod' ? $project->prod_url : $project->local_url }}" 
                   target="_blank" rel="noopener"
                   class="btn btn-ghost btn-sm">
                    Ir al sitio
                </a>
            @endif
            
            @if(can_see_hidden())
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-ghost btn-sm">
                    Editar
                </a>
            @endif
        </div>
    </div>
</div>
