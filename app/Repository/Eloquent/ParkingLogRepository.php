<?php

namespace App\Repository\Eloquent;

use App\Models\ParkingLog;
use App\Models\Slot;
use App\Models\SlotType;
use App\Repository\EloquentRepositoryInterface;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\App;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ParkingLogRepository extends BaseRepository implements EloquentRepositoryInterface {

    public function __construct(ParkingLog $parkingLog)
    {
        $this->model = $parkingLog;
    }

    public function queryBuidler()
    {
        return $this->model
        ->with('slot', 'customer')
        ->whereNull('exit_at')
        ->whereHas('slot', function($query){
            $query->where('status', false);
        })
        ->latest()
        ->paginate(5);
    }

    public function getVehicle($plate_no)
    {
        return $this->model
        ->with('slot', 'customer')
        ->whereHas('customer', function($query) use ($plate_no){
            $query->where('plate_number', $plate_no);
        })->latest()->first();
    }

    public function getVehicleEntered($plate_no)
    {
        return $this->model
        ->whereNull('exit_at')
        ->with('slot', 'customer')
        ->whereHas('customer', function($query) use ($plate_no){
            $query->where('plate_number', $plate_no);
        })->latest()->first();
    }

    public function checkParkingType($plate_no)
    {
        $res = $this->model
        ->with('slot', 'customer')
        ->whereHas('customer', function($query) use ($plate_no){
            $query->where('plate_number', $plate_no);
        })
        ->where('exit_at', '>=', now()->subHour())
        ->latest()
        ->first();

        return $res ? 'Continuous Rate' : 'Regular Rate';
    }

    public function exitVehicle(ParkingLog $parkingLog)
    {
        $parkingLog->exit_at = now();
        $parkingLog->save();

        $slot = Slot::find($parkingLog->slot->id);
        $slot->status = true;
        $slot->save();

        return $parkingLog;
    }

    public function computeFee(ParkingLog $parkingLog, $rate_type, $exit_datetime = null)
    {

        $enter_at = Carbon::parse($parkingLog->enter_at);
        $exit_at =  $exit_datetime ? $exit_datetime : Carbon::parse(now());

        $difference = $exit_at->diff($enter_at)->format('%d:%H:%i:%s');
        return $this->getFeeTimeParked($difference, $parkingLog, $rate_type);

    }

    public function getDayEquivalent($time)
    {
        $timeArr = explode(':', $time);
        return $timeArr[0] * 5000;

    }

    public function getFeeTimeParked($time, $parkingLog, $rate_type) {
        //convertion into an hr
        $timeArr = explode(':', $time);
        $dayRate = $timeArr[0] * 5000;
        $decTime = ($timeArr[1]) + ($timeArr[2]/60) + ($timeArr[3]/3600);
        $res = $this->roundUp($decTime);

        if ($rate_type === 'Regular Rate') {
            $val = $res - 3;
            if ($val < 0) {
                $hrRate = 0;
                $flat_rate_amount = $res * 40; // 40 is the flat prioce for first 3 hours
            } else {
                $hrRate = $val * $parkingLog->slot->slot_type->price;
                $flat_rate_amount = 40 * 3; //assuming that the vehicle stays more than 3 hrs time the flat price
            }
        }else {
            $hrRate = $res  * $parkingLog->slot->slot_type->price;
            $flat_rate_amount = 0; //120 pesos
        }

        $total = $dayRate + $hrRate + $flat_rate_amount;
        return $total;
    }

    public function roundUp($value)
    {
        $decimalValue = explode('.', number_format($value, 1))[1];
        if ($decimalValue >= 1) {
            $value = ((int) $value) + 1;
            return $value;
        }

        return (int) $value;
    }
}
