{{-- Env Toggle Component — switches project links between PROD and LOCAL (JS: initEnvToggle) --}}
@php $isLocal = ($env ?? 'prod') === 'local'; @endphp
<div class="inline-flex items-center gap-2.5 card px-3 py-2 text-xs font-bold tracking-wide">
    <span data-env-label="prod" class="{{ $isLocal ? 'text-faint' : 'text-brand' }}">PROD</span>
    <label class="relative inline-block w-9 h-5 cursor-pointer" title="Cambiar entorno de los enlaces">
        <span class="sr-only">Alternar entre enlaces de producción y locales</span>
        <input type="checkbox" id="envToggle" class="sr-only peer" {{ $isLocal ? 'checked' : '' }}>
        <span class="block w-full h-full bg-bg border border-line rounded-full transition peer-checked:bg-brand peer-checked:border-brand" aria-hidden="true"></span>
        <span class="absolute top-0.5 left-0.5 w-4 h-4 bg-faint rounded-full transition peer-checked:translate-x-4 peer-checked:bg-white" aria-hidden="true"></span>
    </label>
    <span data-env-label="local" class="{{ $isLocal ? 'text-brand' : 'text-faint' }}">LOCAL</span>
</div>
