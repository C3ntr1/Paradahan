<?php

namespace App\Repository\Eloquent;

use App\Models\Slot;
use App\Repository\EloquentRepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

class SlotRepository extends BaseRepository implements EloquentRepositoryInterface {

    public function __construct(Slot $slot)
    {
        $this->model = $slot;
    }

    public function queryBuilder(
        $paginate = 5,
        $garage_id
        )
    {
        return QueryBuilder::for($this->model)
        ->where('garage_id', $garage_id)
        ->latest()
        ->paginate($paginate);
    }

    public function getVacantSlot($garage_id, $type)
    {
        $slot = $this->model
        ->where([['status', true], ['garage_id', $garage_id]])
        ->whereHas('slot_type', function($query) use ($type){
            $query->where('name', $type);
        })->first();

        $slot->status = false;
        $slot->save();

        return $slot;
    }
}
