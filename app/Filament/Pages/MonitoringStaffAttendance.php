<?php

namespace App\Filament\Pages;

use App\Models\MonitoringStaff;
use App\Models\MonitoringStaffAttendance as AttendanceModel;
use App\Models\MonitoringStaffGroup;
use BackedEnum;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
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
 
    // Modal state
    public ?int $editingStaffId = null;
    public ?string $editingDate = null;
    public ?string $editingStatus = null;
    public ?string $editingNotes = null;
 
    public function mount(): void
    {
        $this->selectedMonth = Carbon::now()->format('Y-m');
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
            ->with([
                'group',
                'monitoringStaffAttendances' => fn ($q) => $q->whereBetween('date', [$monthStart, $monthEnd]),
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

    // ─── Attendance Cell Click ────────────────────────────────────────────────

    public function openStaffAttendanceModal(int $staffId, string $date): void
    {
        $this->editingStaffId = $staffId;
        $this->editingDate    = $date;

        $existing = AttendanceModel::query()
            ->where('monitoring_staff_id', $staffId)
            ->where('date', $date)
            ->first();

        $this->editingStatus = $existing?->status;
        $this->editingNotes = $existing?->notes;

        $this->dispatch('open-modal', id: 'edit-monitoring-staff-attendance');
    }

    #[Computed]
    public function modalStaff()
    {
        return $this->editingStaffId ? MonitoringStaff::find($this->editingStaffId) : null;
    }

    #[Computed]
    public function parsedDate(): ?\Carbon\Carbon
    {
        return $this->editingDate ? \Carbon\Carbon::parse($this->editingDate) : null;
    }
 
    public function saveAttendance(): void
    {
        AttendanceModel::updateOrCreate(
            [
                'monitoring_staff_id' => $this->editingStaffId,
                'date'          => $this->editingDate,
            ],
            [
                'status' => $this->editingStatus,
                'notes'  => $this->editingNotes,
            ]
        );

        $this->dispatch('close-modal', id: 'edit-monitoring-staff-attendance');
        $this->reset(['editingStaffId', 'editingDate', 'editingStatus', 'editingNotes']);
 
        Notification::make()
            ->title('Attendance saved')
            ->success()
            ->send();

        
    }
 
    public function clearAttendance(): void
    {
        AttendanceModel::where('monitoring_staff_id', $this->editingStaffId)
            ->where('date', $this->editingDate)
            ->delete();
 
        $this->dispatch('close-modal', id: 'edit-monitoring-staff-attendance');
        $this->reset(['editingStaffId', 'editingDate', 'editingStatus', 'editingNotes']);
 
        Notification::make()
            ->title('Attendance cleared')
            ->warning()
            ->send();
    }
}
