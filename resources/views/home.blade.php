@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Sales</span>
                        <h3 class="card-title mb-2">P {{ number_format($sales, 2)  }} </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
