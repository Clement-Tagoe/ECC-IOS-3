<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return Auth::check()
        ? redirect('/auth')
        : redirect('/auth/login');
});

// Route::get('test', function () {
//     $recipient = Auth::user();

//     Notification::make()
//         ->title('Sending test notification')
//         ->sendToDatabase($recipient, isEventDispatched: true);

//     dd('done testing');
    
//     // event(new DatabaseNotificationsSent($recipient));
// })->middleware('auth');