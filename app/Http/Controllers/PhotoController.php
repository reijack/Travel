<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $request->validate(['image' => 'required|image|max:5120']);

        $path = $request->file('image')->store('photos', 'public');

        $trip->photos()->create([
            'image_path' => $path,
            'caption'    => $request->caption,
        ]);

        return back()->with('success', 'Foto berhasil diupload!');
    }

    public function update(Request $request, Photo $photo)
    {
        $photo->update(['caption' => $request->caption]);
        return back()->with('success', 'Caption berhasil diupdate!');
    }

    public function destroy(Photo $photo)
    {
        Storage::disk('public')->delete($photo->image_path);
        $photo->delete();
        return back()->with('success', 'Foto dihapus.');
    }
}