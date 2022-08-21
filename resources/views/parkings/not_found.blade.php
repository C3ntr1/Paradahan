@extends('layouts.app')

@section('page-title')
    Not Found
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="text-center">
                        <h3 class="card-title">Vehicle Not Found...</h3>
                        <a href="{{ route('parkings.index') }}" class="btn btn-primary btn-lg">Parking List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
