<?php

namespace App\Repository\Eloquent;

use App\Models\Transaction;
use App\Repository\EloquentRepositoryInterface;

class TransactionRepository extends BaseRepository implements EloquentRepositoryInterface {

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function sales()
    {
        return $this->model->totalSales();
    }

}
