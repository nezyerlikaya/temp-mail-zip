<?php

namespace App\Modules\Installer\Http\Middleware;

use App\Modules\Installer\Services\InstallationState;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class InstallerGate
{
    public function __construct(private readonly InstallationState $state = new InstallationState())
    {
    }

    /**
     * @param Closure(Request): Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('installer.*')) {
            if ($this->state->isInstalled()) {
                abort(423);
            }

            return $next($request);
        }

        if (! $this->state->isInstalled()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => __('installer.messages.install_required')], 503);
            }

            return redirect()->route('installer.show');
        }

        return $next($request);
    }
}
