<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        abort_if(! $request->user(), 403);
        switch ($role) {
            case 'user':
                abort_if($request->user()->is_admin, 403);
                break;
            case 'admin':
                abort_if(! $request->user()->is_admin, 403);
                break;
            default:
                abort(403);
        }

        return $next($request);
    }
}
