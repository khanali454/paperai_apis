<?php
namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Override unauthenticated handling for APIs.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => 'Unauthenticated.',
        ], 401);
    }

    /**
     * Render exceptions into an HTTP response.
     */
    public function render($request, Throwable $e): JsonResponse | \Symfony\Component\HttpFoundation\Response
    {
        if ($request->is('api/*')) {
            return match (true) {
                $e instanceof AuthenticationException => response()->json([
                    'success' => false,
                    'message' => 'Unauthorized Request.',
                ], 401),

                default => response()->json([
                    'success' => false,
                    'message' => 'An unexpected error occurred.',
                    'details' => $e->getMessage(),
                ], 500),
            };
        }

        return parent::render($request, $e);
    }
}
