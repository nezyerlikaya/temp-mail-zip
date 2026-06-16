@props([
    'title',
    'description' => null,
])

<header class="mb-8">
    <h1 class="text-2xl font-semibold text-content-primary">{{ $title }}</h1>

    @if ($description)
        <p class="mt-2 max-w-3xl text-sm leading-6 text-content-secondary">{{ $description }}</p>
    @endif
</header>
