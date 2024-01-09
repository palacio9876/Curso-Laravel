<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Chirp;

Route::view('/', 'welcome')->name('Welcome');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard','dashboard')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chirps', function () {
        return view('chirps.index');
    })->name('chirps.index');

    Route::post('/chirps', function (){
        Chirp::create([
            'message' => request('message'),
            'user_id' => auth()->id(),
        ]);

        return to_route('chirps.index')->with('status', __('Chirp created successfully'));
    });
});

require __DIR__.'/auth.php';

// Route::get('/chirps/{chirp}', function ($chirp) { //nombre de la ruta con su parametro 
//     if($chirp === "2"){
//         return to_route('chirps.index'); //Se utiliza el "to_route" y el nombre de la ruta sin necesidad de cambiar manualmente cada vez que el nombre de la ruta cambie
//     }
//         return "Welcome to chirps ". $chirp;//Devolvemos la view con el parametro dado por la url
// });