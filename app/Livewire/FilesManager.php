<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\User;
use Closure;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class FilesManager extends Component implements HasActions, HasForms
{
    use InteractsWithActions, InteractsWithForms, WithFileUploads, WithPagination;

    public $files = [];
    public ?int $parent_id = null; 
    public ?File $parent = null;
    public ?File $currentFolder;
    public $folder = '';
    public string $currentPath = '';


    public function getRoot()
    {
        return File::query()->whereIsRoot()->where('created_by', Auth::user()->id)->firstOrFail();
    }
    
    protected function parentRules(?int $user_id = null):array
    {
        return [
            Rule::exists(File::class, 'id')
                ->where(function (Builder $query) use ($user_id) {
                    return $query
                        ->where('is_folder', '=', '1')
                        ->where('created_by', '=' , $user_id);
                })
        ];
    }

    protected function saveFile($file, $user, $parent): void
    {
        $path = Storage::disk('public')->move(
            $file,
            'files/' . basename($file)
        );

        $model = new File();
        $model->storage_path = $path;
        $model->is_folder = false;
        $model->name = $file->getClientOriginalName();
        $model->mime = $file->getMimeType();
        $model->size = $file->getSize();
        $model->created_by = $user->id;
        $model->updated_by = $user->id;

        $parent->appendNode($model);
        
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
                $this->parent_id = $this->currentFolder->id;
                if($this->parentRules(Auth::user()->id))
                    {
                        foreach ($data['files'] as $file) {
                            /** @var \Illuminate\Http\UploadedFile $file */
                            $this->saveFile($file, Auth::user(), $this->currentFolder);
                        }
                    }
            });
    }

    public function navigateTo(string $path): void
    {
        $this->currentPath = $path;
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

        $files = File::query()
                        ->where('parent_id', $folder->id)
                        ->where('created_by', Auth::user()->id)
                        ->orderBy('is_folder', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(12);

        return view('livewire.files-manager', compact('files', 'ancestors'));
    }

}
