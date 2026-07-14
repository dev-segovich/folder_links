{{-- Compact project card (dashboard). Left area → tickets filtered by project;
     right edge block opens the project's main link. No sub-links. --}}
@php
    $href = route('tickets.index', ['project' => $project->id]);
    $mainLink = $project->prod_url ?: $project->local_url;
    $activeCount = $project->activeTicketsCount();
    $completedCount = $project->completedTicketsCount();
@endphp

<div class="card card-hover flex items-stretch overflow-hidden">
    {{-- Main clickable area → filtered tickets --}}
    <a href="{{ $href }}" class="flex-1 min-w-0 flex items-center gap-4 p-4 sm:p-5 transition-colors hover:bg-surface-2/40"
       aria-label="Ver tickets de {{ $project->name }}">
        {{-- Logo --}}
        @if($project->image)
            <img src="{{ asset('storage/' . $project->image) }}" alt="" class="w-14 h-14 shrink-0 object-contain rounded-lg bg-bg p-1">
        @else
            <div class="w-14 h-14 shrink-0 bg-bg rounded-lg flex items-center justify-center text-base font-bold text-faint" aria-hidden="true">
                {{ strtoupper(substr($project->name, 0, 2)) }}
            </div>
        @endif

        {{-- Name + counts --}}
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 mb-2 flex-wrap">
                <h3 class="text-base font-semibold truncate">{{ $project->name }}</h3>
                @if($project->env === 'prod')
                    @include('partials._badge', ['type' => 'prod', 'text' => 'PROD'])
                @elseif($project->env === 'qa')
                    @include('partials._badge', ['type' => 'qa', 'text' => 'QA'])
                @endif
                @if(can_see_hidden() && $project->hidden_from_boss)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-surface-2 text-faint" title="Oculto para Rey">Oculto</span>
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
    </a>

    {{-- Open main link — full-height block flush to the right edge --}}
    @if($mainLink)
        <a href="{{ $mainLink }}" target="_blank" rel="noopener"
           class="shrink-0 self-stretch flex items-center justify-center px-5 bg-[#2563eb] hover:bg-[#1d4ed8] text-white transition-colors"
           title="Abrir proyecto" aria-label="Abrir {{ $project->name }} en una pestaña nueva">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    @endif
</div>
