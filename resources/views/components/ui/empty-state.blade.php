@props([
    'title',
    'description',
])

<section class="rounded-card border border-border-subtle bg-surface-card p-6 shadow-subtle" aria-label="{{ $title }}">
    <div class="max-w-2xl">
        <h2 class="text-base font-semibold text-content-primary">{{ $title }}</h2>
        <p class="mt-2 text-sm leading-6 text-content-secondary">{{ $description }}</p>
    </div>
</section>
