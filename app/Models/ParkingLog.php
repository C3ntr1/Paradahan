<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'slot_id',
        'enter_at',
        'exit_at'
    ];

    protected $append =[
        'formatted_enter_at'
    ];

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getFormattedEnterAtAttribute()
    {
        return date_format(date_create($this->enter_at), "l, F d, Y H:i a");
    }
}
