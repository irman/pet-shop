<?php

namespace App\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (is_null($user)) {
            throw new AuthenticationException('Failed to authenticate user');
        }

        if ($user->is_admin === 0) {
            throw new AccessDeniedHttpException('Unauthorized');
        }
        return $next($request);
    }
}
