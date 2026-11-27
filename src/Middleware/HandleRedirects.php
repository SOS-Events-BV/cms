<?php

namespace SOSEventsBV\Cms\Middleware;

use Closure;
use Illuminate\Http\Request;
use SOSEventsBV\Cms\Models\Redirect;
use SOSEventsBV\Cms\Facades\Weglot;

class HandleRedirects
{
    public function handle(Request $request, Closure $next)
    {
        // Don't check for redirects on admin pages
        if ($request->is('admin') || $request->is('admin/*')) return $next($request);

        // Get the redirect
        $redirect = Redirect::query()
            ->where('from', $request->path())
            ->where(function ($query) {
                $query->where('language', Weglot::language())
                    ->orWhereNull('language');
            })
            ->orderByRaw('language IS NULL')
            ->first();

        // If there is a redirect there, redirect to `to`
        if($redirect) {
            return redirect($redirect->to, $redirect->status_code);
        }

        // Otherwise, continue
        return $next($request);
    }
}
