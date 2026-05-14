
    {{-- Normal toolbar --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            {{-- Upload --}}
            {{-- {{ $this->uploadFilesAction }} --}}
            
            <button>
                Upload
            </button>
            {{-- New folder --}}
            {{-- {{ $this->createFolderAction }} --}}
            <button>
                New folder
            </button>

            {{-- Refresh --}}
            {{-- {{ $this->refreshAction }} --}}
        </div>

        <div class="flex items-center gap-2">
            {{-- Sort dropdown --}}
            <select
                wire:change="setSortField($event.target.value)"
                class="fm-select"
            >
                <option value="name" @selected($sortField === 'name')></option>
                <option value="size" @selected($sortField === 'size')></option>
                <option value="date" @selected($sortField === 'date')></option>
                <option value="type" @selected($sortField === 'type')></option>
            </select>

            {{-- Sort direction toggle --}}
            <button
                wire:click="setSortField('{{ $sortField }}')"
                type="button"
                class="flex size-9 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-white/5 dark:hover:text-gray-300"
                title="{{ $sortDirection === 'asc' ? __('filament-file-manager::file-manager.toolbar.sort_asc') : __('filament-file-manager::file-manager.toolbar.sort_desc') }}"
            >
                <x-filament::icon
                    :icon="$sortDirection === 'asc' ? 'heroicon-m-bars-arrow-up' : 'heroicon-m-bars-arrow-down'"
                    class="size-5"
                />
            </button>

            {{-- View mode toggle --}}
            <div class="flex items-center rounded-lg bg-gray-100 p-0.5 dark:bg-white/5">
                <button
                    wire:click="setViewMode('grid')"
                    type="button"
                    @class([
                        'flex size-8 items-center justify-center rounded-md transition',
                        'bg-white text-primary-600 shadow-sm dark:bg-gray-700 dark:text-primary-400' => $viewMode === 'grid',
                        'text-gray-400 hover:text-gray-500 dark:hover:text-gray-300' => $viewMode !== 'grid',
                    ])
                >
                    <x-filament::icon icon="heroicon-m-squares-2x2" class="size-4" />
                </button>
                <button
                    wire:click="setViewMode('list')"
                    type="button"
                    @class([
                        'flex size-8 items-center justify-center rounded-md transition',
                        'bg-white text-primary-600 shadow-sm dark:bg-gray-700 dark:text-primary-400' => $viewMode === 'list',
                        'text-gray-400 hover:text-gray-500 dark:hover:text-gray-300' => $viewMode !== 'list',
                    ])
                >
                    <x-filament::icon icon="heroicon-m-list-bullet" class="size-4" />
                </button>
            </div>
        </div>
    </div>