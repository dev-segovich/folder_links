{{-- Loads the Vite-bundled Instrument Sans stylesheet (from the fonts manifest). --}}
@php $fontsManifest = public_path('build/fonts-manifest.json'); @endphp
@if(file_exists($fontsManifest))
    <link rel="stylesheet" href="{{ asset('build/' . (json_decode(file_get_contents($fontsManifest), true)['style']['file'] ?? '')) }}">
@endif
