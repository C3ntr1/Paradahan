<?php

namespace App\Repository\Eloquent;

use App\Models\Customer;
use App\Repository\EloquentRepositoryInterface;

class CustomerRepository extends BaseRepository implements EloquentRepositoryInterface {

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

}
