<?php

namespace App\Observers;

use App\Models\File;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $file = new File();
        $file->name = $user->email;
        $file->is_folder = 1;
        $file->created_by = $user->id;
        $file->updated_by = $user->id;
        $file->makeRoot()->save();
    }
}
