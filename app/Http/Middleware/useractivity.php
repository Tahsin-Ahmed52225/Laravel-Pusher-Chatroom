<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

use Cache;

use Carbon\Carbon;

class useractivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $expried_at = Carbon::now()->addMinute(1);
            Cache::put("user_is_online" . Auth::user()->id, true, $expried_at);
        }
        return $next($request);
    }
}
