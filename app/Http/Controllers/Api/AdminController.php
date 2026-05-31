<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\AnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(private AnalyticsService $analytics) {}

    public function dashboard(): JsonResponse
    {
        $stats = [
            'total_visitors' => $this->analytics->getUniqueVisitors(),
            'total_template_selections' => $this->analytics->getTotalTemplateSelections(),
            'total_docx_exports' => $this->analytics->getTotalDocxExports(),
            'total_pdf_exports' => $this->analytics->getTotalPdfExports(),
            'most_used_templates' => $this->analytics->getMostUsedTemplates(),
            'daily_stats' => $this->analytics->getDailyStats(30),
            'total_projects' => Project::count(),
        ];

        return response()->json(['data' => $stats]);
    }
}
