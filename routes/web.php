<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get("/counties", [CountyController::class, "index"])->name('counties.index');
Route::get("/counties/{id}", [CountyController::class, "show"])->name('counties.show');
Route::post("/counties/{id}", [CountyController::class, "edit"])->name('counties.edit');
Route::post('/counties', [CountyController::class, 'store'])->name('counties.store');
Route::put("/counties/{id}", [CountyController::class, "update"])->name('counties.update');
Route::delete("/counties/{id}", [CountyController::class, "destroy"])->name('counties.destroy');

// Route::get('/counties/export/csv', [CountyController::class, 'exportCsv'])->name('counties.export.csv');
// Route::get('/counties/export/pdf', [CountyController::class, 'exportPdf'])->name('counties.export.pdf');
// Route::get('/counties/mail', [CountyController::class, 'sendMail'])->name('counties.mail');

require __DIR__.'/auth.php';
