@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <!-- Step Indicator -->
        <div class="d-flex justify-content-between mb-4 border-bottom pb-2">
            <span class="text-muted">1. Select Flight</span>
            <span class="text-muted">2. Class & Seat</span>
            <span class="fw-bold text-primary">3. Confirmation</span>
        </div>

        <div class="card">
            <div class="card-header-blue text-center">
                📋 Confirm Your Booking
            </div>
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4">Please review your flight details below</h5>

                <!-- Flight Route Summary -->
                <div class="p-3 mb-4 rounded bg-light border">
                    <div class="row text-center align-items-center">
                        <div class="col-5">
                            <div class="text-muted small">DEPARTURE</div>
                            <div class="fw-bold text-dark fs-6">{{ $flight->departure_location }}</div>
                            <div class="small text-muted">{{ $flight->departure_time->format('M d, Y H:i') }}</div>
                        </div>
                        <div class="col-2 text-primary fs-4">→</div>
                        <div class="col-5">
                            <div class="text-muted small">DESTINATION</div>
                            <div class="fw-bold text-dark fs-6">{{ $flight->destination }}</div>
                            <div class="small text-muted">{{ $flight->arrival_time->format('M d, Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Ticket details list -->
                <ul class="list-group mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Flight Number</span>
                        <strong class="text-primary">{{ $flight->flight_number }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Travel Class</span>
                        <strong class="text-dark">{{ $selectedClass }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Reserved Seat</span>
                        <strong class="text-success">{{ $seatNumber }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                        <span class="fw-bold">Total Fare</span>
                        <strong class="text-primary fs-5">${{ number_format($price, 2) }}</strong>
                    </li>
                </ul>

                <!-- Booking Action Form -->
                <form action="{{ route('flights.book', $flight->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="class" value="{{ $selectedClass }}">
                    <input type="hidden" name="seat_number" value="{{ $seatNumber }}">

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg py-2">Confirm & Book Flight</button>
                        <a href="{{ route('flights.select', $flight->id) }}" class="btn btn-outline-secondary">Cancel and go back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
