<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizEntryPointRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $referrer = $request->headers->get('referer');
        $host = parse_url($referrer, PHP_URL_HOST);

        if ($host !== 'luchbux.fun' && preg_match('/^\/giveaway\/quiz\?step=\d+$/', $request->getPathInfo())) {
            return redirect()->route('giveaway')->status(301);
        }

        return $next($request);
    }
}