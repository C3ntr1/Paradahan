<?php

namespace App\Http\Controllers;

use App\Http\Requests\Garage\StoreRequest;
use App\Http\Requests\Garage\UpdateNameRequest;
use App\Http\Requests\Garage\UpdateRequest;
use App\Models\Garage;
use App\Repository\Eloquent\GarageRepository;
use Illuminate\Http\Request;

class GarageController extends Controller
{
    public function __construct(private GarageRepository $garageRepository)
    {
        $this->garageRepository = $garageRepository;
    }
    public function index()
    {
        $garages= $this->garageRepository->all();
        return view('garages.index', compact('garages'));
    }

    public function store(StoreRequest $request)
    {
        try {
            \DB::beginTransaction();
            $garage = $this->garageRepository->create($request->validated());

            if($request->lg > 0){
                $this->garageRepository->addSlot($garage, 'Large', $request->lg);
            }

            if($request->md > 0){
                $this->garageRepository->addSlot($garage, 'Medium', $request->md);
            }

            if($request->sm > 0){
                $this->garageRepository->addSlot($garage, 'Small', $request->sm);
            }

            \DB::commit();

            return redirect()->back()->with(['result'=> 'success' ,'message' => 'Garage created successfully.']);
        } catch (\Throwable $th) {
            \DB::rollback();
            return redirect()->back()->with(['result'=> 'error' ,'message' => $th->getMessage()]);
        }
    }

    public function show()
    {
        # code...
    }

    public function update(Garage $garage, UpdateRequest $request)
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function updateName($id, UpdateNameRequest $request)
    {
        try {
            $this->garageRepository->update($id, $request->validated());
            return response()->json(['result'=> 'success' ,'message' => 'Garage updated successfully.'], 200);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['result'=> 'error' ,'message' => $th->getMessage()]);
        }
    }

    public function destroy()
    {
        # code...
    }
}
