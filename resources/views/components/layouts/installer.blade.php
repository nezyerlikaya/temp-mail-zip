@props([
    'localeContext' => null,
])

@php
    $lang = $localeContext?->lang() ?? 'en';
    $dir = $localeContext?->dir() ?? 'ltr';
@endphp

<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $dir }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('installer.shell.title') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-surface-canvas font-sans text-content-primary antialiased">
        <main class="mx-auto flex min-h-screen w-full max-w-5xl flex-col justify-center px-6 py-10">
            {{ $slot }}
        </main>
    </body>
</html>
