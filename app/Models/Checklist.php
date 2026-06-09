<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable = ['trip_id','item_name','note','status'];

    protected $casts = ['status' => 'boolean'];

    public function trip() {
        return $this->belongsTo(Trip::class);
    }
}