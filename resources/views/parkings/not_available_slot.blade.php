@extends('layouts.app')

@section('page-title')
    Not Available Slot
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <h3 class="card-title">No avalable slot on selected garage with selected vehicle type...</h3>
                        <a href="{{ route('parkings.index') }}" class="btn btn-primary btn-lg">Parking List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
