<?php

namespace App\Filament\Widgets\ForensicsDashboard;

use App\Enums\ForensicCaseReviewStatus;
use App\Models\ForensicCase;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\Auth;

class ForensicCaseReviewStatusChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Forensic Case Review Status Breakdown';

    protected int | string | array $columnSpan =  4;

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $userId = Auth::id();

        $startDate = isset($this->pageFilters['startDate'])
            ? Carbon::parse($this->pageFilters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate'])
            ? Carbon::parse($this->pageFilters['endDate'])->endOfDay()
            : now()->endOfDay();

        $counts = ForensicCase::query()
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhereHas('collaborators', fn ($q) => $q->where('users.id', $userId))
                    ->orWhereHas('receivers', fn ($q) => $q->where('users.id', $userId));
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('review_status, count(*) as aggregate')
            ->groupBy('review_status')
            ->pluck('aggregate', 'review_status');

        $statuses = collect(ForensicCaseReviewStatus::cases());

        $labels = $statuses->map(fn (ForensicCaseReviewStatus $status) => $status->name);

        $data = $statuses->map(
            fn (ForensicCaseReviewStatus $status) => $counts->get($status->value, 0)
        );

        return [
            'datasets' => [
                [
                    'label' => 'Review Status',
                    'data' => $data->values()->all(),
                    'backgroundColor' => [
                        '#f59e0b', // amber
                        '#3b82f6', // blue
                        '#10b981', // green
                        '#ef4444', // red
                        '#8b5cf6', // violet
                        '#6b7280', // gray (fallback if more statuses)
                    ],
                ],
            ],
            'labels' => $labels->values()->all(),
        ];
    }
}
