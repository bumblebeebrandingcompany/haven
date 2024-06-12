<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SelldoAuth
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('selldo')->check()) {
            return redirect(route('selldo.login'));
        }
        $response = $next($request);

        return $response;

    }
}
