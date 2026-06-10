<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\AuthController; // ← baru
use App\Http\Controllers\AdminController;

// Auth (publik)
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);

// Semua trip route dilindungi auth
Route::middleware('auth')->group(function() {
    Route::get('/', fn() => redirect()->route('trips.index'));
    Route::resource('trips', TripController::class);

    Route::post('trips/{trip}/itineraries', [ItineraryController::class, 'store'])->name('itineraries.store');
    Route::delete('itineraries/{itinerary}', [ItineraryController::class, 'destroy'])->name('itineraries.destroy');

    Route::post('trips/{trip}/budgets', [BudgetController::class, 'store'])->name('budgets.store');
    Route::delete('budgets/{budget}', [BudgetController::class, 'destroy'])->name('budgets.destroy');

    Route::post('trips/{trip}/checklists', [ChecklistController::class, 'store'])->name('checklists.store');
    Route::patch('checklists/{checklist}/toggle', [ChecklistController::class, 'toggle'])->name('checklists.toggle');
    Route::delete('checklists/{checklist}', [ChecklistController::class, 'destroy'])->name('checklists.destroy');

    Route::post('trips/{trip}/photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');

    // Admin routes
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::delete('users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
});
});