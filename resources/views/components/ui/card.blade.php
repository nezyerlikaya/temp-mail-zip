@props([
    'title' => null,
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'rounded-card border border-border-subtle bg-surface-card p-6 shadow-subtle']) }}>
    @if ($title || $description)
        <header class="mb-5">
            @if ($title)
                <h2 class="text-base font-semibold text-content-primary">{{ $title }}</h2>
            @endif

            @if ($description)
                <p class="mt-2 text-sm leading-6 text-content-secondary">{{ $description }}</p>
            @endif
        </header>
    @endif

    {{ $slot }}
</section>
