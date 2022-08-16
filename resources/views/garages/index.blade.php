@extends('layouts.app')

@section('page-title')
    Garages
@endsection

@section('page-action-button')
    <div class="text-center">
        <button class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addGarage">
            <i class='bx bx-plus bx-sm'></i>&nbsp;Add Garage
        </button>
    </div>
@endsection

@section('content')
    <div class="row mb-5">
        @foreach ($garages as $garage)
            <div class="col-6">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img class="card-img card-img-left" src="../assets/img/elements/12.jpg" alt="Card image" />
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                    <div class="input-group mb-3" style="display: none" id="editGarageNameInput_{{ $garage->id }}">
                                        <input type="text" class="form-control" value="{{ $garage->name }}" id="newGaragename_{{ $garage->id  }}"/>
                                        <button class="btn btn-outline-primary" type="submit" onclick="updategarageName('{{ route('garages.updateName', $garage) }}', 'editGarageNameInput_{{ $garage->id }}', 'garageTitle', '{{ $garage->id }}')">Save</button>
                                            <button class="btn btn-secondary" type="button"
                                            onclick="cancelEditGarageTitle('editGarageNameInput_{{ $garage->id }}', 'garageTitle', '{{ $garage->id }}')">Cancel</button>
                                    </div>
                                <div class="d-flex justify-content-between mb-3 " style="display: block">
                                        <h5 class="card-title" id="garageTitleValue_{{ $garage->id }}">{{ $garage->name }}</h5>
                                        <div class="col-lg-3 col-sm-6 col-12 garageTitle">
                                            <div class="btn-group">
                                                <button type="button"
                                                    class="btn btn-primary btn-icon rounded-pill dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="editGarageName('editGarageNameInput_{{ $garage->id }}', 'garageTitle', '{{ $garage->id }}')">Edit Garage Name</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                </div>
                                <ul>
                                    <li>Occupied : #</li>
                                    <li>Unoccupied : #</li>
                                </ul>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('page-modals')
    {{-- Add Garage --}}
    <div class="modal fade" id="addGarage" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <form action="{{ route('garages.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">New Garage</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name" />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" id="location" name="location"
                                    class="form-control @error('location') is-invalid @enderror"
                                    placeholder="Enter Location" />
                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <h5 class="text-muted">Number of slot/s to be created per type</h5>
                        <div class="row mb-3">
                            <div class="d-flex">
                                <label for="" class="col-sm-4 col-form-label">Large Vehicle</label>
                                <div class="col-sm-4"><input type="number" min="10" max="500"
                                        class="form-control @error('lg') is-invalid @enderror" name="lg" /></div>
                                @error('lg')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="d-flex">
                                <h4 for="" class="col-sm-4 form-label">Meduim Vehicle</h4>
                                <div class="col-sm-4"><input type="text" min="1" max="500"
                                        class="form-control @error('md') is-invalid @enderror" name="md" /></div>
                                @error('md')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="d-flex">
                                <h4 for="" class="col-sm-4 form-label">Small Vehicle</h4>
                                <div class="col-sm-4"><input type="text" min="10" max="500"
                                        class="form-control @error('sm') is-invalid @enderror" name="sm" /></div>
                                @error('sm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast with Placements -->
    <div class="bs-toast toast toast-placement-ex m-2 top-0 end-0 " role="alert" aria-live="assertive"
        aria-atomic="true" data-delay="2000" id="successToast">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">System Update !</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastDescription">Description Toast</div>
    </div>
    <!-- Toast with Placements -->
@endsection


@section('page-scripts')
    <script>
        function editGarageName(divId, divClass, titleId) {

            const x = document.getElementById(divId);
            x.style.display = "block";
            x.classList.add("d-flex");

            const ys = document.getElementsByClassName(divClass);

            for (const y of ys) {
                y.style.display = 'none';
                y.classList.remove("d-flex");
            }

            const z = document.getElementById('garageTitleValue_' + titleId);
            z.style.display = 'none';
        }

        function cancelEditGarageTitle(divId, divClass, titleId) {
            const x = document.getElementById(divId);
            x.style.display = "none";
            x.classList.remove("d-flex");

            const ys = document.getElementsByClassName(divClass);

            for (const y of ys) {
                y.style.display = 'display';
                y.classList.add("d-flex");
            }

            const z = document.getElementById('garageTitleValue_' + titleId);
            z.style.display = 'block';
        }

        function updategarageName(route, divId, divClass, titleId) {
            $.ajax({
               type:'POST',
               url: route,
               data:{
                    _token: '{{ csrf_token() }}',
                    name: document.getElementById('newGaragename_' + titleId).value,
                },
               success: function(data) {
                const toast = document.querySelector('#successToast')
                toast.classList.remove('bg-danger');

                toastFunction('bg-success', data.message);

                const garageTitleValue = document.querySelector('#garageTitleValue_' + titleId)
                garageTitleValue.textContent = document.getElementById('newGaragename_' + titleId).value;

                cancelEditGarageTitle(divId, divClass, titleId);

               },
               error: function(request, status, error){
                const toast = document.querySelector('#successToast')
                toast.classList.remove('bg-success');

                toastFunction('bg-danger', request.responseJSON.message)
               }
            });
        }

        function toastFunction(result, message) {
            const toast = document.querySelector('#successToast')
            toast.classList.add(result);

            const toastDescription = document.querySelector('#toastDescription')
            toastDescription.textContent = message;

            toastPlacement = new bootstrap.Toast(toast);
            toastPlacement.show();
        }

        $(document).ready(function() {

            @if (Session::get('result'))
                let result;
                @switch(Session::get('result'))
                    @case('success')
                    result = 'bg-success';
                    @break

                    @case('warning')
                    result = 'bg-warning';
                    @break

                    @case('info')
                    result = 'bg-info';
                    @break

                    @default
                    result = 'bg-danger';
                    @break
                @endswitch

                toastFunction(result, '{{ Session::get('message') }}');
            @endif






            @if (count($errors) > 0)
                $('#addGarage').modal('show');
            @endif





    });
    </script>
@endsection
