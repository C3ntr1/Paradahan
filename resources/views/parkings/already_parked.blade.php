@extends('layouts.app')

@section('page-title')
    Parked
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <h3 class="text-primary">Vehicle was already parked.</h3>
                        <div class="form-group">
                            <label>Customer Name</label>
                            <h3>{{ $vehicle->customer->name }}</h3>
                        </div>
                        <div class="form-group">
                            <label>Garage</label>
                            <h3>{{ $vehicle->slot->garage->name }}</h3>
                        </div>
                        <div class="form-group">
                            <label>Slot</label>
                            <h3 class="text-info">{{ $vehicle->slot->name }}</h3>
                        </div><div class="form-group">
                            <label>Enter at</label>
                            <h3>{{ $vehicle->formatted_enter_at }}</h3>
                        </div>
                        <a href="{{ route('parkings.index') }}" class="btn btn-primary btn-lg">Parking List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
