<?php

namespace App\Modules\Localization\Http\Middleware;

use App\Modules\Localization\Services\LocaleResolver;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

final class ResolveLocale
{
    public function __construct(private readonly LocaleResolver $resolver)
    {
    }

    /**
     * @param Closure(Request): Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $context = $this->resolver->resolveFromRequest($request);

        App::setLocale($context->lang());
        View::share('activeLanguage', $context->activeLanguage);
        View::share('localeContext', $context);

        return $next($request);
    }
}
