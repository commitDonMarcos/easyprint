<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;
use App\Models\Project;
use App\Models\Template;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function __construct(private AnalyticsService $analytics) {}

    public function index()
    {
        $stats = [
            'totalVisitors' => $this->analytics->getUniqueVisitors(),
            'totalTemplateSelections' => $this->analytics->getTotalTemplateSelections(),
            'totalDocxExports' => $this->analytics->getTotalDocxExports(),
            'totalPdfExports' => $this->analytics->getTotalPdfExports(),
            'mostUsedTemplates' => $this->analytics->getMostUsedTemplates(),
            'dailyStats' => $this->analytics->getDailyStats(30),
            'totalProjects' => Project::count(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
        ]);
    }
}
