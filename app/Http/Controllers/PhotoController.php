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
        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        $path = $request->file('image')->store('photos', 'public');

        $trip->photos()->create([
            'image_path' => $path,
            'caption'    => $request->caption,
        ]);

        return back()->with('success', 'Foto berhasil diupload!');
    }

    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($photo->image_path);
            $photo->image_path = $request->file('image')->store('photos', 'public');
        }

        if ($request->filled('caption')) {
            $photo->caption = $request->caption;
        }

        $photo->save();

        return back()->with('success', 'Foto berhasil diupdate!');
    }

    public function destroy(Photo $photo)
    {
        Storage::disk('public')->delete($photo->image_path);
        $photo->delete();
        return back()->with('success', 'Foto dihapus.');
    }
}