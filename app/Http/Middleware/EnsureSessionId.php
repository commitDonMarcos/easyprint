<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSessionId
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionId = $request->header('X-Session-Id', $request->cookie('session_id'));

        if (!$sessionId) {
            $sessionId = (string) str()->uuid();
        }

        $request->attributes->set('session_id', $sessionId);

        $response = $next($request);

        if (!$request->hasHeader('X-Session-Id')) {
            $response->header('X-Session-Id', $sessionId);
        }

        return $response;
    }
}
