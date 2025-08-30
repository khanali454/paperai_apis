<?php 
use Illuminate\Auth\AuthenticationException;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'message' => $exception->getMessage() ?? 'Unauthenticated.',
        ], 401);
    }
}
