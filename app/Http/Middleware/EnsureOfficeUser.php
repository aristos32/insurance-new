<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOfficeUser
{
    public function handle(Request $request, Closure $next, string $minimumRole = '3'): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isActive()) {
            abort(403, 'Account is not active.');
        }

        $minimum = UserRole::from($minimumRole);

        if (! $user->roleEnum()->atLeast($minimum)) {
            abort(403, 'Insufficient permissions.');
        }

        return $next($request);
    }
}
