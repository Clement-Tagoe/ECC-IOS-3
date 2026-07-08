<x-filament-panels::page>
    @php
        $consoles = $this->getConsoles();
        $counts = $this->getAssignmentCount();

        $statusConfig = [
            'operational' => [
                'label'      => 'Operational',
                'badge'      => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                'icon_color' => 'text-emerald-500',
                'dot'        => 'bg-emerald-500',
            ],
            'faulty' => [
                'label'      => 'Faulty',
                'badge'      => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                'icon_color' => 'text-red-500',
                'dot'        => 'bg-red-500',
            ],
            'maintenance' => [
                'label'      => 'Maintenance',
                'badge'      => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                'icon_color' => 'text-yellow-500',
                'dot'        => 'bg-yellow-400',
            ],
            

            $assignmentConfig = [
                'assigned' => [
                'bar' => 'bg-sky-500',
                'ring' => 'ring-sky-200 dark:ring-sky-800'
                ],
                'unassigned' => [
                    'bar' => 'bg-zinc-500',
                    'ring' => 'ring-zinc-200 dark:ring-zinc-800'
                ],
            ]



        ];
    @endphp

    {{-- Summary strip --}}
    <div class="mb-6 grid grid-cols-5 gap-4">
        @foreach ($counts as $label => $count)
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-4 flex items-center gap-4 shadow-sm">
                <span class="inline-block h-10 w-1.5 rounded-full {{ $assignmentConfig[$label]['bar'] }}"></span>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $count }}</p>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ $label }}</p>
                </div>
            </div>
        @endforeach

        @foreach (['operational' => 'Operational', 'faulty' => 'Faulty', 'maintenance' => 'Maintenance'] as $key => $label)
            @php $count = $consoles->where('status', $key)->count(); @endphp
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-5 py-4 flex items-center gap-4 shadow-sm">
                <span class="inline-block h-10 w-1.5 rounded-full {{ $statusConfig[$key]['dot'] }}"></span>
                <div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $count }}</p>
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ $label }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Console cards grid --}}
    @if ($consoles->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-gray-400">
            <x-heroicon-o-computer-desktop class="h-14 w-14 mb-3 opacity-40" />
            <p class="text-lg font-medium">No consoles found</p>
            <p class="text-sm mt-1">Add a console to get started.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach ($consoles as $console)
                @php 
                    $status = $statusConfig[$console->status->value] ?? $statusConfig['maintenance']; 
                    $assignment = $console->assignee == Null ? $assignmentConfig['unassigned'] : $assignmentConfig['assigned'] ;
                @endphp

                <div class="relative flex flex-col rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200 ring-1 {{ $assignment['ring'] }}">

                    {{-- Colored status bar at top --}}
                    <div class="h-1.5 w-full {{ $assignment['bar'] }}"></div>

                    <div class="flex flex-col flex-1 p-5">

                        {{-- Header row: icon + name --}}
                        <div class="flex items-start gap-3 mb-4">
                            <div class="flex-shrink-0 rounded-xl bg-gray-100 dark:bg-gray-700 p-2.5">
                                <x-heroicon-o-computer-desktop class="h-6 w-6 {{ $status['icon_color'] }}" />
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate leading-snug">
                                    {{ $console->console_name }}
                                </h3>
                                {{-- <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">ID #{{ $console->id }}</p> --}}
                            </div>
                        </div>

                        {{-- Status badge --}}
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $status['badge'] }}">
                                <span class="inline-block h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                                {{ $status['label'] }}
                            </span>
                        </div>

                        {{-- Assigned To --}}
                        <div class="flex items-center gap-2 mt-auto pt-3 border-t border-gray-100 dark:border-gray-700">
                            <x-heroicon-o-user-circle class="h-4 w-4 text-gray-400 flex-shrink-0" />
                            <span class="text-sm text-gray-600 dark:text-gray-300 truncate">
                                {{ $console->assignee->name ?? 'Unassigned' }}
                            </span>
                        </div>
                    </div>

                    {{-- Edit button --}}
                    {{($this->editAction)(['console' => $console->id])}}
                    {{-- <button class="bg-gray-200 dark:bg-gray-700 px-5 py-2" wire:click="mountAction('edit', { id: {{ $console->id }} })">
                        Edit
                    </button> --}}
                </div>
            @endforeach
        </div>
    @endif

    {{-- <x-filament-actions::modals /> --}}

</x-filament-panels::page>
