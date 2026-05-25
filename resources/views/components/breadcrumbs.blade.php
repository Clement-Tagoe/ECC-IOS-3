<nav class="flex items-center gap-1.5 text-sm">
    @foreach ($ancestors as $index => $ancestor)
        @if ($index > 0)
            <x-filament::icon icon="heroicon-m-chevron-right" class="size-3.5 shrink-0 text-gray-300 dark:text-gray-600" />
        @endif

        @if ($loop->last && $index > 0)
            <span class="truncate font-medium text-gray-700 dark:text-gray-200">
                {{ $ancestor->name }}
            </span>
        @else
            @if ($index === 0)
            <button
                wire:click="navigateTo('/my-files')"
                type="button"
                class="flex shrink-0 items-center gap-1 rounded-md px-1.5 py-0.5 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200"
            >
                <x-filament::icon icon="heroicon-m-home" class="size-3.5" />
                <span class="max-w-[120px] truncate">{{ __('My Files') }}</span>
            </button>
            @else
            <button
                wire:click="navigateTo('{{ $ancestor->path }}')"
                type="button"
                class="flex shrink-0 items-center gap-1 rounded-md px-1.5 py-0.5 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200"
            >
                
                <span class="max-w-[120px] truncate">{{ $ancestor->name }}</span>
            </button>
            @endif
        @endif
    @endforeach
</nav>
