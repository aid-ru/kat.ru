<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ListingController;

Route::get('/', function () {
    return view('welcome');
});

// Главная страница
Route::get('/home', [HomePageController::class, 'index'])->name('home');

// Страница категории
Route::get('/category/{slug}', [HomePageController::class, 'category'])->name('category.show');

// Роуты для создания объявлений (должны быть защищены аутентификацией)
Route::middleware(['auth'])->group(function () {
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings/store', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');
});

// Добавьте роут для отображения всех объявлений (для тестов, пока не настроен поиск)
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');



Route::get('/dashboard', function () {
    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
