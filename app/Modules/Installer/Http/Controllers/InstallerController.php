<?php

namespace App\Modules\Installer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Installer\Services\InstallationState;
use App\Modules\Installer\Services\InstallerPreflightChecker;
use App\Modules\Installer\Services\InstallerProgressRepository;
use App\Modules\Localization\Services\LocaleResolver;
use App\Modules\Localization\Services\LocalizationRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class InstallerController extends Controller
{
    public function show(Request $request): View
    {
        $progress = new InstallerProgressRepository();

        if (is_string($request->query('step'))) {
            $progress->remember((string) $request->query('step'));
        }

        $checker = new InstallerPreflightChecker();
        $localeContext = (new LocaleResolver(new LocalizationRegistry()))->resolveFromRequest($request);

        return view('installer.show', [
            'checks' => $checker->checks(),
            'currentStep' => $progress->currentStep(),
            'localeContext' => $localeContext,
            'steps' => [
                ['id' => 'requirements', 'label' => __('installer.steps.requirements')],
                ['id' => 'environment', 'label' => __('installer.steps.environment')],
                ['id' => 'database', 'label' => __('installer.steps.database')],
                ['id' => 'application', 'label' => __('installer.steps.application')],
                ['id' => 'admin', 'label' => __('installer.steps.admin')],
                ['id' => 'finish', 'label' => __('installer.steps.finish')],
            ],
        ]);
    }

    public function lock(): RedirectResponse
    {
        $checker = new InstallerPreflightChecker();

        if ($checker->hasBlockers()) {
            return redirect()
                ->route('installer.show', ['step' => 'finish'])
                ->with('installer_error', __('installer.messages.blockers_remaining'));
        }

        (new InstallationState())->markInstalled();

        return redirect()->route('home');
    }
}
