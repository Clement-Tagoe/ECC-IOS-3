<?php

use App\Livewire\FilesManager;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    Route::livewire('/my-files/{folder?}', FilesManager::class)
        ->where('folder', '(.*)')->name('my-files.index');

});

// Route::get('test', function () {
//     $recipient = Auth::user();

//     Notification::make()
//         ->title('Sending test notification')
//         ->sendToDatabase($recipient, isEventDispatched: true);

//     dd('done testing');
    
//     // event(new DatabaseNotificationsSent($recipient));
// })->middleware('auth');