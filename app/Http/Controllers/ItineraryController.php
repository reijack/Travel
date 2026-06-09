<?php

namespace App\Http\Controllers;

use App\Models\Itinerary;
use App\Models\Trip;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $request->validate([
            'activity' => 'required|string|max:255',
            'day'      => 'required|integer',
        ]);

        $trip->itineraries()->create([
            'day'      => $request->day,
            'time'     => $request->time,
            'activity' => $request->activity,
            'location' => $request->location,
            'category' => $request->category ?? 'wisata',
            'notes'    => $request->notes,
        ]);

        return back()->with('success', 'Aktivitas berhasil ditambahkan!');
    }

    public function destroy(Itinerary $itinerary)
    {
        $itinerary->delete();
        return back()->with('success', 'Aktivitas dihapus.');
    }
}