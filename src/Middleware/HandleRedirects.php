<?php

namespace SOSEventsBV\Cms\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use SOSEventsBV\Cms\Models\Redirect;

class HandleRedirects
{
    public function handle(Request $request, Closure $next)
    {
        // Don't check for redirects on admin pages
        if ($request->is('admin') || $request->is('admin/*')) return $next($request);

        // Cache all redirects, if not done so
        $redirect = Redirect::query()
            ->where('from', $request->path())
            ->first();

        // If there is a redirect there, redirect to `to`
        if($redirect) {
            return redirect($redirect->to, $redirect->status_code);
        }

        // Otherwise, continue
        return $next($request);
    }
}
