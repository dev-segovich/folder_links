@extends('layouts.app-no-sidebar')

@section('title', $ticket->title)

@section('topbar')
<a href="{{ route('tickets.index') }}" class="btn btn-ghost btn-sm -ml-2">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Volver
</a>
<div class="min-w-0">
    <div class="flex items-center gap-2">
        <span class="font-mono text-xs text-faint">#{{ $ticket->id }}</span>
        <h1 class="text-lg sm:text-xl font-bold tracking-tight truncate">{{ $ticket->title }}</h1>
    </div>
</div>
<div class="ml-auto flex items-center gap-2">
    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-secondary btn-sm">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        Editar
    </a>
    <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" onsubmit="return confirm('¿Eliminar este ticket y todo su contenido? Esta acción no se puede deshacer.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            <span class="hidden sm:inline">Eliminar</span>
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
    {{-- Badges --}}
    <div class="flex flex-wrap items-center gap-2 mb-6">
        @include('partials._badge', ['type' => $ticket->status, 'text' => ucfirst(str_replace('_', ' ', $ticket->status))])
        @include('partials._badge', ['type' => $ticket->priority, 'text' => ucfirst($ticket->priority)])
        @if($ticket->isOverdue())
            @include('partials._badge', ['type' => 'overdue', 'text' => 'Vencido'])
        @endif
        <a href="{{ route('tickets.index', ['project' => $ticket->project_id]) }}" class="inline-flex">
            @include('partials._badge', ['type' => 'prod', 'text' => $ticket->project->name])
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        {{-- Sidebar : details --}}
        <aside class="lg:w-80 shrink-0">
            <div class="card p-5 space-y-5 lg:sticky lg:top-24">
                {{-- Quick status change --}}
                @php
                    $statusOpts = [
                        'backlog'     => ['Pendiente',    'bg-faint/15 text-muted ring-faint/40'],
                        'en_progreso' => ['En progreso',  'bg-info/12 text-info ring-info/40'],
                        'en_revision' => ['En revisión',  'bg-purple/15 text-purple ring-purple/40'],
                        'done'        => ['Completado',   'bg-success/12 text-success ring-success/40'],
                    ];
                @endphp
                <div>
                    <h2 class="eyebrow mb-2.5">Cambiar estado</h2>
                    <form method="POST" action="{{ route('tickets.status', $ticket) }}" class="grid grid-cols-2 gap-2">
                        @csrf
                        @method('PATCH')
                        @foreach($statusOpts as $val => [$label, $activeClass])
                            @php $isCurrent = $ticket->status === $val; @endphp
                            <button type="submit" name="status" value="{{ $val }}"
                                @if($isCurrent) aria-current="true" @endif
                                class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold transition-colors
                                    {{ $isCurrent
                                        ? $activeClass . ' ring-1 ring-inset cursor-default'
                                        : 'text-muted ring-1 ring-inset ring-line hover:text-ink hover:bg-surface-2' }}">
                                @if($isCurrent)
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                @endif
                                {{ $label }}
                            </button>
                        @endforeach
                    </form>
                </div>

                <hr class="border-line">

                {{-- Description --}}
                @if($ticket->description)
                    <div>
                        <h2 class="eyebrow mb-2">Descripción</h2>
                        <p class="text-sm text-ink/90 whitespace-pre-wrap break-words leading-relaxed">{{ $ticket->description }}</p>
                    </div>
                    <hr class="border-line">
                @endif

                {{-- Meta grid --}}
                <dl class="grid grid-cols-2 gap-x-4 gap-y-4 text-sm">
                    <div>
                        <dt class="eyebrow mb-1.5">Asignado a</dt>
                        <dd>{{ $ticket->assignee->name ?? 'Sin asignar' }}</dd>
                    </div>
                    <div>
                        <dt class="eyebrow mb-1.5">Creado por</dt>
                        <dd>{{ $ticket->creator->name }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="eyebrow mb-1.5">Deadline</dt>
                        <dd class="{{ $ticket->isOverdue() ? 'text-danger-ink font-semibold' : '' }}">
                            {{ $ticket->deadline ? $ticket->deadline->format('d/m/Y') : 'Sin deadline' }}
                        </dd>
                    </div>
                </dl>

                <hr class="border-line">

                {{-- Progress --}}
                @php $progress = $ticket->progress; @endphp
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <h2 class="eyebrow">Progreso</h2>
                        <span class="text-xs text-muted tabular-nums">{{ round($progress) }}% · {{ $ticket->subtasks->where('completed', true)->count() }}/{{ $ticket->subtasks->count() }}</span>
                    </div>
                    <div class="w-full h-2 bg-bg rounded-full overflow-hidden" role="progressbar" aria-valuenow="{{ round($progress) }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="h-full bg-success rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                    </div>
                </div>

                {{-- Subtasks --}}
                <div>
                    <h2 class="eyebrow mb-2.5">Subtareas</h2>
                    <div class="space-y-1.5 mb-2.5">
                        @foreach($ticket->subtasks()->orderBy('sort_order')->get() as $subtask)
                            <div class="flex items-center gap-2 text-sm">
                                <form method="POST" action="{{ route('tickets.subtasks.toggle', [$ticket, $subtask]) }}" class="shrink-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="icon-btn !w-6 !h-6 {{ $subtask->completed ? 'text-success' : '' }}"
                                        aria-label="{{ $subtask->completed ? 'Marcar como pendiente' : 'Marcar como completada' }}">
                                        @if($subtask->completed)
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        @else
                                            <span class="w-3.5 h-3.5 rounded-full border-2 border-current"></span>
                                        @endif
                                    </button>
                                </form>
                                <span class="flex-1 min-w-0 {{ $subtask->completed ? 'line-through text-faint' : '' }}">{{ $subtask->title }}</span>
                                <form method="POST" action="{{ route('tickets.subtasks.destroy', [$ticket, $subtask]) }}" onsubmit="return confirm('¿Eliminar esta subtarea?')" class="shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-btn icon-btn-danger !w-6 !h-6" aria-label="Eliminar subtarea">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                    <form method="POST" action="{{ route('tickets.subtasks.store', $ticket) }}" class="flex gap-2">
                        @csrf
                        <label for="subtask_title" class="sr-only">Nueva subtarea</label>
                        <input type="text" id="subtask_title" name="title" placeholder="Añadir subtarea..." required class="field !py-1.5 text-sm">
                        <button type="submit" class="btn btn-secondary btn-sm shrink-0" aria-label="Añadir subtarea">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </form>
                </div>

                {{-- Files --}}
                <div>
                    <h2 class="eyebrow mb-2.5">Archivos adjuntos</h2>
                    @if($ticket->files->count() > 0)
                        <div class="space-y-1.5 mb-2.5">
                            @foreach($ticket->files as $file)
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-faint shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                    <a href="{{ route('tickets.files.download', [$ticket, $file->path]) }}" class="flex-1 min-w-0 truncate text-brand hover:underline">{{ $file->filename }}</a>
                                    @if(acting_user()?->id === $file->uploaded_by)
                                        <form method="POST" action="{{ route('tickets.files.destroy', [$ticket, $file->path]) }}" onsubmit="return confirm('¿Eliminar este archivo?')" class="shrink-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-btn icon-btn-danger !w-6 !h-6" aria-label="Eliminar archivo">
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <form method="POST" action="{{ route('tickets.files.store', $ticket) }}" enctype="multipart/form-data" class="flex gap-2 items-center">
                        @csrf
                        <label for="file_input" class="sr-only">Adjuntar archivo</label>
                        <input type="file" id="file_input" name="file" required class="flex-1 min-w-0 text-xs text-muted file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-surface-2 file:text-ink file:text-xs file:font-medium file:cursor-pointer">
                        <button type="submit" class="btn btn-secondary btn-sm shrink-0" aria-label="Subir archivo">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main : conversation --}}
        <main class="flex-1 min-w-0 space-y-6">
            {{-- Comment Form --}}
            <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}" class="card p-4 sm:p-5">
                @csrf
                <label for="comment_message" class="sr-only">Comentario</label>
                <textarea id="comment_message" name="message" placeholder="Escribe un comentario..." rows="3" required class="field resize-y mb-3"></textarea>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-4-.8L3 20l1.3-3.9C3.5 15 3 13.6 3 12c0-4.42 4.03-8 9-8s9 3.58 9 8z"/></svg>
                        Comentar
                    </button>
                </div>
            </form>

            {{-- Comments --}}
            @php $comments = $ticket->comments()->orderBy('created_at', 'asc')->get(); @endphp
            @if($comments->isNotEmpty())
                <div class="space-y-3">
                    @foreach($comments as $comment)
                        @php $mine = acting_user()?->id === $comment->user_id; @endphp
                        <article class="card p-4 sm:p-5 {{ $mine ? '!border-brand/30' : '' }}">
                            <div class="flex items-center gap-2.5 mb-2">
                                <span class="w-7 h-7 rounded-full bg-brand/15 text-brand flex items-center justify-center text-xs font-bold shrink-0" aria-hidden="true">
                                    {{ mb_strtoupper(mb_substr($comment->user->name, 0, 1)) }}
                                </span>
                                <span class="font-semibold text-sm">{{ $comment->user->name }}</span>
                                <span class="text-xs text-faint">{{ $comment->created_at->diffForHumans() }}</span>
                                @if($mine)
                                    <form method="POST" action="{{ route('tickets.comments.destroy', [$ticket, $comment]) }}" onsubmit="return confirm('¿Eliminar este comentario?')" class="ml-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn icon-btn-danger" aria-label="Eliminar comentario">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="text-sm text-ink/90 whitespace-pre-wrap break-words leading-relaxed pl-10">{{ $comment->message }}</div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="card p-8 text-center text-sm text-muted">Sé el primero en comentar.</div>
            @endif

            {{-- Audit Log --}}
            @if($ticket->auditLogs->count() > 0)
                <div class="card p-4 sm:p-5">
                    <h2 class="text-sm font-semibold mb-4">Historial de cambios</h2>
                    <ol class="space-y-2.5">
                        @foreach($ticket->auditLogs()->orderBy('created_at', 'desc')->get() as $log)
                            <li class="flex flex-wrap items-center gap-x-2.5 gap-y-1 text-xs">
                                <span class="inline-flex items-center gap-1.5 font-mono text-[11px] text-brand shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand" aria-hidden="true"></span>
                                    {{ $log->action }}
                                </span>
                                <span class="text-muted">{{ $log->performer->name }}</span>
                                @if($log->details)
                                    <span class="text-faint">— {{ $log->details }}</span>
                                @endif
                                <span class="text-faint ml-auto">{{ $log->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
