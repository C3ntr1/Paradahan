<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'parking_log_id',
        'fees',
        'remarks',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function parking_log()
    {
        return $this->belongsTo(ParkingLog::class);
    }

    public function totalSales()
    {
        return $this->sum('fees');
    }
}
