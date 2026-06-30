<?php

namespace App\Filament\Pages;

use App\Models\CallStaff;
use App\Models\CallStaffAttendance as AttendanceModel;
use App\Models\CallStaffGroup;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

class CallStaffAttendance extends Page
{
    protected string $view = 'filament.pages.call-staff-attendance';

     // URL-persisted filters
    #[Url]
    public string $selectedMonth;
 
    #[Url]
    public ?int $selectedGroup = null;

 
    public string $search = '';
 
    // Modal state
    public bool $showModal = false;
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
    // ─── Computed Data ────────────────────────────────────────────────────────
 
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
 
        $query = CallStaff::query()
            ->with([
                'group',
                'callStaffAttendances' => fn ($q) => $q->whereBetween('date', [$monthStart, $monthEnd]),
            ])
            ->orderBy('call_staff_group_id');
        
        if ($this->selectedGroup) {
            $query->where('call_staff_group_id', $this->selectedGroup);
        }
 
        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        return $query->get()->groupBy('call_staff_group_id');
    }
 
    #[Computed]
    public function groups(): Collection
    {
        return CallStaffGroup::orderBy('name')->get();
    }
 
    #[Computed]
    public function monthOptions(): array
    {
        $options = [];
        $start = Carbon::now()->subMonths(11);
        for ($i = 0; $i < 13; $i++) {
            $month = $start->copy()->addMonths($i);
            $options[$month->format('Y-m')] = $month->format('F Y');
        }

        return $options;
    }
 
    // #[Computed]
    // public function stats(): array
    // {
    //     $monthStart = Carbon::createFromFormat('Y-m', $this->selectedMonth)->startOfMonth()->toDateString();
    //     $monthEnd   = Carbon::createFromFormat('Y-m', $this->selectedMonth)->endOfMonth()->toDateString();
 
    //     $staffIds = $this->selectedGroup
    //         ? CallStaff::where('call_staff_group_id', $this->selectedGroup)->pluck('id')
    //         : CallStaff::all()->pluck('id');
        
    //     $attendances = AttendanceModel::whereIn('call_staff_id', $staffIds)
    //         ->whereBetween('date', [$monthStart, $monthEnd])
    //         ->get();
       
    //     return [
    //         'total'       => $attendances->count(),
    //         'present'     => $attendances->where('status', 'present')->count(),
    //         'absent'      => $attendances->where('status', 'absent')->count(),
    //         'permission'  => $attendances->where('status', 'absent_with_permission')->count(),
    //         'sick'        => $attendances->where('status', 'sick')->count(),
    //     ];
    // }
 
    // ─── Sort ─────────────────────────────────────────────────────────────────
 
    // public function sort(string $field): void
    // {
    //     if ($this->sortField === $field) {
    //         $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    //     } else {
    //         $this->sortField = $field;
    //         $this->sortDirection = 'asc';
    //     }
    // }
 
    // ─── Attendance Cell Click ────────────────────────────────────────────────
 
    public function openAttendanceModal(int $staffId, string $date): void
    {
        $this->editingStaffId = $staffId;
        $this->editingDate    = $date;
 
        $existing = AttendanceModel::where('call_staff_id', $staffId)
            ->where('date', $date)
            ->first();
 
        $this->editingStatus = $existing?->status;
        $this->editingNotes  = $existing?->notes;
        $this->showModal     = true;
    }
 
    public function saveAttendance(): void
    {
        AttendanceModel::updateOrCreate(
            [
                'call_staff_id' => $this->editingStaffId,
                'date'          => $this->editingDate,
            ],
            [
                'status' => $this->editingStatus,
                'notes'  => $this->editingNotes,
            ]
        );
 
        $this->showModal = false;
        $this->reset(['editingStaffId', 'editingDate', 'editingStatus', 'editingNotes']);
 
        Notification::make()
            ->title('Attendance saved')
            ->success()
            ->send();
    }
 
    public function clearAttendance(): void
    {
        AttendanceModel::where('call_staff_id', $this->editingStaffId)
            ->where('date', $this->editingDate)
            ->delete();
 
        $this->showModal = false;
        $this->reset(['editingStaffId', 'editingDate', 'editingStatus', 'editingNotes']);
 
        Notification::make()
            ->title('Attendance cleared')
            ->warning()
            ->send();
    }
 
    // ─── Quick-set all staff for a day ───────────────────────────────────────
 
    // public function markAllPresent(string $date): void
    // {
    //     $staffIds = $this->selectedGroup
    //         ? CallStaff::where('call_staff_group_id', $this->selectedGroup)->pluck('id')
    //         : CallStaff::all()->pluck('id');
 
    //     foreach ($staffIds as $id) {
    //         AttendanceModel::updateOrCreate(
    //             ['call_staff_id' => $id, 'date' => $date],
    //             ['status' => 'present']
    //         );
    //     }
 
    //     Notification::make()->title('All marked present for ' . Carbon::parse($date)->format('M j'))->success()->send();
    // }
 
    protected function getHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action('exportCsv'),
        ];
    }
 
    public function exportCsv(): void
    {
        // Trigger a download — wire:click calls this, browser handles via response
        $this->dispatch('export-csv', month: $this->selectedMonth, group: $this->selectedGroup);
    }
}
