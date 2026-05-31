<?php

namespace App\Http\Middleware;

use App\Services\AnalyticsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackAnalytics
{
    public function __construct(private AnalyticsService $analytics) {}

    public function handle(Request $request, Closure $next): Response
    {
        $sessionId = $request->cookie('session_id');

        if (!$sessionId) {
            $sessionId = (string) str()->uuid();
            cookie()->queue(cookie()->forever('session_id', $sessionId));
        }

        $request->attributes->set('session_id', $sessionId);

        $response = $next($request);

        if (!$request->is('admin*') && !$request->is('_debugbar*') && !$request->ajax() && !$request->isMethod('post')) {
            $this->analytics->trackVisit($sessionId);
        }

        return $response;
    }
}
