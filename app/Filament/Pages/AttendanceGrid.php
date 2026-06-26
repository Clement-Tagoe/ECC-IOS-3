<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use App\Models\CallStaff;
use App\Models\CallStaffGroup;
use BackedEnum;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AttendanceGrid extends Page
{
    protected string $view = 'filament.pages.attendance-grid';

    protected static ?string $navigationLabel = 'Attendance View';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::CalendarDateRange;

    public ?int $call_staff_group_id = null;
    public int $month;
    public int $year;

    // ─── Derived state ────────────────────────────────────────

    public array $members = [];
    public array $attendanceMap = []; // [call_staff_id][day] => 'present'|'absent'|null
    public int $daysInMonth = 30;

    public function mount(): void
    {
        $this->month = now()->month;
        $this->year  = now()->year;

        $this->form->fill([
            'call_staff_group_id' => null,
            'month' => $this->month,
            'year'  => $this->year,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('call_staff_group_id')
                ->label('Group')
                ->options(CallStaffGroup::pluck('name', 'id'))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(fn() => $this->loadGrid()),

            Select::make('month')
                ->label('Month')
                ->options(collect(range(1, 12))->mapWithKeys(
                    fn($m) => [$m => Carbon::create()->month($m)->format('F')]
                ))
                ->required()
                ->live()
                ->afterStateUpdated(fn() => $this->loadGrid()),

            Select::make('year')
                ->label('Year')
                ->options(collect(range(now()->year - 2, now()->year + 1))->mapWithKeys(
                    fn($y) => [$y => $y]
                ))
                ->required()
                ->live()
                ->afterStateUpdated(fn() => $this->loadGrid()),

        ])->columns(3);
    }

    // ─── Load grid data ───────────────────────────────────────

    public function loadGrid(): void
    {
        $this->members      = [];
        $this->attendanceMap = [];

        if (! $this->call_staff_group_id || ! $this->month || ! $this->year) {
            return;
        }

        $this->daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;

        $this->members = CallStaff::where('call_staff_group_id', $this->call_staff_group_id)
            ->orderBy('name')
            ->get()
            ->toArray();

        $memberIds = collect($this->members)->pluck('id');

        // Load all attendance records for this group + month in one query
        $records = Attendance::whereIn('call_staff_id', $memberIds)
            ->whereMonth('date', $this->month)
            ->whereYear('date', $this->year)
            ->get();

        // Build a map: [call_staff_id][day] => status
        foreach ($this->members as $member) {
            $this->attendanceMap[$member['id']] = array_fill(1, $this->daysInMonth, null);
        }

        foreach ($records as $record) {
            $day = Carbon::parse($record->date)->day;
            $this->attendanceMap[$record->call_staff_id][$day] = $record->status;
        }
    }

    // ─── Quick edit: toggle a single cell from the grid ──────

    public function toggleCell(int $staffId, int $day): void
    {
        $date    = Carbon::create($this->year, $this->month, $day)->toDateString();
        $current = $this->attendanceMap[$staffId][$day] ?? null;

        // Cycle: null → present → absent → null
        $next = match ($current) {
            null      => 'present',
            'present' => 'absent',
            'absent'  => null,
        };

        if ($next === null) {
            Attendance::where('call_staff_id', $staffId)
                ->whereDate('date', $date)
                ->delete();
        } else {
            Attendance::updateOrCreate(
                ['call_staff_id' => $staffId, 'date' => $date],
                ['status' => $next]
            );
        }

        $this->attendanceMap[$staffId][$day] = $next;
    }

    // ─── Summary helpers (used in blade) ─────────────────────

    public function presentCount(int $staffId): int
    {
        return collect($this->attendanceMap[$staffId] ?? [])
            ->filter(fn($s) => $s === 'present')
            ->count();
    }

    public function absentCount(int $staffId): int
    {
        return collect($this->attendanceMap[$staffId] ?? [])
            ->filter(fn($s) => $s === 'absent')
            ->count();
    }
}
