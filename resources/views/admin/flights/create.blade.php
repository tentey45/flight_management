@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white mb-0 font-heading">Add New Flight</h2>
            <a href="{{ route('admin.flights.index') }}" class="btn btn-outline-light btn-sm">← Back to Flights</a>
        </div>

        <div class="glass-card p-4">
            <form action="{{ route('admin.flights.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Flight Number</label>
                        <input type="text" name="flight_number" class="form-control @error('flight_number') is-invalid @enderror" value="{{ old('flight_number') }}" placeholder="e.g. JL-006" required>
                        @error('flight_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Departure Location</label>
                        <input type="text" name="departure_location" class="form-control @error('departure_location') is-invalid @enderror" value="{{ old('departure_location') }}" placeholder="e.g. Tokyo (NRT)" required>
                        @error('departure_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Destination</label>
                        <input type="text" name="destination" class="form-control @error('destination') is-invalid @enderror" value="{{ old('destination') }}" placeholder="e.g. New York (JFK)" required>
                        @error('destination') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted">Departure Time</label>
                        <input type="datetime-local" name="departure_time" class="form-control @error('departure_time') is-invalid @enderror" value="{{ old('departure_time') }}" required>
                        @error('departure_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label text-muted">Arrival Time</label>
                        <input type="datetime-local" name="arrival_time" class="form-control @error('arrival_time') is-invalid @enderror" value="{{ old('arrival_time') }}" required>
                        @error('arrival_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-glow w-100 py-2">Create Flight</button>
            </form>
        </div>
    </div>
</div>
@endsection
