<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * For API routes we return a JSON response instead of redirecting.
     */
    protected function redirectTo($request): ?string
    {
        // Always return JSON for API requests
        if ($request->expectsJson() || $request->is('api/*')) {
            abort(response()->json([
                'success' => false,
                'message' => 'Unauthenticated.'
            ], 401));
        }

       
        return null;
    }
}
