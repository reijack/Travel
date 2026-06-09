<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\PhotoController;

// Dashboard → redirect ke trips
Route::get('/', function () {
    return redirect()->route('trips.index');
});

// Trips CRUD
Route::resource('trips', TripController::class);

// Nested resources
Route::post('trips/{trip}/itineraries',        [ItineraryController::class, 'store'])->name('itineraries.store');
Route::delete('itineraries/{itinerary}',       [ItineraryController::class, 'destroy'])->name('itineraries.destroy');

Route::post('trips/{trip}/budgets',            [BudgetController::class, 'store'])->name('budgets.store');
Route::delete('budgets/{budget}',              [BudgetController::class, 'destroy'])->name('budgets.destroy');

Route::post('trips/{trip}/checklists',         [ChecklistController::class, 'store'])->name('checklists.store');
Route::patch('checklists/{checklist}/toggle',  [ChecklistController::class, 'toggle'])->name('checklists.toggle');
Route::delete('checklists/{checklist}',        [ChecklistController::class, 'destroy'])->name('checklists.destroy');

Route::post('trips/{trip}/photos',             [PhotoController::class, 'store'])->name('photos.store');
Route::delete('photos/{photo}',                [PhotoController::class, 'destroy'])->name('photos.destroy');