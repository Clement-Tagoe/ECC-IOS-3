<x-filament-panels::page>

    {{ $this->form }}

    @if (count($members) > 0)

        {{-- Legend --}}
        <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
            <span class="flex items-center gap-1">
                <span class="inline-block w-4 h-4 rounded bg-success-500"></span> Present
            </span>
            <span class="flex items-center gap-1">
                <span class="inline-block w-4 h-4 rounded bg-danger-500"></span> Absent
            </span>
            <span class="flex items-center gap-1">
                <span class="inline-block w-4 h-4 rounded bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600"></span> Unmarked
            </span>
            <span class="ml-4 italic">Click any cell to cycle: unmarked → present → absent → unmarked</span>
        </div>

        {{-- Scrollable grid --}}
        <div class="mt-2 overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
            <table class="text-xs border-collapse" style="min-width: max-content;">
                <thead>
                    {{-- Day number headers --}}
                    <tr class="bg-gray-50 dark:bg-gray-800">
                        <th class="sticky left-0 z-10 bg-gray-50 dark:bg-gray-800 text-left px-4 py-3 font-medium text-gray-600 dark:text-gray-300 border-b border-r border-gray-200 dark:border-gray-700 min-w-[160px]">
                            Member
                        </th>
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $date    = \Illuminate\Support\Carbon::create($year, $month, $day);
                                $isToday = $date->isToday();
                                $isWeekend = $date->isWeekend();
                            @endphp
                            <th class="px-2 py-3 font-medium text-center border-b border-gray-200 dark:border-gray-700 w-10
                                {{ $isToday ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' : '' }}
                                {{ $isWeekend && !$isToday ? 'text-gray-400 dark:text-gray-500' : 'text-gray-600 dark:text-gray-300' }}
                            ">
                                <div>{{ $day }}</div>
                                <div class="font-normal text-gray-400 dark:text-gray-500" style="font-size: 0.6rem;">
                                    {{ $date->format('D') }}
                                </div>
                            </th>
                        @endfor

                        {{-- Summary columns --}}
                        <th class="px-3 py-3 font-medium text-center border-b border-l border-gray-200 dark:border-gray-700 text-success-600 dark:text-success-400 w-16">
                            ✓
                        </th>
                        <th class="px-3 py-3 font-medium text-center border-b border-gray-200 dark:border-gray-700 text-danger-600 dark:text-danger-400 w-16">
                            ✗
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach ($members as $member)
                        <tr class="group bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/50">

                            {{-- Sticky member name --}}
                            <td class="sticky left-0 z-10 bg-white dark:bg-gray-900 group-hover:bg-gray-50 dark:group-hover:bg-gray-800/50 px-4 py-2 font-medium text-gray-800 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700 whitespace-nowrap">
                                {{ $member['name'] }}
                            </td>

                            {{-- Day cells --}}
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php $status = $attendanceMap[$member['id']][$day] ?? null; @endphp
                                <td class="p-1 text-center border-gray-100 dark:border-gray-800">
                                    <button
                                        type="button"
                                        wire:click="toggleCell({{ $member['id'] }}, {{ $day }})"
                                        title="{{ $status ?? 'unmarked' }}"
                                        class="w-7 h-7 rounded transition-all duration-150 flex items-center justify-center mx-auto
                                            {{ $status === 'present' ? 'bg-success-500 text-white' : '' }}
                                            {{ $status === 'absent'  ? 'bg-danger-500 text-white' : '' }}
                                            {{ $status === null      ? 'bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600' : '' }}
                                        "
                                    >
                                        @if ($status === 'present')
                                            <x-heroicon-o-check class="w-3.5 h-3.5" />
                                        @elseif ($status === 'absent')
                                            <x-heroicon-o-x-mark class="w-3.5 h-3.5" />
                                        @endif
                                    </button>
                                </td>
                            @endfor

                            {{-- Summary totals --}}
                            <td class="px-3 py-2 text-center font-semibold text-success-600 dark:text-success-400 border-l border-gray-200 dark:border-gray-700">
                                {{ $this->presentCount($member['id']) }}
                            </td>
                            <td class="px-3 py-2 text-center font-semibold text-danger-600 dark:text-danger-400">
                                {{ $this->absentCount($member['id']) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @elseif ($call_staff_group_id)
        <div class="text-center py-12 text-gray-400">
            No members found in this group.
        </div>
    @else
        <div class="text-center py-12 text-gray-400">
            Select a group, month, and year to view the attendance grid.
        </div>
    @endif

</x-filament-panels::page>
