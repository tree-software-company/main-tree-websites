<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Retrieve the locale from the route parameter or default to 'en-us'
        $locale = $request->route('locale') ?? 'en-us';

        // Validate the locale (allow 'en-us' and 'pl')
        if (!in_array($locale, ['en-us', 'pl'])) {
            throw new NotFoundHttpException(); // Throw 404 for invalid locale
        }

        // If the locale is 'en-us', remove it from the URL and redirect to the non-prefixed URL
        if ($locale === 'en-us') {
            // Set the application locale to 'en-us'
            App::setLocale('en-us');

            // Remove the 'en-us' prefix from the URL if present
            $url = $request->getRequestUri();
            $newUrl = preg_replace('/^\/en-us/', '', $url);

            // Redirect to the new URL without the 'en-us' prefix
            return redirect($newUrl);
        }

        // Set the application locale for other locales (like 'pl')
        App::setLocale($locale);

        return $next($request);
    }
}
