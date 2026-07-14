@if ($paginator->hasPages())
    <nav class="flex flex-wrap items-center justify-between gap-3" role="navigation" aria-label="Paginación">
        <p class="text-xs text-muted">
            Mostrando <span class="tabular-nums font-medium text-ink">{{ $paginator->firstItem() }}</span>–<span class="tabular-nums font-medium text-ink">{{ $paginator->lastItem() }}</span>
            de <span class="tabular-nums font-medium text-ink">{{ $paginator->total() }}</span>
        </p>
        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="btn btn-secondary btn-sm opacity-40 cursor-not-allowed" aria-disabled="true">Anterior</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn btn-secondary btn-sm">Anterior</a>
            @endif

            <span class="text-xs text-faint tabular-nums px-1">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn btn-secondary btn-sm">Siguiente</a>
            @else
                <span class="btn btn-secondary btn-sm opacity-40 cursor-not-allowed" aria-disabled="true">Siguiente</span>
            @endif
        </div>
    </nav>
@endif
