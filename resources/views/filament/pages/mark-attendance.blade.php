<x-filament-panels::page>

    {{ $this->form }}

    @if (count($members) > 0)

        @if ($alreadyMarked)
            <div class="rounded-lg bg-info-50 border border-info-200 text-info-700 px-4 py-3 text-sm flex items-center gap-2 dark:bg-info-900/20 dark:border-info-700 dark:text-info-400">
                <x-heroicon-o-information-circle class="w-4 h-4 shrink-0" />
                Attendance has already been marked for this group on this date. You can update it below.
            </div>
        @endif

        {{-- Alpine owns all toggle state --}}
        <div
            x-data="{
                attendance: {{ json_encode($attendance) }},
                toggle(staffId, status) {
                    if (this.attendance[staffId] === status) {
                        this.attendance[staffId] = null;
                    } else {
                        this.attendance[staffId] = status;
                    }
                },
                save() {
                    $wire.saveWithData(this.attendance);
                }
            }"
        >
            <div class="mt-4 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="text-left px-4 py-3 font-medium text-gray-600 dark:text-gray-300">
                                Member
                            </th>
                            <th class="text-center px-4 py-3 font-medium text-gray-600 dark:text-gray-300 w-28">
                                Present
                            </th>
                            <th class="text-center px-4 py-3 font-medium text-gray-600 dark:text-gray-300 w-28">
                                Absent
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($members as $member)
                            <tr class="bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                <td class="px-4 py-3 text-gray-800 dark:text-gray-200 font-medium">
                                    {{ $member['name'] }}
                                </td>

                                {{-- Present button --}}
                                <td class="text-center px-4 py-3">
                                    <button
                                        type="button"
                                        @click="toggle({{ $member['id'] }}, 'present')"
                                        :class="attendance[{{ $member['id'] }}] === 'present'
                                            ? 'bg-success-500 text-white shadow'
                                            : 'bg-gray-100 text-gray-400 hover:bg-success-100 hover:text-success-600 dark:bg-gray-700 dark:hover:bg-success-900/30'"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-full transition"
                                    >
                                        <x-heroicon-o-check class="w-5 h-5" />
                                    </button>
                                </td>

                                {{-- Absent button --}}
                                <td class="text-center px-4 py-3">
                                    <button
                                        type="button"
                                        @click="toggle({{ $member['id'] }}, 'absent')"
                                        :class="attendance[{{ $member['id'] }}] === 'absent'
                                            ? 'bg-danger-500 text-white shadow'
                                            : 'bg-gray-100 text-gray-400 hover:bg-danger-100 hover:text-danger-600 dark:bg-gray-700 dark:hover:bg-danger-900/30'"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-full transition"
                                    >
                                        <x-heroicon-o-x-mark class="w-5 h-5" />
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-end">
                <x-filament::button @click="save()" size="lg" color="primary">
                    Save Attendance
                </x-filament::button>
            </div>
        </div>

    @elseif ($call_staff_group_id)
        <div class="text-center py-12 text-gray-400">
            No members found in this group.
        </div>
    @else
        <div class="text-center py-12 text-gray-400">
            Select a group and date to begin marking attendance.
        </div>
    @endif

</x-filament-panels::page>