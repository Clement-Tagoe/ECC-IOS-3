<x-filament-panels::page>
    <div class="flex flex-wrap items-center gap-3 mb-4 px-8 py-8 rounded-xl border border-gray-200 shadow-sm bg-white">

        {{-- Month picker --}}
        <div class="flex items-center gap-2">
            <x-filament::icon icon="heroicon-m-calendar-days" class="w-6 h-6 text-gray-400"/>

            <button type="button"
                    wire:click="previousMonth"
                    title="Previous month"
                    class="p-1 rounded-md text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                <x-filament::icon icon="heroicon-m-chevron-left" class="w-6 h-6"/>
            </button>

            <input type="month"
                wire:model.live="selectedMonth"
                class="text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 py-1.5 px-2"/>

            <button type="button"
                    wire:click="nextMonth"
                    title="Next month"
                    class="p-1 rounded-md text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                <x-filament::icon icon="heroicon-m-chevron-right" class="w-6 h-6"/>
            </button>

            <button type="button"
                    wire:click="goToCurrentMonth"
                    title="Jump to current month"
                    class="text-xs font-medium text-primary-600 hover:underline ml-0.5">
                Today
            </button>
        </div>

        {{-- Group filter --}}
        <div class="flex items-center gap-2 px-4">
            <x-filament::icon icon="heroicon-m-user-group" class="w-4 h-4 text-gray-400"/>
            <select wire:model.live="selectedGroup"
                    class="text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 py-1.5 pl-2 pr-8">
                <option value="">All Groups</option>
                @foreach ($this->groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Search --}}
        <div class="flex items-center gap-2 ml-auto">
            <x-filament::icon icon="heroicon-m-magnifying-glass" class="w-10 h-4 text-gray-400"/>
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="Search staff…"
                   class="text-sm rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 py-1.5 pl-3 pr-4 w-66"/>
        </div>

        {{-- Legend --}}
        <div class="hidden lg:flex items-center gap-3 text-xs text-gray-500 border-l border-gray-200 pl-3 ml-1">
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span> Present</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span> Absent</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-amber-400 inline-block"></span> Permission</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-400 inline-block"></span> Sick</span>
        </div>
    </div>

    {{-- ─── Attendance Grid ─────────────────────────────────────────────────── --}}
    @php
        $days = $this->daysInMonth;
        $today = \Carbon\Carbon::today()->toDateString();
    @endphp

    <div class="rounded-xl border border-gray-200 shadow-sm bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">

                {{-- Header row: Name col + one col per day --}}
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">

                        {{-- Sticky name column --}}
                        <th class="sticky left-0 z-20 bg-gray-50 border-r border-gray-200 px-3 py-2 text-left min-w-[200px]">
                            <span class="flex items-center gap-1 text-xs font-semibold text-gray-600 uppercase tracking-wider hover:text-primary-600 transition-colors">
                                Staff Name
                            </span>
                        </th>

                        {{-- Day columns --}}
                        @foreach ($days as $day)
                           
                            @php
                                $dateStr  = $day->toDateString();
                                $isToday  = $dateStr === $today;
                                $isWeekend = $day->isWeekend();
                            @endphp
                            <th class="px-0.5 py-2 text-center min-w-[36px] max-w-[42px]
                                       {{ $isToday ? 'bg-primary-50' : '' }}
                                       {{ $isWeekend && !$isToday ? 'bg-gray-100' : '' }}">
                                <div class="flex flex-col items-center leading-tight">
                                    <span class="text-[10px] font-medium {{ $isToday ? 'text-primary-600' : 'text-gray-400' }}">
                                        {{ $day->format('D')[0] }}
                                    </span>
                                    <span class="text-xs font-bold {{ $isToday ? 'text-primary-700' : ($isWeekend ? 'text-gray-400' : 'text-gray-600') }}">
                                        {{ $day->format('j') }}
                                    </span>
                                </div>
                            </th>
                        @endforeach

                        {{-- Summary col --}}
                        <th class="sticky right-0 z-20 bg-gray-50 border-l border-gray-200 px-2 py-2 text-center min-w-[90px]">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Summary</span>
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($this->groupedStaff as $groupId => $staffMembers)
                        
                        @php $group = $staffMembers->first()->group; @endphp

                        {{-- Group header row --}}
                        <tr class="bg-gray-50">
                            <td colspan="{{ count($days) + 2 }}"
                                class="sticky left-0 px-3 py-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0"
                                          style="background-color: {{ $group->color ?? '#6366f1' }}"></span>
                                    <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">
                                        {{ $group->name }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        ({{ $staffMembers->count() }} staff)
                                    </span>
                                </div>
                            </td>
                        </tr>

                        {{-- Staff rows --}}
                        @foreach ($staffMembers as $staff)
                            
                            @php
                                $attendanceMap = $staff->callStaffAttendances->keyBy(
                                    fn($a) => $a->date instanceof \Carbon\Carbon
                                        ? $a->date->toDateString()
                                        : \Carbon\Carbon::parse($a->date)->toDateString()
                                );
                                $presentCount  = $staff->callStaffAttendances->where('status', 'present')->count();
                                $absentCount   = $staff->callStaffAttendances->where('status', 'absent')->count();
                                $permCount     = $staff->callStaffAttendances->where('status', 'absent_with_permission')->count();
                                $sickCount     = $staff->callStaffAttendances->where('status', 'sick')->count();

                                $totalMarked = $presentCount + $absentCount + $permCount + $sickCount;
                                $attendanceRate = $totalMarked > 0
                                    ? round(($presentCount / $totalMarked) * 100)
                                    : null;

                                $rateColor = match(true) {
                                    $attendanceRate === null => 'text-gray-300',
                                    $attendanceRate >= 90    => 'text-green-600',
                                    $attendanceRate >= 75    => 'text-amber-600',
                                    default                  => 'text-red-600',
                                };
                            @endphp

                            <tr class="hover:bg-gray-50/80 group/row transition-colors">

                                {{-- Sticky name cell --}}
                                <td class="sticky left-0 z-10 bg-white group-hover/row:bg-gray-50/80
                                           border-r border-gray-200 px-3 py-2 transition-colors">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-800 text-sm truncate max-w-[170px]">
                                            {{ $staff->name }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Attendance cells --}}
                                @foreach ($days as $day)
                                    @php
                                        $dateStr   = $day->toDateString();
                                        $isToday   = $dateStr === $today;
                                        $isWeekend = $day->isWeekend();
                                        $attendance = $attendanceMap[$dateStr] ?? null;
                                        $status     = $attendance?->status;

                                        $cellBg = match($status) {
                                            'present'                => 'bg-green-100 hover:bg-green-200',
                                            'absent'                 => 'bg-red-100 hover:bg-red-200',
                                            'absent_with_permission' => 'bg-amber-100 hover:bg-amber-200',
                                            'sick'                   => 'bg-blue-100 hover:bg-blue-200',
                                            default                  => ($isWeekend ? 'bg-gray-50' : 'hover:bg-gray-100') . ' cursor-pointer',
                                        };

                                        $dotColor = match($status) {
                                            'present'                => 'bg-green-500',
                                            'absent'                 => 'bg-red-500',
                                            'absent_with_permission' => 'bg-amber-400',
                                            'sick'                   => 'bg-blue-400',
                                            default                  => '',
                                        };

                                        $shortLabel = match($status) {
                                            'present'                => 'P',
                                            'absent'                 => 'A',
                                            'absent_with_permission' => 'AP',
                                            'sick'                   => 'S',
                                            default                  => '',
                                        };

                                        $labelColor = match($status) {
                                            'present'                => 'text-green-700',
                                            'absent'                 => 'text-red-700',
                                            'absent_with_permission' => 'text-amber-700',
                                            'sick'                   => 'text-blue-700',
                                            default                  => 'text-gray-300',
                                        };
                                    @endphp

                                    <td class="px-0.5 py-1 text-center {{ $isToday ? 'ring-1 ring-inset ring-primary-300' : '' }}">
                                        <button wire:click="openStaffAttendanceModal({{ $staff->id }}, '{{ $dateStr }}')"
                                                title="{{ $day->format('D, M j') }}{{ $status ? ' – ' . \App\Models\CallStaffAttendance::statusOptions()[$status] : ' – Not marked' }}{{ $attendance?->notes ? "\n" . $attendance->notes : '' }}"
                                                @if($isWeekend) class="w-8 h-8 rounded-md flex items-center justify-center mx-auto {{ $cellBg }} transition-colors opacity-50"
                                                @else class="w-8 h-8 rounded-md flex items-center justify-center mx-auto {{ $cellBg }} transition-colors"
                                                @endif>
                                            @if ($status)
                                                <span class="text-[10px] font-bold {{ $labelColor }}">{{ $shortLabel }}</span>
                                            @else
                                                <span class="text-[10px] text-gray-200">–</span>
                                            @endif
                                        </button>
                                    </td>
                                @endforeach

                                {{-- Summary cell --}}
                                <td class="sticky right-0 z-10 bg-white group-hover/row:bg-gray-50/80 
                                        border-l border-gray-200 px-2 py-2 transition-colors min-w-[90px]">
                                    <div class="flex items-center justify-center gap-1 text-[10px] font-medium whitespace-nowrap">
                                        @if ($presentCount) <span class="text-green-600">{{ $presentCount }}P</span> @endif
                                        @if ($absentCount)  <span class="text-red-600">{{ $absentCount }}A</span> @endif
                                        @if ($permCount)    <span class="text-amber-600">{{ $permCount }}AP</span> @endif
                                        @if ($sickCount)    <span class="text-blue-600">{{ $sickCount }}S</span> @endif
                                        @if (!$presentCount && !$absentCount && !$permCount && !$sickCount)
                                            <span class="text-gray-300">–</span>
                                        @endif

                                        @if ($attendanceRate !== null)
                                            <span class="ml-1 pl-1 border-l border-gray-200 font-bold {{ $rateColor }}">
                                                {{ $attendanceRate }}%
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    @empty
                        <tr>
                            <td colspan="{{ count($days) + 2 }}" class="px-6 py-12 text-center text-gray-400">
                                <x-filament::icon icon="heroicon-o-user-group" class="w-10 h-10 mx-auto mb-2 opacity-40"/>
                                <p>No staff found for the selected filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <x-filament::modal id="edit-call-staff-attendance" width="lg">
        <x-slot name="heading">
            Mark Attendance
        </x-slot>

        <x-slot name="description">
            {{ $this->modalStaff?->name }} &middot; {{ $this->parsedDate?->format('l, M j Y') }}
        </x-slot>

        {{-- Status options --}}
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
                        class="w-full min-h-32 text-sm rounded-lg  border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 resize-none placeholder:p-2"></textarea>
            </div>
        </div>

        <x-slot name="footerActions">
            <x-filament::button wire:click="saveAttendance" :disabled="!$editingStatus" color="primary">
                Save
            </x-filament::button>

            @if ($editingStatus)
                <x-filament::button wire:click="clearAttendance" color="danger" outlined>
                    Clear
                </x-filament::button>
            @endif

            <x-filament::button x-on:click="close" color="gray" outlined>
                Cancel
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</x-filament-panels::page>