@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('admin.flights.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
            <h4 class="mb-0">Edit Flight — {{ $flight->flight_number }}</h4>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.flights.update', $flight->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Flight Number</label>
                        <input type="text" name="flight_number" class="form-control @error('flight_number') is-invalid @enderror"
                               value="{{ old('flight_number', $flight->flight_number) }}" required>
                        @error('flight_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Departure Location</label>
                        <input type="text" name="departure_location" class="form-control @error('departure_location') is-invalid @enderror"
                               value="{{ old('departure_location', $flight->departure_location) }}" required>
                        @error('departure_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Destination</label>
                        <input type="text" name="destination" class="form-control @error('destination') is-invalid @enderror"
                               value="{{ old('destination', $flight->destination) }}" required>
                        @error('destination') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Departure Date & Time</label>
                            <input type="datetime-local" name="departure_time" class="form-control @error('departure_time') is-invalid @enderror"
                                   value="{{ old('departure_time', $flight->departure_time->format('Y-m-d\TH:i')) }}" required>
                            @error('departure_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Arrival Date & Time</label>
                            <input type="datetime-local" name="arrival_time" class="form-control @error('arrival_time') is-invalid @enderror"
                                   value="{{ old('arrival_time', $flight->arrival_time->format('Y-m-d\TH:i')) }}" required>
                            @error('arrival_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">Update Flight</button>
                        <a href="{{ route('admin.flights.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
