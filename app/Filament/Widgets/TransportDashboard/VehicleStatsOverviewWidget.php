<?php

namespace App\Filament\Widgets\TransportDashboard;

use App\Models\Vehicle;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VehicleStatsOverviewWidget extends StatsOverviewWidget
{
    public function getColumns(): int | array
    {
        return [
            'xl' => 4,
        ];
    }

    protected function getStats(): array
    {
       $vehicles = Vehicle::all();

        // ── Fleet Status ───────────────────────────────────────────
        $totalVehicles = $vehicles->count();
        $active        = $vehicles->where('status', 'active')->count();
        $inMaintenance = $vehicles->where('status', 'maintenance')->count();
        $retired       = $vehicles->where('status', 'retired')->count();

        // ── Availability ───────────────────────────────────────────
        $available   = $vehicles->where('availability', 'available')->count();
        $inUse       = $vehicles->where('availability', 'in-use')->count();
        $unavailable = $vehicles->where('availability', 'unavailable')->count();

        // ── Driver Assignment ──────────────────────────────────────
        $assigned   = $vehicles->whereNotNull('assigned_driver')->count();
        $unassigned = $vehicles->whereNull('assigned_driver')->count();

        // ── Service ────────────────────────────────────────────────
        $overdueService = $vehicles->filter(
            fn ($v) => $v->next_service_date && Carbon::parse($v->next_service_date)->isPast()
        )->count();

        $dueSoon = $vehicles->filter(function ($v) {
            if (! $v->next_service_date) return false;
            $days = (int) now()->diffInDays(Carbon::parse($v->next_service_date), false);
            return $days >= 0 && $days <= 7;
        })->count();

        $upToDate = $vehicles->filter(function ($v) {
            if (! $v->next_service_date) return false;
            $days = (int) now()->diffInDays(Carbon::parse($v->next_service_date), false);
            return $days > 7;
        })->count();

        $noServiceDate = $vehicles->filter(fn ($v) => ! $v->next_service_date)->count();

        // ── Mileage ────────────────────────────────────────────────
        $totalMileage   = $vehicles->sum('mileage');
        $avgMileage     = (int) $vehicles->whereNotNull('mileage')->avg('mileage');
        $highestMileage = $vehicles->whereNotNull('mileage')->sortByDesc('mileage')->first();
        $lowestMileage  = $vehicles->whereNotNull('mileage')->sortBy('mileage')->first();

        return [

            // ── Fleet Status ───────────────────────────────────────
            Stat::make('Total Vehicles', $totalVehicles)
                ->description('Entire fleet')
                ->descriptionIcon('heroicon-o-truck')
                ->color('gray')
                ->chart([2, 2.5, 3, 3.5, 4]),

            Stat::make('Active', $active)
                ->description('Operational vehicles')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->chart([2, 2.5, 3, 3.5, 4]),

            Stat::make('In Maintenance', $inMaintenance)
                ->description('Under repair or service')
                ->descriptionIcon('heroicon-o-wrench-screwdriver')
                ->color('warning')
                ->chart([2, 2.5, 3, 3.5, 4]),

            // Stat::make('Retired', $retired)
            //     ->description('Decommissioned vehicles')
            //     ->descriptionIcon('heroicon-o-archive-box')
            //     ->color('danger'),

            // ── Availability ───────────────────────────────────────
            Stat::make('Available', $available)
                ->description('Ready for deployment')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success')
                ->chart([2, 2.5, 3, 3.5, 4]),

            Stat::make('In Use', $inUse)
                ->description('Currently deployed')
                ->descriptionIcon('heroicon-o-arrow-path')
                ->color('info')
                ->chart([2, 2.5, 3, 3.5, 4]),

            Stat::make('Unavailable', $unavailable)
                ->description('Not available for use')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger')
                ->chart([2, 2.5, 3, 3.5, 4]),

            // ── Driver Assignment ──────────────────────────────────
            // Stat::make('Assigned', $assigned)
            //     ->description('Vehicles with a driver')
            //     ->descriptionIcon('heroicon-o-user-circle')
            //     ->color('primary'),

            // Stat::make('Unassigned', $unassigned)
            //     ->description('No driver assigned')
            //     ->descriptionIcon('heroicon-o-user')
            //     ->color($unassigned > 0 ? 'warning' : 'success'),

            // // ── Service ────────────────────────────────────────────
            Stat::make('Service Overdue', $overdueService)
                ->description('Past next service date')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color($overdueService > 0 ? 'danger' : 'success')
                ->chart([2, 2.5, 3, 3.5, 4]),

            // Stat::make('Service Due Soon', $dueSoon)
            //     ->description('Within the next 7 days')
            //     ->descriptionIcon('heroicon-o-clock')
            //     ->color($dueSoon > 0 ? 'warning' : 'success'),

            // Stat::make('Service Up To Date', $upToDate)
            //     ->description('Next service > 7 days away')
            //     ->descriptionIcon('heroicon-o-shield-check')
            //     ->color('success'),

            // Stat::make('No Service Date', $noServiceDate)
            //     ->description('Service date not recorded')
            //     ->descriptionIcon('heroicon-o-calendar')
            //     ->color($noServiceDate > 0 ? 'gray' : 'success'),

            // ── Mileage ────────────────────────────────────────────
            // Stat::make('Total Fleet Mileage', number_format($totalMileage) . ' km')
            //     ->description('Combined mileage')
            //     ->descriptionIcon('heroicon-o-map')
            //     ->color('primary'),

            Stat::make('Avg. Mileage', number_format($avgMileage) . ' km')
                ->description('Per vehicle average')
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('info')
                ->chart([2, 2.5, 3, 3.5, 4]),

            // Stat::make('Highest Mileage', $highestMileage ? number_format($highestMileage->mileage) . ' km' : 'N/A')
            //     ->description($highestMileage?->name ?? '—')
            //     ->descriptionIcon('heroicon-o-arrow-trending-up')
            //     ->color('warning'),

            // Stat::make('Lowest Mileage', $lowestMileage ? number_format($lowestMileage->mileage) . ' km' : 'N/A')
            //     ->description($lowestMileage?->name ?? '—')
            //     ->descriptionIcon('heroicon-o-arrow-trending-down')
            //     ->color('success'),
        ];
    }
}
