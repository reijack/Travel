<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'trip_id','category','description','estimated','actual'
    ];
    public function trip() {
        return $this->belongsTo(Trip::class);
    }
}