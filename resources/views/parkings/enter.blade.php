@extends('layouts.app')

@section('page-title')
    Park Vehicle
@endsection

@section('content')
    <div lass="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('parkings.enter') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5 class="card-title">Information Form</h5>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="plate_number" class="form-label">Plate No.</label>
                            <h4 id="plate_no_value">{{ $plate_no }}</h4>
                            <input type="hidden" name="plate_number" value="{{ $plate_no }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name"
                                value="{{ old('name', $vehicle ? $vehicle->customer->name : '') }}" />
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
                                value="{{ old('mobile_number', $vehicle ? $vehicle->customer->mobile_number : '') }}" />
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
                            <select name="type" id="type" class="form-control">
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
                            <select name="garage_id" id="garage_id" class="form-control">
                                <option value="">-- Select Garage --</option>
                                @foreach ($garages as $garage)
                                    <option value="{{ $garage->id }}"
                                        {{ $vehicle ? ($vehicle->slot->garage_id === $garage->id ? 'selected' : '') : '' }}>
                                        {{ $garage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end just">
                        <div class="justify-content-between">
                            <a href="{{ route('parkings.index') }}" class="btn btn-secondary">Got to List</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')

    <script>

        function spinnerShow() {
            const textButton = document.getElementById('textButton');
            textButton.style.display = "none";

            const checkSpinner = document.getElementById('checkSpinner');
            checkSpinner.style.display = "block";
        }

        function spinnerHide() {
            const textButton = document.getElementById('textButton');
            textButton.style.display = "block";

            const checkSpinner = document.getElementById('checkSpinner');
            checkSpinner.style.display = "none";
        }

        function searchVehicle() {


            const plate_no = document.getElementById('plate_no').value;

            if (plate_no.trim()) {
                spinnerShow();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('parkings.checkVehicle') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        plate_no: plate_no.trim(),
                    },
                    success: function(data) {

                        console.log(data.nodatafound);
                    },
                    error: function(request, status, error) {

                    },
                    complete: function(data) {
                        spinnerHide();
                    }
                });
            } else {
                alert('Please input some data.')
            }

        }
    </script>
@endsection
