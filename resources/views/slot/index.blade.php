@extends('layouts.app')

@section('page-title')
    Slots
@endsection

@section('page-action-button')
    <div class="text-center">
        <button class="btn btn-outline-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addGarage">
            <i class='bx bx-plus bx-sm'></i>&nbsp;Add Slot
        </button>
    </div>
@endsection

@section('content')
    <div class="row mb-5">
        <div class="card">
            <h5 class="card-header">Garage: <span class="badge rounded-pill bg-primary">{{ $garage_name }}</span></h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Slot Name</th>
                            <th>Status</th>
                            <th>Plat No</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($slots as $slot)
                            <tr>
                                <td>{{ $slot->name }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $slot->status ? 'secondary' : 'success' }}">
                                        {{ $slot->status ? 'Unoccupied' : 'Occupied' }}
                                    </span>

                                </td>
                                <td>{{ $slot->status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-edit-alt me-2"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-trash me-2"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="d-flex justify-content-end">
                    {{ $slots->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
