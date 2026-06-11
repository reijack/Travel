<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::latest()->get();
        return view('trips.index', compact('trips'));
    }

    public function create()
    {
        return view('trips.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'trip_name'   => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date',
            'people'      => 'required|integer|min:1',
            'budget'      => 'nullable|integer',
        ]);

        Trip::create($request->all());

        return redirect()->route('trips.index')
                         ->with('success', 'Trip berhasil dibuat! 🎉');
    }

    public function show(Trip $trip)
    {
        $itineraries = $trip->itineraries()->get()->groupBy('day');
        $budgets     = $trip->budgets;
        $checklists  = $trip->checklists;
        $photos      = $trip->photos;

        return view('trips.show', compact(
            'trip', 'itineraries', 'budgets', 'checklists', 'photos'
        ));
    }

    public function edit(Trip $trip)
    {
        return view('trips.edit', compact('trip'));
    }

    public function update(Request $request, Trip $trip)
    {
       $request->validate([
    'trip_name'   => ['required','string','max:255','regex:/^[A-Za-z\s]+$/'],
    'destination' => ['required','string','max:255','regex:/^[A-Za-z\s,]+$/'],
    'start_date'  => 'required|date',
    'end_date'    => 'required|date',
    'people'      => 'required|integer|min:1',
    'budget'      => 'nullable|integer',
], [
    'trip_name.regex'   => 'Nama trip hanya boleh huruf, tidak boleh angka!',
    'destination.regex' => 'Destinasi hanya boleh huruf, tidak boleh angka!',
]);

        $trip->update($request->all());

        return redirect()->route('trips.show', $trip)
                         ->with('success', 'Trip berhasil diupdate!');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();

        return redirect()->route('trips.index')
                         ->with('success', 'Trip dihapus.');
    }
}