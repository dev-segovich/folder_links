@extends('layouts.app-no-sidebar')

@section('title', 'Directorio de Proyectos')

@section('topbar')
<div>
    <h1 class="text-xl font-bold tracking-tight">Proyectos</h1>
    <p class="text-sm text-faint">{{ $projects->count() }} {{ Str::plural('proyecto', $projects->count()) }}</p>
</div>
<div class="ml-auto">
    @include('partials._env_toggle', ['env' => $env])
</div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
    @if($projects->isEmpty())
        <div class="card p-12 text-center">
            <p class="text-muted">No hay proyectos visibles.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($projects as $project)
                @include('partials._project_card', ['project' => $project])
            @endforeach
        </div>
    @endif
</div>
@endsection
