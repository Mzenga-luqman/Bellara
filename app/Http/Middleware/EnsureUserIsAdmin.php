<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! (bool) $user->is_admin) {
            return redirect()
                ->route('home')
                ->withErrors([
                    'access' => 'You are not authorized to access the admin portal.',
                ]);
        }

        return $next($request);
    }
}
