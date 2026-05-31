<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(private AnalyticsService $analytics) {}

    public function track(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'action' => 'required|string|in:visit,template_selection,docx_export,pdf_export',
            'template_id' => 'nullable|integer|exists:templates,id',
            'metadata' => 'nullable|array',
        ]);

        $sessionId = $request->header('X-Session-Id', $request->input('session_id', 'unknown'));

        $this->analytics->track(
            $sessionId,
            $validated['action'],
            $validated['template_id'] ?? null,
            $validated['metadata'] ?? null
        );

        return response()->json(['message' => 'Analytics tracked successfully.']);
    }
}
