<?php

namespace App\Repository\Eloquent;

use App\Models\Garage;
use App\Models\Slot;
use App\Models\SlotType;

class GarageRepository extends BaseRepository {

    public function __construct(Garage $garage)
    {
        $this->model = $garage;
    }

    public function addSlot(Garage $garage, $type, $slot)
    {
        $slot_type = SlotType::where('name', $type)->first();

        for ($i=0; $i < $slot ; $i++) {

            $latest_id = Slot::max('id') == null ? 0 : Slot::max('id');

            $parking_slot = new Slot();
            $parking_slot->name = strtoupper($garage->name . ' - ' . mb_substr($garage->name, 0, 1)) . $latest_id;
            $parking_slot->garage_id = $garage->id;
            $parking_slot->slot_type_id = $slot_type->id;
            $parking_slot->save();
        }
    }

}
