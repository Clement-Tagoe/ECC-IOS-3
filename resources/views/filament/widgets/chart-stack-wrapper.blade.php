<x-filament-widgets::widget>
    <div class="flex flex-col md:gap-6 xl:gap-14">
        @livewire(\App\Filament\Widgets\MainDashboard\TopMonitoringTopicsChart::class)
        @livewire(\App\Filament\Widgets\MainDashboard\CallBreakdownChart::class)
    </div>
</x-filament-widgets::widget>
