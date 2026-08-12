<?php

use Livewire\Component;
use App\Models\CallStaffAttendance as AttendanceModel;
use Filament\Notifications\Notification;
use Livewire\Attributes\Computed;
use App\Models\CallStaff;
use Livewire\Attributes\On;

new class extends Component
{
    public ?int $editingStaffId = null;
    public ?string $editingDate = null;
    public ?string $editingStatus = null;
    public ?string $editingNotes = null;

    #[On('open-call-staff-attendance-modal')]
    public function open(int $staffId, string $date): void
    {
        $this->editingStaffId = $staffId;
        $this->editingDate = $date;

        $existing = AttendanceModel::query()
            ->where('call_staff_id', $staffId)
            ->where('date', $date)
            ->first();

        $this->editingStatus = $existing?->status;
        $this->editingNotes = $existing?->notes;

        $this->dispatch('open-modal', id: 'edit-call-staff-attendance');
    }

    #[Computed]
    public function modalStaff()
    {
        return $this->editingStaffId ? CallStaff::find($this->editingStaffId) : null;
    }

    #[Computed]
    public function parsedDate(): ?\Carbon\Carbon
    {
        return $this->editingDate ? \Carbon\Carbon::parse($this->editingDate) : null;
    }

    public function saveAttendance(): void
    {
        AttendanceModel::updateOrCreate(
            ['call_staff_id' => $this->editingStaffId, 'date' => $this->editingDate],
            ['status' => $this->editingStatus, 'notes' => $this->editingNotes]
        );

        $this->dispatch('close-modal', id: 'edit-call-staff-attendance');

        $this->dispatch('call-staff-attendance-cell-updated',
            staffId: $this->editingStaffId,
            date: $this->editingDate,
            status: $this->editingStatus,
            notes: $this->editingNotes,
        );

        $this->reset(['editingStaffId', 'editingDate', 'editingStatus', 'editingNotes']);
        Notification::make()->title('Attendance saved')->success()->send();
    }

    public function clearAttendance(): void
    {
        $staffId = $this->editingStaffId;
        $date = $this->editingDate;

        AttendanceModel::where('call_staff_id', $staffId)
            ->where('date', $date)
            ->delete();

        $this->dispatch('close-modal', id: 'edit-call-staff-attendance');

        $this->dispatch('call-staff-attendance-cell-updated',
            staffId: $staffId,
            date: $date,
            status: null,
            notes: null,
        );

        $this->reset(['editingStaffId', 'editingDate', 'editingStatus', 'editingNotes']);
        Notification::make()->title('Attendance cleared')->warning()->send();
    }
};
?>

<div>
    <x-filament::modal id="edit-call-staff-attendance" width="lg">
        {{-- identical markup to your existing modal block below --}}
        <x-slot name="heading">Mark Attendance</x-slot>
        <x-slot name="description">
            {{ $this->modalStaff?->name }} &middot; {{ $this->parsedDate?->format('l, M j Y') }}
        </x-slot>

        <div class="space-y-2">
            @php
                $statusOptions = [
                    ['value' => 'present',                'label' => 'Present',               'icon' => 'heroicon-m-check-circle',   'ring' => 'ring-green-500',  'bg' => 'bg-green-50',  'text' => 'text-green-700'],
                    ['value' => 'absent',                 'label' => 'Absent',                'icon' => 'heroicon-m-x-circle',       'ring' => 'ring-red-500',    'bg' => 'bg-red-50',      'text' => 'text-red-700'],
                    ['value' => 'absent_with_permission', 'label' => 'Absent w/ Permission',  'icon' => 'heroicon-m-clock',          'ring' => 'ring-amber-400',  'bg' => 'bg-amber-50',  'text' => 'text-amber-700'],
                    ['value' => 'sick',                   'label' => 'Sick',                  'icon' => 'heroicon-m-heart',          'ring' => 'ring-blue-400',   'bg' => 'bg-blue-50',    'text' => 'text-blue-700'],
                ];
            @endphp

            @foreach ($statusOptions as $option)
                <button wire:click="$set('editingStatus', '{{ $option['value'] }}')"
                        type="button"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border-2 transition-all
                            {{ $editingStatus === $option['value']
                                ? $option['ring'] . ' ' . $option['bg']
                                : 'border-gray-200 hover:border-gray-300' }}">
                    <x-filament::icon icon="{{ $option['icon'] }}"
                                    class="w-5 h-5 {{ $editingStatus === $option['value'] ? $option['text'] : 'text-gray-400' }}"/>
                    <span class="text-sm font-medium {{ $editingStatus === $option['value'] ? $option['text'] : 'text-gray-700' }}">
                        {{ $option['label'] }}
                    </span>
                    @if ($editingStatus === $option['value'])
                        <x-filament::icon icon="heroicon-m-check" class="w-4 h-4 ml-auto {{ $option['text'] }}"/>
                    @endif
                </button>
            @endforeach

            <div class="pt-1">
                <label class="block text-xs font-medium text-gray-500 mb-1">Notes (optional)</label>
                <textarea wire:model="editingNotes"
                        rows="2"
                        placeholder="Add a note…"
                        class="w-full min-h-32 text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 resize-none placeholder:p-2"></textarea>
            </div>
        </div>

        <x-slot name="footerActions">
            <x-filament::button wire:click="saveAttendance" :disabled="!$editingStatus" color="primary">Save</x-filament::button>
            @if ($editingStatus)
                <x-filament::button wire:click="clearAttendance" color="danger" outlined>Clear</x-filament::button>
            @endif
            <x-filament::button x-on:click="close" color="gray" outlined>Cancel</x-filament::button>
        </x-slot>
    </x-filament::modal>
</div>