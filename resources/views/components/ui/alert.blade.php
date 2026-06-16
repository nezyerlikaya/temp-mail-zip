@props([
    'variant' => 'info',
])

@php
    $classes = [
        'info' => 'border-status-info bg-status-info-soft text-content-primary',
        'success' => 'border-status-success bg-status-success-soft text-content-primary',
        'warning' => 'border-status-warning bg-status-warning-soft text-content-primary',
        'danger' => 'border-status-danger bg-status-danger-soft text-content-primary',
    ][$variant] ?? 'border-status-info bg-status-info-soft text-content-primary';
@endphp

<div role="alert" {{ $attributes->merge(['class' => 'rounded-card border px-4 py-3 text-sm leading-6 '.$classes]) }}>
    {{ $slot }}
</div>
