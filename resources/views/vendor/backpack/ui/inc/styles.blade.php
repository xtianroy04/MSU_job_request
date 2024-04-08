@basset('https://unpkg.com/animate.css@4.1.1/animate.compat.css')
{{-- <link href="{{ asset('assets/theme/css/animate.compat.css') }}" rel="stylesheet">
<link href="{{ asset('assets/theme/css/noty.css') }}" rel="stylesheet"> --}}
@basset('https://unpkg.com/noty@3.2.0-beta-deprecated/lib/noty.css')
<link rel="shortcut icon" href="{{ asset('images/logo.png')}}" type="image/x-icon">
{{-- <link href="{{ asset('assets/theme/css/line-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/theme/fonts/la-regular-400.woff2') }}" rel="preload" as="font" type="font/woff2" crossorigin>
<link href="{{ asset('assets/theme/fonts/la-solid-900.woff2') }}" rel="preload" as="font" type="font/woff2" crossorigin>
<link href="{{ asset('assets/theme/fonts/la-brands-400.woff2') }}" rel="preload" as="font" type="font/woff2" crossorigin>

<link href="{{ asset('assets/theme/fonts/la-regular-400.woff') }}" rel="preload" as="font" type="font/woff" crossorigin>
<link href="{{ asset('assets/theme/fonts/la-solid-900.woff') }}" rel="preload" as="font" type="font/woff" crossorigin>
<link href="{{ asset('assets/theme/fonts/la-brands-400.woff') }}" rel="preload" as="font" type="font/woff" crossorigin>

<link href="{{ asset('assets/theme/fonts/la-regular-400.ttf') }}" rel="preload" as="font" type="font/ttf" crossorigin>
<link href="{{ asset('assets/theme/fonts/la-solid-900.ttf') }}" rel="preload" as="font" type="font/ttf" crossorigin>
<link href="{{ asset('assets/theme/fonts/la-brands-400.ttf') }}" rel="preload" as="font" type="font/ttf" crossorigin> --}}

@basset('https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css')
@basset('https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/fonts/la-regular-400.woff2')
@basset('https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/fonts/la-solid-900.woff2')
@basset('https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/fonts/la-brands-400.woff2')
@basset('https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/fonts/la-regular-400.woff')
@basset('https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/fonts/la-solid-900.woff')
@basset('https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/fonts/la-brands-400.woff')
@basset('https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/fonts/la-regular-400.ttf')
@basset('https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/fonts/la-solid-900.ttf')
@basset('https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/fonts/la-brands-400.ttf')

@basset(base_path('vendor/backpack/crud/src/resources/assets/css/common.css'))

@if (backpack_theme_config('styles') && count(backpack_theme_config('styles')))
    @foreach (backpack_theme_config('styles') as $path)
        @if(is_array($path))
            @basset(...$path)
        @else
            @basset($path)
        @endif
    @endforeach
@endif

@if (backpack_theme_config('mix_styles') && count(backpack_theme_config('mix_styles')))
    @foreach (backpack_theme_config('mix_styles') as $path => $manifest)
        <link rel="stylesheet" type="text/css" href="{{ mix($path, $manifest) }}">
    @endforeach
@endif

@if (backpack_theme_config('vite_styles') && count(backpack_theme_config('vite_styles')))
    @vite(backpack_theme_config('vite_styles'))
@endif
