<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetGiveawayCookie
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
        if (!empty($request->participant)) {
            cookie()->queue(cookie()->forever('participant', $request->participant));
            
            if ($request->has('participant')) {
                return redirect()->to($request->fullUrlWithoutQuery('participant'));
            }
        }

        return $next($request);
    }
}
