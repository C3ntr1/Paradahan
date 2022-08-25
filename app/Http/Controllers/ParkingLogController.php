<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingLog\EnterRequest;
use App\Models\Garage;
use App\Models\ParkingLog;
use App\Repository\Eloquent\CustomerRepository;
use App\Repository\Eloquent\ParkingLogRepository;
use App\Repository\Eloquent\SlotRepository;
use App\Repository\Eloquent\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ParkingLogController extends Controller
{
    public function __construct(
        private TransactionRepository $transactionRepository,
        private ParkingLogRepository $parkingLogRepository,
        private CustomerRepository $customerRepository,
        private SlotRepository $slotRepository,
        )
    {
        $this->parkingLogRepository = $parkingLogRepository;
        $this->customerRepository = $customerRepository;
        $this->slotRepository = $slotRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        $parking_logs =  $this->parkingLogRepository->queryBuidler();
        return view('parkings.index', compact('parking_logs'));
    }
    public function enter(EnterRequest $request)
    {
        try {
            \DB::beginTransaction();

            $slot = $this->slotRepository->getVacantSlot($request->garage_id, $request->type);

            if (!$slot) {
                \DB::rollback();
                return view('parkings.not_available_slot');
            }

            $customer = $this->customerRepository->checkVehicleExist($request->plate_number);

            if (!$customer) {
                $customer = $this->customerRepository->create($request->validated());
            }

            if ($request->parking_type === 'Regular Rate') {
                $enter_at = now();
            } else {
                $enter_at = $this->parkingLogRepository->getVehicle($request->plate_number)->exit_at;  // get the last exit on previous parking log
            }

            $data = [
                'slot_id' => $slot->id,
                'customer_id' => $customer->id,
                'enter_at' => $enter_at,
            ];
            $this->parkingLogRepository->create($data);

            \DB::commit();

            return redirect()->route('parkings.index');

        } catch (\Throwable $th) {
            \DB::rollback();
            return $th->getMessage();
        }
    }

    public function exit(Request $request)
    {
        try {
            \DB::beginTransaction();

            $plate_no = $request->plate_no;
            $parking_type = $request->parking_type;

            $vehicle = $this->parkingLogRepository->getVehicle($plate_no);
            $exit_data = $this->parkingLogRepository->exitVehicle($vehicle);
            $fee = $this->parkingLogRepository->computeFee($vehicle, $parking_type, $exit_data->exit_at);

            $data = [
                'customer_id' => $vehicle->customer->id,
                'parking_log_id' => $vehicle->id,
                'fees' => $fee,
            ];

            $this->transactionRepository->create($data);

            \DB::commit();

            return view('parkings.complete', compact('exit_data', 'fee'));

        } catch (\Throwable $th) {
            \DB::rollback();
            return $th->getMessage();
        }
    }

    public function checkVehicle(Request $request)
    {
        try {
            $plate_no = $request->plate_no;
            $rate_type = $request->rate_type;

            $garages = App::make(Garage::class)->all();
            $parking_type = $this->parkingLogRepository->checkParkingType($plate_no);


            if ($request->has('for_exit')) {
                $vehicle = $this->parkingLogRepository->getVehicleEntered($plate_no);
                if (!$vehicle) {
                    return view('parkings.not_found');
                }
                $fee = $this->parkingLogRepository->computeFee($vehicle, $parking_type);
                return view('parkings.exit', compact('vehicle', 'garages', 'plate_no', 'fee', 'parking_type'));
            }

            $vehicle = $this->parkingLogRepository->getVehicle($plate_no);

            if ($vehicle) {
                if ($vehicle->exit_at == null) {
                    return view('parkings.already_parked', compact('vehicle'));
                }
            }

            return view('parkings.enter', compact('vehicle', 'garages', 'plate_no' ,'parking_type'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

}
