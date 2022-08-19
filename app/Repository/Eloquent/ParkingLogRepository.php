<?php

namespace App\Repository\Eloquent;

use App\Models\ParkingLog;
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

    public function getVehicle($plate_no)
    {
        return $this->model->with('slot', 'customer')
        ->whereHas('customer', function($query) use ($plate_no){
            $query->where('plate_number', $plate_no);
        })->first();
    }

    public function exitvehicle(ParkingLog $parkingLog)
    {
        $parkingLog->exit_at = now();
        $parkingLog->save();

        return $parkingLog;
    }

    public function computeFee(ParkingLog $parkingLog, $exit_datetime = null)
    {

        $enter_at = Carbon::parse($parkingLog->enter_at);
        $exit_at =  $exit_datetime ? $exit_datetime : Carbon::parse(now());

        $difference = $exit_at->diff($enter_at)->format('%d:%H:%i:%s');
        return ($this->getTimeParked($difference) * $parkingLog->slot->slot_type->price) + $this->getDayEquivalent($difference);

    }

    public function getDayEquivalent($time)
    {
        $timeArr = explode(':', $time);
        return $timeArr[0] * 5000;

    }

    public function getTimeParked($time) {
        //convertion into an hr
        $timeArr = explode(':', $time);
        $decTime = ($timeArr[1]) + ($timeArr[2]/60) + ($timeArr[3]/3600);
        return $this->roundUp($decTime);
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
