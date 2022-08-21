<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class Garage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
    ];

    protected $appends = [
        'occupied_slot',
        'unoccupied_slot'
    ];

    public function getOccupiedSlotAttribute()
    {
        return $this->slots()->where('status', false)->count();
    }

    public function getUnoccupiedSlotAttribute()
    {
        return $this->slots()->where('status', true)->count();
    }


    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function slotStatusCount(bool $status)
    {
        return $this->slots->where('status', $status)->count();
    }


}
