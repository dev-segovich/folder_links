@extends('layouts.app-no-sidebar')

@section('title', isset($ticket) ? 'Editar Ticket' : 'Crear Ticket')

@section('topbar')
<a href="{{ route('tickets.index') }}" class="btn btn-ghost btn-sm -ml-2">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Volver
</a>
<h1 class="text-xl font-bold tracking-tight">{{ isset($ticket) ? 'Editar Ticket' : 'Crear Ticket' }}</h1>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
    <form method="POST" action="{{ isset($ticket) ? route('tickets.update', $ticket) : route('tickets.store') }}" class="card p-5 lg:p-8">
        @csrf
        @if(isset($ticket))
            @method('PUT')
        @endif

        {{-- Title + Project --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
            <div>
                <label for="title" class="label">Título <span class="text-danger">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $ticket->title ?? '') }}" required
                    class="field @error('title') !border-danger @enderror">
                @error('title')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="project_id" class="label">Proyecto <span class="text-danger">*</span></label>
                <select id="project_id" name="project_id" required class="field cursor-pointer @error('project_id') !border-danger @enderror">
                    <option value="">Seleccionar proyecto</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', isset($ticket) ? $ticket->project_id : '') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
                @error('project_id')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Description --}}
        <div class="mb-5">
            <label for="description" class="label">Descripción</label>
            <textarea id="description" name="description" rows="6" class="field resize-y @error('description') !border-danger @enderror">{{ old('description', $ticket->description ?? '') }}</textarea>
            @error('description')<span class="field-error">{{ $message }}</span>@enderror
        </div>

        {{-- Priority + Status --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
            <div>
                <label for="priority" class="label">Prioridad <span class="text-danger">*</span></label>
                <select id="priority" name="priority" required class="field cursor-pointer">
                    <option value="baja" {{ old('priority', $ticket->priority ?? '') == 'baja' ? 'selected' : '' }}>Baja</option>
                    <option value="media" {{ old('priority', $ticket->priority ?? 'media') == 'media' ? 'selected' : '' }}>Media</option>
                    <option value="alta" {{ old('priority', $ticket->priority ?? '') == 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="critica" {{ old('priority', $ticket->priority ?? '') == 'critica' ? 'selected' : '' }}>Crítica</option>
                </select>
                @error('priority')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="status" class="label">Estado</label>
                <select id="status" name="status" class="field cursor-pointer">
                    <option value="backlog" {{ old('status', $ticket->status ?? 'backlog') == 'backlog' ? 'selected' : '' }}>Backlog</option>
                    <option value="en_progreso" {{ old('status', $ticket->status ?? '') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                    <option value="en_revision" {{ old('status', $ticket->status ?? '') == 'en_revision' ? 'selected' : '' }}>En Revisión</option>
                    <option value="done" {{ old('status', $ticket->status ?? '') == 'done' ? 'selected' : '' }}>Done</option>
                </select>
            </div>
        </div>

        {{-- Assignee + Deadline --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
            <div>
                <label for="assigned_to" class="label">Asignado a</label>
                @if(can_see_hidden())
                    <select id="assigned_to" name="assigned_to" class="field cursor-pointer">
                        @foreach(\App\Models\User::where('role', 'dev')->get() as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to', $ticket->assigned_to ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" id="assigned_to" name="assigned_to" value="{{ \App\Models\User::where('role', 'dev')->first()->id }}">
                    <div class="field pointer-events-none bg-surface-2/50">{{ \App\Models\User::where('role', 'dev')->first()->name }}</div>
                @endif
            </div>
            <div>
                <label for="deadline" class="label">Deadline</label>
                <input type="date" id="deadline" name="deadline" value="{{ old('deadline', isset($ticket) ? $ticket->deadline?->format('Y-m-d') : '') }}" class="field">
            </div>
        </div>

        {{-- Visible from Boss (dev only) --}}
        @if(can_see_hidden())
            <div class="mb-6 flex items-start gap-3 rounded-lg bg-surface-2/50 border border-line p-3.5">
                <input type="checkbox" id="visible_from_boss" name="visible_from_boss" value="1" class="accent-brand w-4 h-4 mt-0.5"
                    {{ old('visible_from_boss', isset($ticket) ? $ticket->visible_from_boss ?? true : true) ? 'checked' : '' }}>
                <label for="visible_from_boss" class="text-sm cursor-pointer select-none">
                    <span class="font-medium">Visible para Rey</span>
                    <span class="block text-xs text-faint mt-0.5">Si se desmarca, el ticket queda oculto para Rey.</span>
                </label>
            </div>
        @endif

        {{-- Actions --}}
        <div class="flex flex-col-reverse sm:flex-row gap-3 border-t border-line -mx-5 lg:-mx-8 px-5 lg:px-8 pt-5">
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary sm:ml-auto">
                {{ isset($ticket) ? 'Guardar Cambios' : 'Crear Ticket' }}
            </button>
        </div>
    </form>
</div>
@endsection
