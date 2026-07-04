@extends('layouts.app')

@section('content')

<!-- Hero search bar -->
<div class="card mb-4">
    <div class="card-header-blue">
        ✈ Search Available Flights
    </div>
    <div class="card-body p-4">
        <form action="{{ route('home') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">From (Departure)</label>
                    <input type="text" name="departure" class="form-control" value="{{ $departure }}" list="dep-list" placeholder="e.g. Tokyo, London">
                    <datalist id="dep-list">
                        @foreach($allDepartures as $d)
                            <option value="{{ $d }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-3">
                    <label class="form-label">To (Destination)</label>
                    <input type="text" name="destination" class="form-control" value="{{ $destination }}" list="dst-list" placeholder="e.g. Paris, New York">
                    <datalist id="dst-list">
                        @foreach($allDestinations as $d)
                            <option value="{{ $d }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Departure Date</label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Search Flights</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Results -->
<h5 class="mb-3 text-muted">
    @if($departure || $destination || $date)
        Search Results — {{ $flights->count() }} flight(s) found
    @else
        All Available Flights ({{ $flights->count() }})
    @endif
</h5>

@if($flights->isEmpty())
    <div class="card text-center p-5">
        <div class="text-muted mb-2" style="font-size:2.5rem;">🔍</div>
        <h5>No flights found</h5>
        <p class="text-muted">Try different departure, destination, or date.</p>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm mx-auto" style="width:fit-content">Clear Search</a>
    </div>
@else
    <div class="row g-3">
        @foreach($flights as $flight)
            @php
                preg_match('/\((.*?)\)/', $flight->departure_location, $dCode);
                preg_match('/\((.*?)\)/', $flight->destination, $aCode);
                $depCode = $dCode[1] ?? 'DEP';
                $arrCode = $aCode[1] ?? 'ARR';
                $depCity = trim(preg_replace('/\s*\(.*?\)/', '', $flight->departure_location));
                $arrCity = trim(preg_replace('/\s*\(.*?\)/', '', $flight->destination));
            @endphp
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <!-- Header row -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary" style="font-size:0.85rem; padding:0.4rem 0.8rem;">
                                ✈ {{ $flight->flight_number }}
                            </span>
                            <span class="text-muted small">Direct Flight</span>
                        </div>

                        <!-- Route row -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="text-center">
                                <div class="airport-code">{{ $depCode }}</div>
                                <div class="airport-name">{{ $depCity }}</div>
                                <div class="flight-time-val">{{ $flight->departure_time->format('H:i') }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">{{ $flight->departure_time->format('D, M d') }}</div>
                            </div>
                            <div class="route-arrow flex-grow-1 mx-2">
                                <div class="text-center">→</div>
                                <div class="text-center text-muted" style="font-size:0.72rem;">Direct</div>
                            </div>
                            <div class="text-center">
                                <div class="airport-code">{{ $arrCode }}</div>
                                <div class="airport-name">{{ $arrCity }}</div>
                                <div class="flight-time-val">{{ $flight->arrival_time->format('H:i') }}</div>
                                <div class="text-muted" style="font-size:0.75rem;">{{ $flight->arrival_time->format('D, M d') }}</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <div>
                                <div class="text-muted" style="font-size:0.75rem;">ONE-WAY FARE FROM</div>
                                <div class="fw-bold text-primary" style="font-size:1.1rem;">$299.00</div>
                            </div>
                            @auth
                                <a href="{{ route('flights.select', $flight->id) }}" class="btn btn-primary px-4">
                                    Select Flight →
                                </a>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-outline-primary px-4">Login to Book</a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
