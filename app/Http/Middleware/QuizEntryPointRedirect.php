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

        $ua = $request->server('HTTP_USER_AGENT') ?? '';
        $fullPath = $request->fullUrl();
        $isQuizStep = str_contains($fullPath, '/giveaway/quiz?step=');
        
        // redirect Yandex bots
        if (str_contains(strtolower($ua), 'yandex') && $isQuizStep) {
            return redirect()->route('giveaway', [], 301);
        }

        // redirect users from other sites
        $prevUrl = $request->session()->previousUrl() ?? '';
        $isSamePrevUrl = $prevUrl && (str_contains($prevUrl, 'tonyandr.com') || str_contains($prevUrl, 'luchbux.fun'));
        if ($isQuizStep && !$isSamePrevUrl) {
            return redirect()->route('giveaway', [], 302);
        }

        return $next($request);
    }
}