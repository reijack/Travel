<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    protected $fillable = [
        'trip_id','day','time','activity',
        'location','category','notes'
    ];
    public function trip() {
        return $this->belongsTo(Trip::class);
    }
}