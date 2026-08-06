<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): ResponseAlias
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles, true)) {
            abort(Response::HTTP_FORBIDDEN, 'You do not have access to this resource.');
        }

        return $next($request);
    }
}
