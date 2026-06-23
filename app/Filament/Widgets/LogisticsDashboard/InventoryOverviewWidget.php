<?php

namespace App\Filament\Widgets\LogisticsDashboard;

use App\Models\LogisticsDistribution;
use App\Models\LogisticsManagement;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InventoryOverviewWidget extends StatsOverviewWidget
{
    public function getColumns(): int | array
    {
        return [
            'xl' => 4,
        ];
    }

    protected function getStats(): array
    {
    
        $startDate = isset($this->pageFilters['startDate']) 
                    ? Carbon::parse($this->pageFilters['startDate'])->startOfDay() 
                    : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate']) 
                        ? Carbon::parse($this->pageFilters['endDate'])->endOfDay() 
                        : now()->endOfDay();


        $dateRangeLabel = $startDate->format('M d') . ' — ' . $endDate->format('M d, Y');

        $items = LogisticsManagement::with('logisticsDistribution')->get();

        $totalItems    = $items->count();
        $totalQuantity = $items->sum('quantity');

        $totalDistributed = LogisticsDistribution::whereBetween('date', [$startDate, $endDate])
            ->sum('quantity');

        $totalRemaining = $items->sum(
            fn ($item) => max(0, $item->quantity - $item->logisticsDistribution->sum('quantity'))
        );

        $distributedToday = LogisticsDistribution::whereDate('date', today())
            ->sum('quantity');

        $distributedThisWeek = LogisticsDistribution::whereBetween('date', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->sum('quantity');

        $distributedThisMonth = LogisticsDistribution::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('quantity');

        $lowStockItems = $items->filter(function ($item) {
            if ($item->quantity <= 0) return false;
            $distributed = $item->logisticsDistribution->sum('quantity');
            $remaining   = max(0, $item->quantity - $distributed);
            return ($remaining / $item->quantity) <= 0.2;
        });

        $lowStockCount = $lowStockItems->count();

        return [
            Stat::make('Total Items', $totalItems)
                ->description('Distinct items in inventory')
                ->descriptionIcon('heroicon-o-archive-box')
                ->color('primary'),

            Stat::make('Total Stock Quantity', $totalQuantity)
                ->description('Sum of all item quantities')
                ->descriptionIcon('heroicon-o-cube')
                ->color('info'),

            Stat::make('Total Distributed', $totalDistributed)
                ->description($dateRangeLabel)
                ->descriptionIcon('heroicon-o-truck')
                ->color('success'),

            Stat::make('Remaining Stock', $totalRemaining)
                ->description('Total quantity still available')
                ->descriptionIcon('heroicon-o-inbox-stack')
                ->color($totalRemaining > 0 ? 'success' : 'danger'),

            Stat::make('Distributed Today', $distributedToday)
                ->description(today()->format('F j, Y'))
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('warning'),

            Stat::make('Distributed This Week', $distributedThisWeek)
                ->description(now()->startOfWeek()->format('M d') . ' — ' . now()->endOfWeek()->format('M d'))
                ->descriptionIcon('heroicon-o-calendar')
                ->color('warning'),

            Stat::make('Distributed This Month', $distributedThisMonth)
                ->description(now()->format('F Y'))
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('warning'),

            Stat::make('Low Stock Items', $lowStockCount)
                ->description('Items at or below 20% remaining')
                ->descriptionIcon($lowStockCount > 0 ? 'heroicon-o-exclamation-triangle' : 'heroicon-o-check-circle')
                ->color($lowStockCount > 0 ? 'danger' : 'success'),
        ];
    }
}
