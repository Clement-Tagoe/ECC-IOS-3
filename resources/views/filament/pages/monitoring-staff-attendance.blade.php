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
                                $attendanceMap = $staff->monitoringStaffAttendances->keyBy(
                                    fn($a) => $a->date instanceof \Carbon\Carbon
                                        ? $a->date->toDateString()
                                        : \Carbon\Carbon::parse($a->date)->toDateString()
                                );
                                $presentCount  = $staff->monitoringStaffAttendances->where('status', 'present')->count();
                                $absentCount   = $staff->monitoringStaffAttendances->where('status', 'absent')->count();
                                $permCount     = $staff->monitoringStaffAttendances->where('status', 'absent_with_permission')->count();
                                $sickCount     = $staff->monitoringStaffAttendances->where('status', 'sick')->count();

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
                                <td class="sticky left-0 z-10 bg-white group-hover/row:bg-gray-50/80 border-r border-gray-200 px-3 py-2 transition-colors">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-800 text-sm truncate max-w-[170px]">
                                            {{ $staff->name }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Attendance cells --}}
                                @foreach ($days as $day)
                                    @php
                                        $dateStr    = $day->toDateString();
                                        $isToday    = $dateStr === $today;
                                        $isWeekend  = $day->isWeekend();
                                        $attendance = $attendanceMap[$dateStr] ?? null;
                                        $status     = $attendance?->status;
                                        $notes      = $attendance?->notes;

                                        $statusMeta = [
                                            'present'                => ['bg' => 'bg-green-100 hover:bg-green-200', 'label' => 'P',  'text' => 'text-green-700', 'full' => 'Present'],
                                            'absent'                 => ['bg' => 'bg-red-100 hover:bg-red-200',     'label' => 'A',  'text' => 'text-red-700',   'full' => 'Absent'],
                                            'absent_with_permission' => ['bg' => 'bg-amber-100 hover:bg-amber-200', 'label' => 'AP', 'text' => 'text-amber-700', 'full' => 'Absent with Permission'],
                                            'sick'                   => ['bg' => 'bg-blue-100 hover:bg-blue-200',   'label' => 'S',  'text' => 'text-blue-700',  'full' => 'Sick'],
                                        ];

                                        $emptyBg = ($isWeekend ? 'bg-gray-50' : 'hover:bg-gray-100') . ' cursor-pointer';
                                    @endphp

                                    <td class="px-0.5 py-1 text-center {{ $isToday ? 'ring-1 ring-inset ring-primary-300' : '' }}"
                                        x-data="{
                                            status: @js($status),
                                            notes: @js($notes),
                                            statusMeta: @js($statusMeta),
                                            emptyBg: @js($emptyBg),
                                            dayLabel: @js($day->format('D, M j')),
                                            init() {
                                                window.addEventListener('attendance-cell-updated', (e) => {
                                                    if (e.detail.staffId === {{ $staff->id }} && e.detail.date === '{{ $dateStr }}') {
                                                        this.status = e.detail.status;
                                                        this.notes = e.detail.notes;
                                                    }
                                                });
                                            }
                                        }">
                                        <button type="button"
                                                x-on:click="$dispatch('open-attendance-modal', { staffId: {{ $staff->id }}, date: '{{ $dateStr }}' })"
                                                :class="status ? statusMeta[status].bg : emptyBg"
                                                :title="dayLabel + (status ? ' – ' + statusMeta[status].full : ' – Not marked') + (notes ? '\n' + notes : '')"
                                                class="w-8 h-8 rounded-md flex items-center justify-center mx-auto transition-colors {{ $isWeekend ? 'opacity-50' : '' }}">
                                            <span x-show="status" :class="status ? statusMeta[status].text : ''" class="text-[10px] font-bold" x-text="status ? statusMeta[status].label : ''"></span>
                                            <span x-show="!status" class="text-[10px] text-gray-200">–</span>
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

   @livewire('edit-attendance-modal')
</x-filament-panels::page>