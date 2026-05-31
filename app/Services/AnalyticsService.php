<?php

namespace App\Services;

use App\Models\UsageLog;
use App\Models\TemplateStatistic;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function track(string $sessionId, string $action, ?int $templateId = null, ?array $metadata = null): void
    {
        UsageLog::create([
            'session_id' => $sessionId,
            'template_id' => $templateId,
            'action' => $action,
            'metadata' => $metadata,
        ]);

        if ($templateId && in_array($action, ['template_selection', 'docx_export', 'pdf_export'])) {
            $this->updateTemplateStatistic($templateId, $action);
        }
    }

    public function trackVisit(string $sessionId, ?int $templateId = null): void
    {
        $this->track($sessionId, 'visit', $templateId);
    }

    public function trackTemplateSelection(string $sessionId, int $templateId): void
    {
        $this->track($sessionId, 'template_selection', $templateId);
    }

    public function trackDocxExport(string $sessionId, int $templateId): void
    {
        $this->track($sessionId, 'docx_export', $templateId);
    }

    public function trackPdfExport(string $sessionId, int $templateId): void
    {
        $this->track($sessionId, 'pdf_export', $templateId);
    }

    protected function updateTemplateStatistic(int $templateId, string $action): void
    {
        $stat = TemplateStatistic::firstOrCreate(
            ['template_id' => $templateId, 'date' => now()->toDateString()],
            ['selection_count' => 0, 'docx_export_count' => 0, 'pdf_export_count' => 0]
        );

        match ($action) {
            'template_selection' => $stat->increment('selection_count'),
            'docx_export' => $stat->increment('docx_export_count'),
            'pdf_export' => $stat->increment('pdf_export_count'),
            default => null,
        };
    }

    public function getUniqueVisitors(): int
    {
        return UsageLog::where('action', 'visit')
            ->distinct('session_id')
            ->count('session_id');
    }

    public function getTotalTemplateSelections(): int
    {
        return UsageLog::where('action', 'template_selection')->count();
    }

    public function getTotalDocxExports(): int
    {
        return UsageLog::where('action', 'docx_export')->count();
    }

    public function getTotalPdfExports(): int
    {
        return UsageLog::where('action', 'pdf_export')->count();
    }

    public function getMostUsedTemplates()
    {
        return \App\Models\Template::withCount([
            'usageLogs as selection_count' => fn($q) => $q->where('action', 'template_selection'),
            'usageLogs as docx_export_count' => fn($q) => $q->where('action', 'docx_export'),
            'usageLogs as pdf_export_count' => fn($q) => $q->where('action', 'pdf_export'),
        ])->orderBy('selection_count', 'desc')->get();
    }

    public function getDailyStats(int $days = 30)
    {
        return UsageLog::selectRaw('DATE(created_at) as date, action, count(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupByRaw('DATE(created_at), action')
            ->orderByRaw('DATE(created_at) desc')
            ->get()
            ->groupBy('date')
            ->map(fn($items, $date) => [
                'date' => $date,
                'visits' => $items->where('action', 'visit')->sum('count'),
                'template_selections' => $items->where('action', 'template_selection')->sum('count'),
                'docx_exports' => $items->where('action', 'docx_export')->sum('count'),
                'pdf_exports' => $items->where('action', 'pdf_export')->sum('count'),
            ])
            ->values();
    }
}
