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
        $prevUrl = $request->session()->previousUrl();
        $isSamePrevUrl = $prevUrl && (str_contains($prevUrl, 'tonyandr.com') || str_contains($prevUrl, 'luchbux.fun'));
        $fullPath = $request->fullUrl();
        $isQuizStep = str_contains($fullPath, '/giveaway/quiz?step=');
        if ($isQuizStep && !$isSamePrevUrl) {
            return redirect()->route('giveaway', [], 302);
        }

        return $next($request);
    }
}