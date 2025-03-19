<?php

namespace App\Http\Middleware;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Scopes\VisibleScope;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyVisibleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Book::addGlobalScope(VisibleScope::class);
        BookCopy::addGlobalScope(VisibleScope::class);

        return $next($request);
    }
}
