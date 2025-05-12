<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Models\Image;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect('/images');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('images', ImageController::class,[
        'except' => ['destroy', 'edit', 'update']
    ]);
      
    Route::resource('likes', LikeController::class,[
        'only' => ['store', 'destroy']
    ]);
    Route::resource('comments', CommentController::class,[
        'only' => ['store']
    ]);
      
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    
});

require __DIR__.'/auth.php';
