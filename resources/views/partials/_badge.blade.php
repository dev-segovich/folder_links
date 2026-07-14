{{-- Badge Component --}}
{{-- Usage: @include('partials._badge', ['type' => 'prod', 'text' => 'PROD']) --}}
@php
    $base = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold leading-none';

    // type => [classes, show leading dot]
    $types = [
        'prod'        => ['bg-brand/12 text-brand ring-1 ring-inset ring-brand/25', true],
        'qa'          => ['bg-warn/12 text-warn ring-1 ring-inset ring-warn/25', true],
        'tickets'     => ['bg-info/12 text-info ring-1 ring-inset ring-info/25', true],

        'backlog'     => ['bg-faint/15 text-muted', true],
        'en_progreso' => ['bg-info/12 text-info', true],
        'en_revision' => ['bg-purple/15 text-purple', true],
        'done'        => ['bg-success/12 text-success', true],

        'baja'        => ['bg-surface-2 text-muted', true],
        'media'       => ['bg-warn/12 text-warn', true],
        'alta'        => ['bg-danger/12 text-danger-ink', true],
        'critica'     => ['bg-danger/20 text-danger-ink ring-1 ring-inset ring-danger/40', true],

        'overdue'     => ['bg-danger/20 text-danger-ink ring-1 ring-inset ring-danger/40', false],
    ];

    [$typeClass, $dot] = $types[$type ?? ''] ?? ['bg-surface-2 text-muted', false];
    $classes = trim("$base $typeClass");
@endphp

<span class="{{ $classes }} {{ $extra ?? '' }}">
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full bg-current opacity-80" aria-hidden="true"></span>
    @endif
    {{ $text ?? $slot }}
</span>
