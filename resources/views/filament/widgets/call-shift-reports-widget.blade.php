<x-filament-widgets::widget>
    <x-filament::section>

        <x-slot name="heading">Call Shift Reports</x-slot>
        <x-slot name="description">{{ today()->format('l, F j Y') }}</x-slot>

        @php
            $shiftMeta = [
                'am' => [
                    'label'      => 'AM Shift',
                    'icon'       => 'heroicon-o-sun',
                    'color'      => 'text-sky-500',
                    'bg'         => 'bg-sky-50 dark:bg-sky-900/20',
                    'border'     => 'border-sky-200 dark:border-sky-800',
                ],
                'pm' => [
                    'label'      => 'PM Shift',
                    'icon'       => 'heroicon-o-moon',
                    'color'      => 'text-violet-500',
                    'bg'         => 'bg-violet-50 dark:bg-violet-900/20',
                    'border'     => 'border-violet-200 dark:border-violet-800',
                ],
            ];

            $statusConfig = [
                'active' => [
                    'dot'  => 'bg-emerald-500',
                    'text' => 'text-emerald-600 dark:text-emerald-400',
                    'bg'   => 'bg-emerald-100 dark:bg-emerald-900/40',
                ],
                'draft' => [
                    'dot'  => 'bg-zinc-400',
                    'text' => 'text-zinc-500 dark:text-zinc-400',
                    'bg'   => 'bg-zinc-100 dark:bg-zinc-800',
                ],
                'closed' => [
                    'dot'  => 'bg-red-400',
                    'text' => 'text-red-600 dark:text-red-400',
                    'bg'   => 'bg-red-100 dark:bg-red-900/40',
                ],
            ];

            $metrics = [
                [
                    'key'         => 'expected_attendance',
                    'label'       => 'Expected',
                    'icon'        => 'heroicon-o-users',
                ],
                [
                    'key'         => 'present',
                    'label'       => 'Present',
                    'icon'        => 'heroicon-o-check-circle',
                    'value_color' => 'text-emerald-600 dark:text-emerald-400',
                ],
                [
                    'key'         => 'absent',
                    'label'       => 'Absent',
                    'icon'        => 'heroicon-o-x-circle',
                    'value_color' => 'text-red-600 dark:text-red-400',
                ],
                [
                    'key'         => 'absent_with_permission',
                    'label'       => 'With Permission',
                    'icon'        => 'heroicon-o-clock',
                    'value_color' => 'text-yellow-600 dark:text-yellow-400',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($shifts as $key => $shift)
                @php
                    $meta   = $shiftMeta[$key];
                    $exists = $shift['exists'];
                @endphp

                <div class="rounded-xl border {{ $meta['border'] }} {{ $meta['bg'] }} p-4 flex flex-col gap-4">

                    {{-- Shift header --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="rounded-lg bg-white dark:bg-gray-800 p-2 shadow-sm">
                                <x-dynamic-component :component="$meta['icon']" class="h-5 w-5 {{ $meta['color'] }}" />
                            </div>
                            <span class="text-sm font-semibold text-gray-800 dark:text-white">
                                {{ $meta['label'] }}
                            </span>
                        </div>

                        @if ($exists)
                            @php $sc = $statusConfig[$shift['status']] ?? $statusConfig['draft']; @endphp
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $sc['bg'] }} {{ $sc['text'] }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $sc['dot'] }}"></span>
                                {{ ucfirst($shift['status']) }}
                            </span>
                        @endif
                    </div>

                    @if (! $exists)
                        <div class="flex flex-col items-center justify-center py-8 text-gray-400 dark:text-gray-600">
                            <x-heroicon-o-document-text class="h-8 w-8 mb-2 opacity-40" />
                            <p class="text-sm font-medium">No report yet</p>
                            <p class="text-xs mt-0.5">Not submitted for today</p>
                        </div>

                    @else
                        <div class="flex flex-col gap-2">
                            @foreach ($metrics as $metric)
                                @php $valueColor = $metric['value_color'] ?? 'text-gray-900 dark:text-white'; @endphp
                                <div class="flex items-center justify-between rounded-lg bg-white dark:bg-gray-800 px-3 py-2 shadow-sm">
                                    <div class="flex items-center gap-2">
                                        <x-dynamic-component
                                            :component="$metric['icon']"
                                            class="h-4 w-4 text-gray-400 flex-shrink-0"
                                        />
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                            {{ $metric['label'] }}
                                        </span>
                                    </div>
                                    <span class="text-sm font-bold {{ $valueColor }}">
                                        {{ $shift[$metric['key']] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-auto pt-1">
                            @php
                                $pct      = $shift['attendance_pct'];
                                $barColor = match(true) {
                                    $pct >= 80 => 'bg-emerald-500',
                                    $pct >= 50 => 'bg-yellow-400',
                                    default    => 'bg-red-500',
                                };
                                $textColor = match(true) {
                                    $pct >= 80 => 'text-emerald-600 dark:text-emerald-400',
                                    $pct >= 50 => 'text-yellow-600 dark:text-yellow-400',
                                    default    => 'text-red-600 dark:text-red-400',
                                };
                            @endphp
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Attendance</span>
                                <span class="text-xs font-bold {{ $textColor }}">{{ $pct }}%</span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-white dark:bg-gray-800 overflow-hidden shadow-inner">
                                <div
                                    class="h-full rounded-full transition-all duration-500 {{ $barColor }}"
                                    style="width: {{ $pct }}%"
                                ></div>
                            </div>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
