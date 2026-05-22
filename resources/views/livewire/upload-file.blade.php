<div>
    <form wire:submit="create">
        {{ $this->form }}
        
        <div class="flex gap-4 mt-5">
            <x-filament::button type="submit">
                Submit
            </x-filament::button>
            <x-filament::button x-on:click="close()" color="gray">
                Cancel
            </x-filament::button>
        </div>
        
    </form>
</div>