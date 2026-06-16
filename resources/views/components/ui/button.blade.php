@props([
    'type' => 'button',
    'variant' => 'primary',
    'loading' => false,
    'disabled' => false,
])

@php
    $classes = [
        'primary' => 'bg-brand-primary text-white hover:bg-brand-primary-hover',
        'secondary' => 'border border-border-subtle bg-surface-card text-content-primary hover:bg-surface-muted',
    ][$variant] ?? 'bg-brand-primary text-white hover:bg-brand-primary-hover';
@endphp

<button
    type="{{ $type }}"
    @disabled($disabled || $loading)
    {{ $attributes->merge(['class' => 'inline-flex min-h-11 items-center justify-center rounded-button px-4 py-2 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-focus-ring disabled:cursor-not-allowed disabled:opacity-60 '.$classes]) }}
>
    {{ $slot }}
</button>
