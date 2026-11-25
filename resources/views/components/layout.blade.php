@props([
    'title' => config('app.name'),
    'description' => '',
    'keywords' => null,
    'og_title' => null,
    'og_description' => null,
    'og_image' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- SEO --}}
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">

    @if ($keywords)
        <meta name="keywords" content="{{ $keywords }}">
    @endif

    {{-- Open Graph (OG) --}}
    <meta property="og:title" content="{{ $og_title ?? $title }}" />
    <meta property="og:description" content="{{ $og_description ?? $description }}" />
    @if (isset($og_image))
        <meta property="og:image"
            content="{{ str_starts_with($og_image, 'http') ? $og_image : asset(Storage::url($og_image)) }}" />
    @endif

    <link rel="canonical" href="{{ \SOSEventsBV\Cms\Facades\Seo::canonical() }}">
    {{-- / SEO --}}

    {{-- Styles  --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @endif

    @stack('head')

    @livewireStyles
    {{-- / Styles --}}
</head>

<body>
    {{ $slot }}

    {{-- Scripts --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/js/app.js'])
    @endif

    @stack('body')

    @livewireScripts
    {{-- / Scripts --}}
</body>

</html>
