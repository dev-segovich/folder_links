{{-- Alert Component --}}
@php
    $types = [
        'error'   => ['bg-danger/10 ring-danger/30 text-danger-ink', 'M12 9v3.75m0 3.75h.007M10.34 3.94l-7.5 12.99A1.5 1.5 0 004.14 19.5h15.72a1.5 1.5 0 001.3-2.57l-7.5-12.99a1.5 1.5 0 00-2.62 0z'],
        'success' => ['bg-brand/10 ring-brand/30 text-brand', 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        'warning' => ['bg-warn/10 ring-warn/30 text-warn', 'M12 9v3.75m0 3.75h.007M10.34 3.94l-7.5 12.99A1.5 1.5 0 004.14 19.5h15.72a1.5 1.5 0 001.3-2.57l-7.5-12.99a1.5 1.5 0 00-2.62 0z'],
        'info'    => ['bg-info/10 ring-info/30 text-info', 'M11.25 11.25l.04-.02a.75.75 0 011.06.73v3.79m-1.1-6.5h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
    [$typeClass, $icon] = $types[$type ?? 'info'] ?? $types['info'];
@endphp
<div role="alert" class="flex items-start gap-2.5 px-4 py-3 rounded-lg ring-1 ring-inset {{ $typeClass }} text-sm mb-5 {{ $extra ?? '' }}">
    <svg class="w-5 h-5 shrink-0 mt-px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
    </svg>
    <span class="leading-snug">{{ $message ?? $slot }}</span>
</div>
