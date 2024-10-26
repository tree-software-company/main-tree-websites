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
        // Retrieve the locale from the request or default to 'en'
        $locale = $request->locale ?? 'en-us'; 

        // Validate the locale
        if (!in_array($locale, ['en-us', 'pl'])) {
            throw new NotFoundHttpException(); // Throw 404 for invalid locale
        }

        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}

