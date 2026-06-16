<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Localization\Services\LocaleResolver;
use App\Modules\Navigation\Services\AdminNavigationManifest;
use App\Modules\Navigation\Services\AdminNavigationRegistry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class AdminDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $navigation = new AdminNavigationRegistry();
        (new AdminNavigationManifest())->registerDefaults($navigation);

        return view('admin.dashboard', [
            'adminNavigation' => $navigation->visible(),
            'localeContext' => (new LocaleResolver(new \App\Modules\Localization\Services\LocalizationRegistry()))->resolveFromRequest($request),
        ]);
    }
}
