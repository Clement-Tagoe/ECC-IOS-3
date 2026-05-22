<?php

namespace App\Livewire;

use App\Models\File;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadFile extends Component implements HasSchemas
{
    use InteractsWithSchemas, WithFileUploads;

    public ?array $data = [];
    public ?array $files = [];
    public ?int $parent_id = null; 
    public ?File $parent = null;
    public $currentUrl = '';
    public ?string $folder;

    public function mount(Request $request): void
    {
        $this->form->fill();
        $this->currentUrl = $request->url();
    }
    
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('File*')
            ])
            ->statePath('data');
    }
    
    public function create(): void
    {
        dd($this->form->getState());
    }

    public function getRoot()
    {
        return File::query()->whereIsRoot()->where('created_by', Auth::user()->id)->firstOrFail();
    }

    protected function saveFile($file, $user, $parent): void
    {
        $path = $file->store('/files/' . $user->id, 'local');

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

    protected function fileRules():array
    {
        return [
            'required',
                'file',
                function ($attribute, $value, $fail) {
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
        ];
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

    public function render()
    {
        return view('livewire.upload-file');
    }
}
