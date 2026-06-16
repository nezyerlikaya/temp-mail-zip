@props([
    'navigation' => [],
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
        <title>{{ __('admin.shell.title') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-surface-canvas font-sans text-content-primary antialiased">
        <a href="#admin-main" class="sr-only focus:not-sr-only focus:fixed focus:start-4 focus:top-4 focus:z-50 focus:rounded-control focus:bg-surface-card focus:px-4 focus:py-2 focus:text-content-primary focus:shadow-card">
            {{ __('admin.shell.skip_to_content') }}
        </a>

        <div class="min-h-screen lg:flex">
            <aside class="border-b border-border-subtle bg-surface-card lg:min-h-screen lg:w-72 lg:border-b-0 lg:border-e">
                <div class="flex min-h-16 items-center border-b border-border-subtle px-6">
                    <span class="text-sm font-semibold tracking-wide text-content-primary">{{ __('admin.shell.brand') }}</span>
                </div>

                <nav aria-label="{{ __('admin.navigation.label') }}" class="space-y-1 p-4">
                    @foreach ($navigation as $item)
                        <a
                            href="{{ route($item->routeName) }}"
                            class="block rounded-control px-3 py-2 text-sm font-medium text-content-secondary hover:bg-surface-muted hover:text-content-primary focus:outline-none focus:ring-2 focus:ring-focus-ring"
                        >
                            {{ __($item->labelKey) }}
                        </a>
                    @endforeach
                </nav>
            </aside>

            <div class="min-w-0 flex-1">
                <header class="border-b border-border-subtle bg-surface-card px-6 py-4">
                    <div class="flex min-h-10 items-center justify-between gap-4">
                        <p class="text-sm text-content-muted">{{ __('admin.shell.environment_notice') }}</p>
                    </div>
                </header>

                <main id="admin-main" class="mx-auto w-full max-w-6xl px-6 py-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
