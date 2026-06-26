<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use App\Models\CallStaff;
use App\Models\CallStaffGroup;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class MarkAttendance extends Page
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.mark-attendance';

    protected static ?string $navigationLabel = 'Mark Attendance';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::CalendarDays;

    // ─── Form state ──────────────────────────────────────────

    public ?int $call_staff_group_id = null;
    public string $date;
    public array $attendance = []; // [call_staff_id => 'present'|'absent'|null]

    // ─── Derived state ───────────────────────────────────────

    public bool $alreadyMarked = false;
    public array $members = [];

    public function mount(): void
    {
        $this->date = today()->toDateString();

        $this->form->fill([
            'call_staff_group_id' => null,
            'date' => $this->date,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([   // replaces ->schema([
            Select::make('call_staff_group_id')
                ->label('Group')
                ->options(CallStaffGroup::pluck('name', 'id'))
                ->searchable()
                ->required()
                ->live()                        // replaces ->reactive()
                ->afterStateUpdated(function () {
                    $this->loadMembers();
                }),

            DatePicker::make('date')
                ->label('Date')
                ->required()
                ->default(today())
                ->live()                        // replaces ->reactive()
                ->afterStateUpdated(function () {
                    $this->loadMembers();
                }),
        ])->columns(2);
    }
    // ─── Load members when group or date changes ─────────────

    public function loadMembers(): void
    {
        $this->members = [];
        $this->attendance = [];
        $this->alreadyMarked = false;

        if (! $this->call_staff_group_id || ! $this->date) {
            return;
        }

        $this->members = CallStaff::where('call_staff_group_id', $this->call_staff_group_id)
            ->orderBy('name')
            ->get()
            ->toArray();

        // Load existing attendance records for this group + date
        $existing = Attendance::whereIn(
                'call_staff_id',
                collect($this->members)->pluck('id')
            )
            ->whereDate('date', $this->date)
            ->get()
            ->keyBy('call_staff_id');

        foreach ($this->members as $member) {
            $this->attendance[$member['id']] = $existing->get($member['id'])?->status ?? null;
        }

        // Flag if any records already exist for this group + date
        $this->alreadyMarked = $existing->isNotEmpty();
    }

    public function saveWithData(array $attendance): void
    {
        if (! $this->call_staff_group_id || ! $this->date) {
            Notification::make()
                ->title('Please select a group and date.')
                ->warning()
                ->send();
            return;
        }

        $saved = 0;
        $unsetIds = [];

        foreach ($attendance as $staffId => $status) {
            if ($status === null) {
                $unsetIds[] = $staffId;
                continue;
            }

            Attendance::updateOrCreate(
                [
                    'call_staff_id' => $staffId,
                    'date'          => $this->date,
                ],
                [
                    'status' => $status,
                ]
            );

            $saved++;
        }

        if (! empty($unsetIds)) {
            Attendance::whereIn('call_staff_id', $unsetIds)
                ->whereDate('date', $this->date)
                ->delete();
        }

        Notification::make()
            ->title("Attendance saved for {$saved} member(s).")
            ->success()
            ->send();

        $this->loadMembers();
    }

}
