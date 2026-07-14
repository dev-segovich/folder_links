{{-- Ticket row — shared by dashboard & tickets index. Expects $ticket. --}}
@php $overdue = $ticket->isOverdue(); @endphp
<a href="{{ route('tickets.show', $ticket) }}"
   class="card card-hover flex items-stretch overflow-hidden {{ $overdue ? '!border-danger/40' : '' }}">

    {{-- Project image — fills the full height of the card --}}
    <div class="w-24 sm:w-32 shrink-0 bg-bg self-stretch">
        @if($ticket->project->image)
            <img src="{{ asset('storage/' . $ticket->project->image) }}" alt="" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center text-lg font-bold text-faint" aria-hidden="true">
                {{ strtoupper(substr($ticket->project->name, 0, 2)) }}
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="flex-1 min-w-0 p-4 sm:p-5 flex items-start gap-4">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 mb-1.5">
                <span class="font-mono text-xs text-faint shrink-0">#{{ $ticket->id }}</span>
                <h3 class="font-semibold truncate">{{ $ticket->title }}</h3>
            </div>
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-muted">
                <span class="inline-flex items-center gap-1.5 font-medium text-brand">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand" aria-hidden="true"></span>
                    {{ $ticket->project->name }}
                </span>
                @if($ticket->deadline)
                    <span class="inline-flex items-center gap-1 {{ $overdue ? 'text-danger-ink font-semibold' : '' }}">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $ticket->deadline->format('d/m/Y') }}
                    </span>
                @endif
                <span>Por {{ $ticket->creator->name }}</span>
                @if($ticket->assignee)
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        {{ $ticket->assignee->name }}
                    </span>
                @endif
                @isset($showUpdated)
                    <span class="text-faint">Modificado {{ $ticket->updated_at->diffForHumans() }}</span>
                @endisset
            </div>
        </div>
        <div class="flex flex-col items-end gap-1.5 shrink-0">
            @include('partials._badge', ['type' => $ticket->status, 'text' => ucfirst(str_replace('_', ' ', $ticket->status))])
            <div class="flex items-center gap-1.5">
                @if($overdue)
                    @include('partials._badge', ['type' => 'overdue', 'text' => 'Vencido'])
                @endif
                @include('partials._badge', ['type' => $ticket->priority, 'text' => ucfirst($ticket->priority)])
            </div>
        </div>
    </div>
</a>
