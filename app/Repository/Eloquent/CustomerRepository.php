<?php

namespace App\Repository\Eloquent;

use App\Models\Customer;
use App\Repository\EloquentRepositoryInterface;

class CustomerRepository extends BaseRepository implements EloquentRepositoryInterface {

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function checkVehicleExist($plate_no)
    {
        return $this->model->where('plate_number', $plate_no)->first();
    }

}
