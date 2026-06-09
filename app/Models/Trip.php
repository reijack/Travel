<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'trip_name',
        'destination',
        'start_date',
        'end_date',
        'people',
        'budget',
        'status',
    ];

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class)->orderBy('day')->orderBy('time');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}