{{-- Stats Grid Component --}}
{{-- items: [ ['value'=>1,'label'=>'Activos','icon'=>'M...','accent'=>'bg-brand/12 text-brand'] ] --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
    @foreach($items as $item)
        <div class="card p-5 flex items-center gap-4">
            <span class="w-11 h-11 rounded-lg flex items-center justify-center shrink-0 {{ $item['accent'] ?? 'bg-brand/12 text-brand' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] ?? 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2' }}"/>
                </svg>
            </span>
            <div class="min-w-0">
                <div class="text-2xl font-bold leading-none tabular-nums">{{ $item['value'] }}</div>
                <div class="text-sm text-muted mt-1 truncate">{{ $item['label'] }}</div>
            </div>
        </div>
    @endforeach
</div>
