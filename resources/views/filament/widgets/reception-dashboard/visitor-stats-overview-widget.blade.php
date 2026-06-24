<x-filament-widgets::widget>
    <x-filament::section>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4">
        @foreach ($stats as $stat)
            <div class="relative rounded-2xl overflow-hidden shadow-sm {{ $stat['bg'] }}">

                {{-- Background icon watermark --}}
                <div class="absolute -bottom-3 -right-3 opacity-10">
                    <x-dynamic-component :component="$stat['icon']" class="h-20 w-20 {{ $stat['text'] }}" />
                </div>

                <div class="relative p-4 flex flex-col gap-3">

                    {{-- Icon + Label --}}
                    <div class="flex items-center gap-2">
                        <div class="rounded-lg p-1.5 {{ $stat['icon_bg'] }}">
                            <x-dynamic-component
                                :component="$stat['icon']"
                                class="h-4 w-4 {{ $stat['text'] }}"
                            />
                        </div>
                        <p class="text-xs font-medium {{ $stat['text'] }} opacity-90 leading-tight">
                            {{ $stat['label'] }}
                        </p>
                    </div>

                    {{-- Value --}}
                    <p class="text-3xl font-black {{ $stat['text'] }} leading-none tracking-tight">
                        {{ $stat['value'] }}
                    </p>

                    {{-- Description --}}
                    <p class="text-xs {{ $stat['text'] }} opacity-70 truncate">
                        {{ $stat['description'] }}
                    </p>

                </div>
            </div>
        @endforeach
    </div>
    </x-filament::section>
</x-filament-widgets::widget>
