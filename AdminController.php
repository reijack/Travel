<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trip;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTrips = Trip::count();
        $totalAdmins = User::where('is_admin', true)->count();
        $users = User::latest()->get();

        return view('admin.index', compact(
            'totalUsers', 'totalTrips', 'totalAdmins', 'users'
        ));
    }

    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Akun admin tidak bisa dihapus!');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}