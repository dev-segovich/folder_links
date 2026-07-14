{{-- Button Component --}}
{{-- Usage: @include('partials._btn', ['href' => '#', 'text' => 'Click', 'variant' => 'primary', 'size' => 'sm']) --}}
@php
    $variants = [
        'primary'   => 'btn-primary',
        'secondary' => 'btn-secondary',
        'ghost'     => 'btn-ghost',
        'danger'    => 'btn-danger',
    ];

    $variantClass = $variants[$variant ?? 'primary'] ?? $variants['primary'];
    $sizeClass = ($size ?? 'default') === 'sm' ? 'btn-sm' : '';
    $blockClass = ($size ?? '') === 'block' ? 'w-full' : '';
    $classes = trim("btn {$variantClass} {$sizeClass} {$blockClass}");
@endphp

@if($href ?? false)
    <a href="{{ $href }}" class="{{ $classes }} {{ $extra ?? '' }}">
        {{ $text ?? $slot }}
    </a>
@else
    <button class="{{ $classes }} {{ $extra ?? '' }}" type="{{ $btnType ?? 'button' }}">
        {{ $text ?? $slot }}
    </button>
@endif
