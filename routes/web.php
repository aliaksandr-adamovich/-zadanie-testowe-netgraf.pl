<?php

use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PetController::class, 'index'])->name('pets.index');

Route::prefix('pets')->group(function () {
    Route::post('/{id}/uploadImage', [PetController::class, 'uploadImage'])->name('pets.uploadImage');

    Route::get('/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/', [PetController::class, 'store'])->name('pets.store');
    Route::get('/{id}', [PetController::class, 'show'])->name('pets.show');
    Route::get('/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/{id}', [PetController::class, 'update'])->name('pets.update');
    Route::post('/{id}/status', [PetController::class, 'updateStatus'])->name('pets.updateStatus');
    Route::delete('/{id}', [PetController::class, 'destroy'])->name('pets.destroy');
});
