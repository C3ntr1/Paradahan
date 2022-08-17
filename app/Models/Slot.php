<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'garage_id',
        'slot_type_id',
        'status',
    ];


    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function parking_log()
    {
        return $this->hasOne(ParkingLog::class);
    }
}
