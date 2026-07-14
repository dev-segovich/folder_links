{{-- Heatmap — rejilla de actividad tipo GitHub. Métrica conmutable en cliente (JS: initHeatmap). --}}
{{-- $heatmap: ['start', 'end', 'default', 'metrics' => [key => ['label','singular','plural','counts' => ['YYYY-MM-DD' => n]]]] --}}
@php
    $metrics = $heatmap['metrics'];
    $active = $heatmap['default'];

    $months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    $dayLabels = ['Lun', '', 'Mié', '', 'Vie', '', ''];

    // Escala 0-4 relativa al día más activo de la métrica (como GitHub).
    $level = function (int $count, int $max): int {
        if ($count < 1) {
            return 0;
        }

        return min(4, max(1, (int) ceil($count / max($max, 1) * 4)));
    };

    // Metadatos que el JS necesita para recalcular niveles y totales al cambiar de métrica.
    $meta = collect($metrics)
        ->map(fn ($metric) => [
            'label' => $metric['label'],
            'singular' => $metric['singular'],
            'plural' => $metric['plural'],
            'max' => $metric['counts'] ? max($metric['counts']) : 0,
            'total' => array_sum($metric['counts']),
        ])
        ->all();

    // Semanas como columnas de 7 días (lunes arriba); los días futuros quedan en blanco.
    $end = \Illuminate\Support\Carbon::parse($heatmap['end'])->endOfDay();
    $cursor = \Illuminate\Support\Carbon::parse($heatmap['start'])->startOfWeek();

    $weeks = [];
    while ($cursor->lte($end)) {
        $week = [];
        for ($i = 0; $i < 7; $i++) {
            $week[] = $cursor->lte($end) ? $cursor->copy() : null;
            $cursor->addDay();
        }
        $weeks[] = $week;
    }
@endphp

<div class="card p-6 heatmap" id="heatmap" data-metric="{{ $active }}" data-metrics='@json($meta)'>
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="text-base font-semibold">Actividad del último año</h2>
            <p class="text-sm text-faint mt-0.5">
                <span data-heatmap-total>{{ $meta[$active]['total'] }} {{ $meta[$active]['total'] === 1 ? $meta[$active]['singular'] : $meta[$active]['plural'] }}</span>
                en las últimas 52 semanas
            </p>
        </div>

        <div class="heatmap-tabs" role="group" aria-label="Métrica del mapa de calor">
            @foreach ($metrics as $key => $metric)
                <button type="button"
                        class="heatmap-tab"
                        data-metric="{{ $key }}"
                        aria-pressed="{{ $key === $active ? 'true' : 'false' }}">
                    {{ $metric['label'] }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="flex gap-2">
        {{-- Columna de días (fija, no scrollea con la rejilla) --}}
        <div class="flex flex-col gap-[3px] shrink-0 pt-[18px]">
            @foreach ($dayLabels as $day)
                <div class="h-3 flex items-center text-[10px] leading-none text-faint">{{ $day }}</div>
            @endforeach
        </div>

        <div class="overflow-x-auto pb-1 flex-1">
            <div class="min-w-max">
                {{-- Etiquetas de mes: se muestran en la primera semana de cada mes --}}
                <div class="flex gap-[3px] h-[18px]">
                    @php $lastMonth = null; @endphp
                    @foreach ($weeks as $week)
                        @php
                            $firstDay = collect($week)->first(fn ($day) => $day !== null);
                            $showMonth = $firstDay && $firstDay->month !== $lastMonth;
                            if ($showMonth) {
                                $lastMonth = $firstDay->month;
                            }
                        @endphp
                        <div class="w-3 shrink-0 relative">
                            @if ($showMonth)
                                <span class="absolute left-0 top-0 text-[10px] leading-none text-faint whitespace-nowrap">
                                    {{ $months[$firstDay->month - 1] }}
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Rejilla: una columna por semana --}}
                <div class="flex gap-[3px]">
                    @foreach ($weeks as $week)
                        <div class="flex flex-col gap-[3px]">
                            @foreach ($week as $day)
                                @if ($day === null)
                                    <div class="heatmap-cell heatmap-cell-blank" aria-hidden="true"></div>
                                @else
                                    @php
                                        $key = $day->toDateString();
                                        $counts = [];
                                        foreach ($metrics as $metricKey => $metric) {
                                            $counts[$metricKey] = $metric['counts'][$key] ?? 0;
                                        }
                                        $count = $counts[$active];
                                        $dateLabel = $day->day.' '.$months[$day->month - 1].' '.$day->year;
                                        $noun = $count === 1 ? $meta[$active]['singular'] : $meta[$active]['plural'];
                                    @endphp
                                    <div class="heatmap-cell"
                                         data-date="{{ $key }}"
                                         data-label="{{ $dateLabel }}"
                                         @foreach ($counts as $metricKey => $metricCount)
                                             data-{{ $metricKey }}="{{ $metricCount }}"
                                         @endforeach
                                         data-level="{{ $level($count, $meta[$active]['max']) }}"
                                         title="{{ $count }} {{ $noun }} · {{ $dateLabel }}"></div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 flex items-center justify-end gap-1.5 text-[11px] text-faint">
        <span class="mr-1">Menos</span>
        @for ($i = 0; $i <= 4; $i++)
            <div class="heatmap-cell" data-level="{{ $i }}" aria-hidden="true"></div>
        @endfor
        <span class="ml-1">Más</span>
    </div>
</div>
