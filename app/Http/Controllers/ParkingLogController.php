<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingLog\EnterRequest;
use App\Models\Garage;
use App\Models\ParkingLog;
use App\Repository\Eloquent\CustomerRepository;
use App\Repository\Eloquent\ParkingLogRepository;
use App\Repository\Eloquent\SlotRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ParkingLogController extends Controller
{
    public function __construct(
        private ParkingLogRepository $parkingLogRepository,
        private CustomerRepository $customerRepository,
        private SlotRepository $slotRepository,
        )
    {
        $this->parkingLogRepository = $parkingLogRepository;
        $this->customerRepository = $customerRepository;
        $this->slotRepository = $slotRepository;
    }

    public function index()
    {
        // return $this->parkingLogRepository->all();

        return view('parkings.index');
    }
    public function enter(EnterRequest $request)
    {
        try {
            \DB::beginTransaction();

            // Check the plate_no if it had alerady park within 1 hr  time frame
            // Make it continues time from the time the vehicle exit into this new exit
            // make it regular if has no prev record or not within the 1 hr time frame

            $slot_id = $this->slotRepository->getVacantSlot($request->garage_id, $request->type)->id;
            $customer_id = $this->customerRepository->create($request->validated())->id;

            $data = [
                'slot_id' => $slot_id,
                'customer_id' => $customer_id,
                'enter_at' => now(),
            ];
            $this->parkingLogRepository->create($data);

            \DB::commit();

            return redirect()->route('parkings.index');

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function exit(Request $request)
    {
        $vehicle = $this->parkingLogRepository->getVehicle($request->plate_no);
        $exit_data = $this->parkingLogRepository->exitVehicle($vehicle);
        $fee = $this->parkingLogRepository->computeFee($vehicle, $exit_data->exit_at);
        // make Condfirmation Page
        return [
            'exit_data' => $exit_data,
            'fee'   => $fee
        ];
    }

    public function checkVehicle(Request $request)
    {
        try {
        $plate_no = $request->plate_no;
        $vehicle = $this->parkingLogRepository->getVehicle($request->plate_no);
        $garages = App::make(Garage::class)->all();

        if ($request->has('for_exit') || $vehicle != null) {
            $fee = $this->parkingLogRepository->computeFee($vehicle);
            return view('parkings.exit', compact('vehicle', 'garages', 'plate_no', 'fee'));
        }

        return view('parkings.enter', compact('vehicle', 'garages', 'plate_no'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

}
