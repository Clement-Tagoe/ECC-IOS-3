<?php

namespace App\Livewire;

use App\Models\File;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Closure;
use Livewire\WithPagination;


class FilesManager extends Component implements HasActions, HasForms
{
    use InteractsWithActions, InteractsWithForms, WithFileUploads, WithPagination;

    public $files = [];
    public ?int $parent_id = null; 
    public ?File $parent = null;
    public ?File $currentFolder;
    public $folder = '';

    public function getRoot()
    {
        return File::query()->whereIsRoot()->where('created_by', Auth::user()->id)->firstOrFail();
    }
    
    public function uploadFilesAction(): Action
    {
        return Action::make('uploadFiles')
            ->label(__('Upload'))
            ->icon('heroicon-o-arrow-up-tray')
            ->color('primary')
            ->schema([
                Forms\Components\FileUpload::make('files')
                    ->label(__('File'))
                    ->multiple()
                    ->maxSize(5120)
                    ->maxFiles(20)
                    ->required()
                    ->rules([
                        fn (): Closure => function (string $attribute, $value, $fail) {
                        /** @var $value \Illuminate\Http\UploadedFile */
                        $file = File::query()->where('name', $value->getClientOriginalName())
                            ->where('created_by', Auth::user()->id)
                            ->where('parent_id', $this->parent_id)
                            ->whereNull('deleted_at')
                            ->exists();

                        if ($file) {
                            $fail('File "' . $value->getClientOriginalName() . '" already exists.');
                        }
                      }
                    ]),
            ])
            ->action(function (array $data):void {
                
            });
    }

    public function render()
    {
        if ($this->folder) {
            $this->currentFolder = File::query()->where('created_by', Auth::user()->id)->where('path', $this->folder)->firstOrFail();
        }
    
        if (!$this->folder) 
            {
                $this->currentFolder = $this->getRoot();
            }
        
        $folder = $this->currentFolder;
        
        $ancestors = $folder->ancestorsAndSelf($folder->id);

        $breadcrumbs = [];
        foreach ($ancestors as $ancestor) {
            if (!$ancestor->parent_id) {
                $breadcrumbs[] = [
                    'name' => 'My Files',
                    'path' => route('my-files.index'),
                ];
            } else {
                $breadcrumbs[] = [
                    'name' => $ancestor->name,
                    'path' => route('my-files.index', $ancestor->path),
                ];
            }
        }

        $files = File::query()
                        ->where('parent_id', $folder->id)
                        ->where('created_by', Auth::user()->id)
                        ->orderBy('is_folder', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(12);

        return view('livewire.files-manager', compact('files', 'breadcrumbs'));
    }

}
