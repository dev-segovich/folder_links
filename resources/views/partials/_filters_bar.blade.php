{{-- Filters Bar Component --}}
<form method="GET" action="{{ $action ?? route('tickets.index') }}"
      class="card p-3 sm:p-4 mb-6 flex flex-col sm:flex-row gap-2.5 sm:items-center flex-wrap">
    @foreach($filters as $filter)
        @php
            $type = $filter['type'] ?? 'text';
            $label = $filter['label'] ?? ucfirst($filter['name']);
        @endphp
        <div class="flex-1 min-w-[160px]">
            <label for="filter_{{ $filter['name'] }}" class="sr-only">{{ $label }}</label>
            @if($type === 'select')
                <select id="filter_{{ $filter['name'] }}" name="{{ $filter['name'] }}" class="field cursor-pointer">
                    @foreach($filter['options'] as $optValue => $optLabel)
                        <option value="{{ $optValue }}" {{ (string) ($filter['value'] ?? '') === (string) $optValue ? 'selected' : '' }}>
                            {{ $optLabel }}
                        </option>
                    @endforeach
                </select>
            @else
                <input type="text" id="filter_{{ $filter['name'] }}" name="{{ $filter['name'] }}"
                    value="{{ $filter['value'] ?? '' }}" placeholder="{{ $filter['placeholder'] ?? $label }}"
                    class="field">
            @endif
        </div>
    @endforeach

    <div class="flex items-center gap-2">
        @foreach($buttons ?? [] as $button)
            @if($button['type'] === 'submit')
                <button type="submit" class="{{ $button['class'] ?? 'btn btn-primary' }}">{{ $button['text'] ?? 'Filtrar' }}</button>
            @elseif($button['type'] === 'link')
                <a href="{{ $button['href'] ?? '#' }}" class="{{ $button['class'] ?? 'btn btn-secondary' }}">{{ $button['text'] ?? 'Limpiar' }}</a>
            @endif
        @endforeach
    </div>
</form>
