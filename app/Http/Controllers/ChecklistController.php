<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Trip;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $request->validate(['item_name' => 'required|string|max:255']);

        $trip->checklists()->create([
            'item_name' => $request->item_name,
            'note'      => $request->note,
            'status'    => false,
        ]);

        return back()->with('success', 'Item ditambahkan!');
    }

    public function toggle(Checklist $checklist)
    {
        $checklist->update(['status' => !$checklist->status]);
        return back();
    }

    public function update(Request $request, Checklist $checklist)
    {
        $request->validate(['item_name' => 'required|string|max:255']);

        $checklist->update([
            'item_name' => $request->item_name,
            'note'      => $request->note,
        ]);

        return back()->with('success', 'Item berhasil diupdate!');
    }

    public function destroy(Checklist $checklist)
    {
        $checklist->delete();
        return back()->with('success', 'Item dihapus.');
    }
}