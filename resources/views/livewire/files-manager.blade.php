<div>
    {{-- Main content --}}
    <div class="flex min-w-0 flex-1 flex-col gap-4">
        {{-- Toolbar --}}
        @include('components.toolbar')
        
        
        {{-- Breadcrumbs --}}
        @include('components.breadcrumbs')

        {{-- Content --}}
        <div class="flex flex-col rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10" data-fm-content @click="previewFile = null">
            
        </div>

        <x-filament-actions::modals />
    </div>
</div>
