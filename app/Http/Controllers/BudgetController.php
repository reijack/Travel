<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Trip;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function store(Request $request, Trip $trip)
    {
        $request->validate([
            'estimated' => 'required|integer|min:0',
        ]);

        $trip->budgets()->create([
            'category'    => $request->category,
            'description' => $request->description,
            'estimated'   => $request->estimated,
            'actual'      => $request->actual,
        ]);

        return back()->with('success', 'Budget berhasil ditambahkan!');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return back()->with('success', 'Budget dihapus.');
    }
}