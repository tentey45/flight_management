@extends('layouts.app')

@section('content')
<div class="hero-section text-center py-5 mb-5">
    <h1 class="display-4 text-white fw-bold font-heading text-glow mb-2">Find Your Next Destination</h1>
    <p class="text-muted lead">Search and book flights across global destinations instantly.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-11">
        <!-- Search Card -->
        <div class="glass-card p-4 mb-5">
            <form action="{{ route('home') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label text-muted">From</label>
                        <input type="text" name="departure" class="form-control" list="departures" value="{{ $departure }}" placeholder="Departure City or Airport">
                        <datalist id="departures">
                            @foreach($allDepartures as $dep)
                                <option value="{{ $dep }}">
                            @endforeach
                        </datalist>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label text-muted">To</label>
                        <input type="text" name="destination" class="form-control" list="destinations" value="{{ $destination }}" placeholder="Destination City or Airport">
                        <datalist id="destinations">
                            @foreach($allDestinations as $dest)
                                <option value="{{ $dest }}">
                            @endforeach
                        </datalist>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label text-muted">Departure Date</label>
                        <input type="date" name="date" class="form-control" value="{{ $date }}">
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-glow w-100 py-2">Search Flights</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Flights List -->
        <h3 class="text-white mb-4">Available Flights</h3>

        @if($flights->isEmpty())
            <div class="glass-card p-5 text-center">
                <h5 class="text-white">No flights found</h5>
                <p class="text-muted">Try adjusting your locations or search terms.</p>
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light">Reset Search</a>
            </div>
        @else
            <div class="row">
                @foreach($flights as $flight)
                    <div class="col-md-6 mb-4">
                        <div class="flight-search-card glass-card p-4 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="flight-tag py-1 px-2 rounded-2">✈ {{ $flight->flight_number }}</span>
                                    <span class="text-muted small">Daily Flight</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center my-4">
                                    <div class="route-point">
                                        @php
                                            preg_match('/\((.*?)\)/', $flight->departure_location, $depCode);
                                            $depAirportCode = isset($depCode[1]) ? $depCode[1] : 'DEP';
                                            $depName = trim(preg_replace('/\s*\(.*?\)\s*/', '', $flight->departure_location));

                                            preg_match('/\((.*?)\)/', $flight->destination, $dstCode);
                                            $dstAirportCode = isset($dstCode[1]) ? $dstCode[1] : 'DST';
                                            $dstName = trim(preg_replace('/\s*\(.*?\)\s*/', '', $flight->destination));
                                        @endphp
                                        <div class="airport-code fs-4">{{ $depAirportCode }}</div>
                                        <div class="airport-name text-muted">{{ $depName }}</div>
                                        <div class="flight-time text-white">{{ $flight->departure_time->format('H:i') }}</div>
                                        <div class="flight-date text-muted small">{{ $flight->departure_time->format('D, M d') }}</div>
                                    </div>
                                    
                                    <div class="route-connector text-center flex-grow-1 mx-3">
                                        <div class="plane-line">
                                            <span class="plane-mini">✈</span>
                                        </div>
                                        <span class="duration-badge text-muted">Direct</span>
                                    </div>
                                    
                                    <div class="route-point text-end">
                                        <div class="airport-code fs-4">{{ $dstAirportCode }}</div>
                                        <div class="airport-name text-muted">{{ $dstName }}</div>
                                        <div class="flight-time text-white">{{ $flight->arrival_time->format('H:i') }}</div>
                                        <div class="flight-date text-muted small">{{ $flight->arrival_time->format('D, M d') }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 border-top border-secondary d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <small class="text-muted d-block">Price (One-Way)</small>
                                    <span class="fs-5 text-white fw-bold">$299.00</span>
                                </div>
                                
                                <form action="{{ route('flights.book', $flight->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-glow btn-sm px-4">Book Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
