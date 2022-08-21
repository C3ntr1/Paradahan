@extends('layouts.app')

@section('page-title')
    Transaction Complete
@endsection

@section('content')
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <div class="text-center">
                    <h3 class="text-primary">Thank you!.</h3>
                    <div class="form-group">
                        <label>Customer Name</label>
                        <h3>{{ $exit_data->customer->name }}</h3>
                    </div>
                    <div class="form-group">
                        <label>Garage</label>
                        <h3>{{ $exit_data->slot->garage->name }}</h3>
                    </div>
                    <div class="form-group">
                        <label>Slot</label>
                        <h3 class="text-info">{{ $exit_data->slot->name }}</h3>
                    </div><div class="form-group">
                        <label>Enter at</label>
                        <h3>{{ $exit_data->formatted_enter_at }}</h3>
                    </div>
                    <div class="form-group">
                        <label>Exit at</label>
                        <h3>{{ $exit_data->formatted_exit_at }}</h3>
                    </div>
                    <div class="form-group">
                        <label>Parking Fee</label>
                        <h3 >P&nbsp;<span class="text-warning">{{ number_format($fee, 2) }}</span></h3>
                    </div>
                    <a href="{{ route('parkings.index') }}" class="btn btn-primary btn-lg">Parking List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
