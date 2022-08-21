@extends('layouts.app')

@section('page-title')
    Exit Vehicle
@endsection

@section('content')
<div lass="col-md-12">
    <div class="card mb-4">
        <div class="card-body">
            @if (!$vehicle)
                No Vehicle Found.
            @else

                <h5 class="card-title">Information Form</h5>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="plate_number" class="form-label">Plate No.</label>
                        <h4 id="plate_no_value">{{ $plate_no }}</h4>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name"
                            value="{{ old('name', $vehicle ? $vehicle->customer->name : '') }}" disabled />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="mobile_number" class="form-label">Mobile No</label>
                        <input type="text" id="name" name="mobile_number"
                            class="form-control @error('mobile_number') is-invalid @enderror"
                            placeholder="Enter Mobile No."
                            value="{{ old('mobile_number', $vehicle ? $vehicle->customer->mobile_number : '') }}" disabled />
                        @error('mobile_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">

                    <div class="col-6">
                        <label for="name" class="form-label">Vehicle Type</label>
                        <select name="type" id="type" class="form-control" disabled>
                            <option value="">-- Select Vehicle Type --</option>
                            <option value="Small"
                                {{ $vehicle ? ($vehicle->customer->type === 'Small' ? 'selected' : '') : '' }}>Small
                            </option>
                            <option value="Medium"
                                {{ $vehicle ? ($vehicle->customer->type === 'Medium' ? 'selected' : '') : '' }}>Medium
                            </option>
                            <option value="Large"
                                {{ $vehicle ? ($vehicle->customer->type === 'Large' ? 'selected' : '') : '' }}>Large
                            </option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label for="name" class="form-label">Garage</label>
                        <select name="garage_id" id="garage_id" class="form-control" disabled>
                            <option value="">-- Select Garage --</option>
                            @foreach ($garages as $garage)
                                <option value="{{ $garage->id }}"
                                    {{ $vehicle ? ($vehicle->slot->garage_id === $garage->id ? 'selected' : '') : '' }}>
                                    {{ $garage->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="name" class="form-label">Enter At</label>
                        <h4 id="plate_no_value" class="text-success">{{ $vehicle->formatted_enter_at }}</h4>
                    </div>
                    <div class="col-6">
                        <label for="name" class="form-label">About</label>
                        <h4 id="plate_no_value" class="text-success">{{ $vehicle->enter_at->diffForHumans() }}</h4>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="name" class="form-label">Tentative Fee</label>
                        <h4 id="plate_no_value" class="text-info">P&nbsp;{{ number_format($fee, 2) }}</h4>
                    </div>
                </div>
                <div class="d-flex justify-content-end just">
                    <div class="justify-content-between">
                        <a href="{{ route('parkings.index') }}" class="btn btn-secondary">Got to List</a>
                        <button type="button" onclick="confirmDelete()" class="btn btn-danger">Exit</button>
                        <form id="exitVehicleFrm"
                            action="{{ route('parkings.exit', [
                                        'plate_no' => $plate_no,
                                        'parking_type' => $parking_type === 'Continuous Rate' ? 'Continuous Rate' : 'Regular Rate'
                                    ]) }}"
                            method="POST">
                            @csrf
                        </form>
                    </div>
                </div>

            @endif

        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete() {
            Swal.fire({
                title: 'A vehicle is about to exit.',
                text: "Please confirm this action.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('exitVehicleFrm').submit()
                }
            })
        }
</script>
@endsection
