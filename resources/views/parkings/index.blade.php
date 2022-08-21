@extends('layouts.app')

@section('page-title')
    Vehicle
@endsection

@section('page-action-button')
    {{-- <div class="text-center">
        <a href="{{ route('parkings.enterPage') }}" class="btn btn-outline-primary btn-lg">
            <i class='bx bx-plus bx-sm'></i>&nbsp;Park Vehicle
        </a>
    </div> --}}
@endsection

@section('content')
    <div class="row mb-5">
        <div class="card">
            <h5 class="card-header">Parking List <span class="badge rounded-pill bg-primary"></span></h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Plate No.</th>
                            <th>Garage</th>
                            <th>Slot</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($parking_logs as $parking_log)
                            <tr>
                                <td>{{ $parking_log->customer->plate_number }}</td>
                                <td>{{ $parking_log->slot->garage->name }}</td>
                                <td>{{ $parking_log->slot->name }}</td>
                                <td>Action</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="d-flex justify-content-end">
                </div>
            </div>
        </div>
    </div>
@endsection
