<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use App\Repository\Eloquent\SlotRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SlotController extends Controller
{

    public function __construct(private SlotRepository $slotRepository)
    {
        $this->slotRepository = $slotRepository;
    }
    public function index($garage_id)
    {
        try {
            $garage_name = App::make(Garage::class)->findOrFail($garage_id)->name;
            $slots = $this->slotRepository->queryBuilder(5, $garage_id);
            return view('slot.index', compact('slots', 'garage_name'));
        } catch (\Throwable $th) {
            return 'No Data Found';
        }

    }

    public function store(){

    }

    public function show(){

    }

    public function update(){

    }

    public function destroy(){

    }
}
