<x-layouts.installer :locale-context="$localeContext">
    <div class="mb-8 text-center">
        <p class="text-sm font-semibold text-content-muted">{{ __('installer.shell.eyebrow') }}</p>
        <h1 class="mt-3 text-3xl font-semibold tracking-normal text-content-primary">{{ __('installer.shell.heading') }}</h1>
        <p class="mx-auto mt-3 max-w-2xl text-sm leading-6 text-content-secondary">{{ __('installer.shell.description') }}</p>
    </div>

    <x-ui.card>
        <x-ui.stepper :steps="$steps" :current="$currentStep" />

        @if (session('installer_error'))
            <x-ui.alert variant="danger" class="mt-6">
                {{ session('installer_error') }}
            </x-ui.alert>
        @endif

        <div class="mt-8 grid gap-3">
            @foreach ($checks as $check)
                <div class="flex items-start justify-between gap-4 rounded-control border border-border-subtle bg-surface-muted px-4 py-3">
                    <div>
                        <p class="text-sm font-semibold text-content-primary">{{ __($check->labelKey) }}</p>
                        <p class="mt-1 text-sm leading-6 text-content-secondary">{{ __($check->messageKey) }}</p>
                    </div>
                    <span class="rounded-control border px-2 py-1 text-xs font-semibold {{ $check->status === 'ok' ? 'border-status-success bg-status-success-soft' : ($check->status === 'warning' ? 'border-status-warning bg-status-warning-soft' : 'border-status-danger bg-status-danger-soft') }}">
                        {{ __('installer.status.'.$check->status) }}
                    </span>
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('installer.lock') }}" class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
            @csrf
            <a href="{{ route('installer.show', ['step' => 'database']) }}" class="inline-flex min-h-11 items-center justify-center rounded-button border border-border-subtle bg-surface-card px-4 py-2 text-sm font-semibold text-content-primary hover:bg-surface-muted focus:outline-none focus:ring-2 focus:ring-focus-ring">
                {{ __('installer.actions.recheck') }}
            </a>
            <x-ui.button type="submit">
                {{ __('installer.actions.lock') }}
            </x-ui.button>
        </form>
    </x-ui.card>
</x-layouts.installer>
