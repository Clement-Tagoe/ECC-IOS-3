<x-filament-widgets::widget>
    <x-filament::section>

        {{-- Header: mimics ChartWidget heading/description --}}
        <x-slot name="heading">Call Consoles</x-slot>
        <x-slot name="description">Live assignment & status overview</x-slot>

        {{-- Summary counts --}}
        <div class="flex items-center gap-3 mb-4 flex-wrap">
            @php
                $summaryItems = [
                    [
                        'label'   => 'Total',
                        'count'   => $total,
                        'bg'      => 'bg-gray-100',
                        'dot'     => null,
                        'text'    => 'text-gray-500',
                        'bold'    => 'text-gray-900',
                    ],
                    [
                        'label'   => 'Assigned',
                        'count'   => $assigned,
                        'bg'      => 'bg-emerald-100',
                        'dot'     => 'bg-emerald-500',
                        'text'    => 'text-emerald-700',
                        'bold'    => 'text-emerald-800',
                    ],
                    [
                        'label'   => 'Unassigned',
                        'count'   => $unassigned,
                        'bg'      => 'bg-zinc-100',
                        'dot'     => 'bg-zinc-400',
                        'text'    => 'text-zinc-500',
                        'bold'    => 'text-zinc-700',
                    ],
                    [
                        'label'   => 'Maintenance',
                        'count'   => $maintenance,
                        'bg'      => 'bg-yellow-50',
                        'dot'     => 'bg-yellow-400',
                        'text'    => 'text-yellow-700',
                        'bold'    => 'text-yellow-800',
                    ],
                    [
                        'label'   => 'Faulty',
                        'count'   => $faulty,
                        'bg'      => 'bg-red-50',
                        'dot'     => 'bg-red-500',
                        'text'    => 'text-red-700',
                        'bold'    => 'text-red-800',
                    ],
                ];
            @endphp

            @foreach ($summaryItems as $item)
                <div class="flex items-center justify-evenly gap-1 rounded-lg {{ $item['bg'] }} px-3 py-1">
                    @if ($item['dot'])
                        <span class="h-2 w-2 rounded-full {{ $item['dot'] }}"></span>
                    @endif
                    <span class="text-xs font-medium {{ $item['text'] }}">{{ $item['label'] }}</span>
                    <span class="text-sm font-bold {{ $item['bold'] }}">{{ $item['count'] }}</span>
                </div>
            @endforeach
        </div>

        {{-- Console pills --}}
        @if ($consoles->isEmpty())
            <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                <x-heroicon-o-computer-desktop class="h-8 w-8 mb-2 opacity-40" />
                <p class="text-sm">No consoles found</p>
            </div>
        @else
            <div class="flex justify-evenly items-center flex-wrap gap-3">
                @foreach ($consoles as $console)
                    @php
                        // Priority: status (faulty/maintenance) overrides assignment color
                        $statusValue = $console->status instanceof \BackedEnum
                            ? $console->status->value
                            : $console->status;

                        [$bg, $dot, $text, $ring] = match ($statusValue) {
                            'faulty'      => [
                                'bg-red-100',
                                'bg-red-500',
                                'text-red-800',
                                'ring-red-300',
                            ],
                            'maintenance' => [
                                'bg-yellow-100',
                                'bg-yellow-400',
                                'text-yellow-800',
                                'ring-yellow-300',
                            ],
                            default       => $console->monitoring_staff_id !== null
                                ? [
                                    'bg-emerald-200',
                                    'bg-emerald-500',
                                    'text-emerald-800',
                                    'ring-emerald-300',
                                ]
                                : [
                                    'bg-zinc-100',
                                    'bg-zinc-400',
                                    'text-zinc-600',
                                    'ring-zinc-300',
                                ],
                        };
                    @endphp

                    <div class="relative group/pill">
                        <span class="inline-flex items-center gap-1.5 rounded-full px-8 py-4 text-xs font-semibold ring-1 {{ $bg }} {{ $text }} {{ $ring }} cursor-default select-none">
                            <span class="h-2 w-2 rounded-full {{ $dot }}"></span>
                            {{ $console->console_name }}
                        </span>

                        {{-- Tooltip --}}
                        <div class="pointer-events-none absolute -top-9 left-1/2 -translate-x-1/2 z-50
                                    whitespace-nowrap rounded-lg bg-gray-900 px-2.5 py-1.5
                                    text-xs text-white shadow-lg
                                    opacity-0 scale-95 transition-all duration-150
                                    group-hover/pill:opacity-100 group-hover/pill:scale-100">
                            <x-heroicon-m-user-circle class="inline h-3 w-3 mb-0.5 mr-0.5 opacity-70" />
                            {{ $console->assignee->name ?? 'Unassigned' }}
                            {{-- little arrow --}}
                            <span class="absolute left-1/2 -bottom-1 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></span>
                        </div>
                    </div>
                    
                @endforeach
            </div>
        @endif

    </x-filament::section>
</x-filament-widgets::widget>