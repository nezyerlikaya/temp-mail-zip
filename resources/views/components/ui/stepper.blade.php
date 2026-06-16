@props([
    'steps' => [],
    'current',
])

@php
    $currentIndex = collect($steps)->search(fn ($step) => $step['id'] === $current);
    $currentIndex = $currentIndex === false ? 0 : $currentIndex;
@endphp

<ol class="grid gap-3 md:grid-cols-3 lg:grid-cols-6">
    @foreach ($steps as $index => $step)
        @php
            $isActive = $step['id'] === $current;
            $isComplete = $index < $currentIndex;
        @endphp
        <li
            class="rounded-control border px-3 py-2 text-sm {{ $isActive ? 'border-focus-ring bg-surface-card text-content-primary' : ($isComplete ? 'border-status-success bg-status-success-soft text-content-primary' : 'border-border-subtle bg-surface-muted text-content-muted') }}"
            @if($isActive) aria-current="step" @endif
        >
            <span class="block text-xs font-medium">{{ $isComplete ? __('installer.stepper.complete') : ($isActive ? __('installer.stepper.current') : __('installer.stepper.pending')) }}</span>
            <span class="mt-1 block font-semibold">{{ $step['label'] }}</span>
        </li>
    @endforeach
</ol>
