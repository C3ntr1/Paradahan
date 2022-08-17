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
}
