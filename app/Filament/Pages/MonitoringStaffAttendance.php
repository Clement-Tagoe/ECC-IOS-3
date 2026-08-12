<?php

namespace App\Filament\Pages;

use App\Models\MonitoringStaff;
use App\Models\MonitoringStaffGroup;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use UnitEnum;

class MonitoringStaffAttendance extends Page
{
    protected string $view = 'filament.pages.monitoring-staff-attendance';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::CalendarDateRange;

    protected static string | UnitEnum | null $navigationGroup = 'Monitoring';

    protected static ?int $navigationSort = 6;


     // URL-persisted filters
    #[Url]
    public string $selectedMonth;
 
    #[Url]
    public ?int $selectedGroup = null;

 
    public string $search = '';
 
    
 
    public function mount(): void
    {
        $this->selectedMonth = Carbon::now()->format('Y-m');
    }

    public static function canAccess(): bool
    {
        return Gate::allows('View:MonitoringStaffAttendance');
    }
    
    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }

     // ─── Month Navigation ───────────────────────────────────────────────────────
 
    public function previousMonth(): void
    {
        $this->selectedMonth = Carbon::createFromFormat('Y-m', $this->selectedMonth)
            ->subMonth()
            ->format('Y-m');
    }
 
    public function nextMonth(): void
    {
        $this->selectedMonth = Carbon::createFromFormat('Y-m', $this->selectedMonth)
            ->addMonth()
            ->format('Y-m');
    }
 
    public function goToCurrentMonth(): void
    {
        $this->selectedMonth = Carbon::now()->format('Y-m');
    }
 
    /**
     * Guard against an invalid or empty value coming from the native
     * <input type="month"> (e.g. if cleared by the user) so the rest
     * of the page doesn't crash trying to parse it.
     */
    public function updatedSelectedMonth(string $value): void
    {
        if (! preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $value)) {
            $this->selectedMonth = Carbon::now()->format('Y-m');
        }
    }
    // // ─── Computed Data ────────────────────────────────────────────────────────
 
    #[Computed]
    public function daysInMonth(): array
    {
        $start = Carbon::createFromFormat('Y-m', $this->selectedMonth)->startOfMonth();
        $days = [];
        for ($d = $start->copy(); $d->lte($start->copy()->endOfMonth()); $d->addDay()) {
            $days[] = $d->copy();
        }
        return $days;
    }

    #[Computed]
    public function groupedStaff(): Collection
    {
        $monthStart = Carbon::createFromFormat('Y-m', $this->selectedMonth)->startOfMonth()->toDateString();
        $monthEnd   = Carbon::createFromFormat('Y-m', $this->selectedMonth)->endOfMonth()->toDateString();
 
        $query = MonitoringStaff::query()
                    ->select('id', 'name', 'monitoring_staff_group_id', 'deleted_at') // only columns the view actually uses
                    ->with([
                        'group:id,name',
                        'monitoringStaffAttendances' => fn ($q) => $q
                            ->select('id', 'monitoring_staff_id', 'date', 'status', 'notes')
                            ->whereBetween('date', [$monthStart, $monthEnd]),
                    ])
                    ->orderBy('monitoring_staff_group_id');
        
        if ($this->selectedGroup) {
            $query->where('monitoring_staff_group_id', $this->selectedGroup);
        }
 
        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        return $query->get()->groupBy('monitoring_staff_group_id');
    }
 
    #[Computed]
    public function groups(): Collection
    {
        return MonitoringStaffGroup::orderBy('name')->get();
    }

}
