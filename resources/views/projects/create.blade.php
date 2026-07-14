@extends('layouts.app-no-sidebar')

@section('title', 'Nuevo Proyecto')

@section('topbar')
<a href="{{ route('projects.index') }}" class="btn btn-ghost btn-sm -ml-2">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
    Volver
</a>
<h1 class="text-xl font-bold tracking-tight truncate">Nuevo Proyecto</h1>
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data" class="card p-5 lg:p-8">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
            <div class="sm:col-span-2">
                <label for="name" class="label">Nombre <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="field @error('name') !border-danger @enderror">
                @error('name')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="env" class="label">Entorno</label>
                <select id="env" name="env" class="field cursor-pointer">
                    <option value="" {{ old('env') === null ? 'selected' : '' }}>Ninguno</option>
                    <option value="prod" {{ old('env') === 'prod' ? 'selected' : '' }}>PROD</option>
                    <option value="qa" {{ old('env') === 'qa' ? 'selected' : '' }}>QA</option>
                </select>
                @error('env')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="status" class="label">Estado</label>
                <input type="text" id="status" name="status" value="{{ old('status') }}"
                    placeholder="actualizado" class="field">
                @error('status')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="prod_url" class="label">URL de producción</label>
                <input type="url" id="prod_url" name="prod_url" value="{{ old('prod_url') }}"
                    placeholder="https://..." class="field @error('prod_url') !border-danger @enderror">
                @error('prod_url')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="local_url" class="label">URL local</label>
                <input type="url" id="local_url" name="local_url" value="{{ old('local_url') }}"
                    placeholder="http://localhost:..." class="field @error('local_url') !border-danger @enderror">
                @error('local_url')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            <div class="sm:col-span-2">
                <label for="image" class="label">Logo</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="flex-1 min-w-0 text-xs text-muted file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-surface-2 file:text-ink file:text-xs file:font-medium file:cursor-pointer">
                @error('image')<span class="field-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="mb-6 flex items-start gap-3 rounded-lg bg-surface-2/50 border border-line p-3.5">
            <input type="checkbox" id="hidden_from_boss" name="hidden_from_boss" value="1" class="accent-brand w-4 h-4 mt-0.5"
                {{ old('hidden_from_boss') ? 'checked' : '' }}>
            <label for="hidden_from_boss" class="text-sm cursor-pointer select-none">
                <span class="font-medium">Oculto para Rey</span>
                <span class="block text-xs text-faint mt-0.5">El proyecto y sus tickets no serán visibles sin iniciar sesión.</span>
            </label>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:items-center gap-3 border-t border-line -mx-5 lg:-mx-8 px-5 lg:px-8 pt-5">
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Crear Proyecto</button>
        </div>
    </form>
</div>
@endsection
