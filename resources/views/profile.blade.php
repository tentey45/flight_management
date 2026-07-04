@extends('layouts.app')

@section('content')

<div class="row">
    <!-- Profile sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <div style="width:70px;height:70px;border-radius:50%;background:#1d4ed8;color:#fff;font-size:1.8rem;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-2" style="font-size:0.85rem;">{{ $user->email }}</p>
                @if($user->isAdmin())
                    <span class="badge bg-danger">Administrator</span>
                @else
                    <span class="badge bg-primary">Passenger</span>
                @endif
                <hr>
                <div class="d-flex justify-content-between text-muted small">
                    <span>Total Bookings:</span>
                    <strong class="text-dark">{{ $bookings->count() }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets -->
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">My Boarding Passes & Tickets</h4>
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary">+ Book Another Flight</a>
        </div>

        @if($bookings->isEmpty())
            <div class="card text-center p-5">
                <div class="text-muted mb-2" style="font-size:2.5rem;">🎫</div>
                <h5>No tickets yet</h5>
                <p class="text-muted">You haven't booked any flights. Start searching now!</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm mx-auto" style="width:fit-content">Search Flights</a>
            </div>
        @else
            @foreach($bookings as $booking)
                @php
                    preg_match('/\((.*?)\)/', $booking->flight->departure_location, $dCode);
                    preg_match('/\((.*?)\)/', $booking->flight->destination, $aCode);
                    $depCode = $dCode[1] ?? 'DEP';
                    $arrCode = $aCode[1] ?? 'ARR';
                    $depCity = trim(preg_replace('/\s*\(.*?\)/', '', $booking->flight->departure_location));
                    $arrCity = trim(preg_replace('/\s*\(.*?\)/', '', $booking->flight->destination));
                @endphp
                <div class="ticket-card mb-4">
                    <!-- Main body -->
                    <div class="ticket-body">
                        <!-- Top row -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary" style="font-size:0.85rem; padding:0.4rem 0.8rem;">
                                ✈ {{ $booking->flight->flight_number }}
                            </span>
                            <span class="status-badge status-{{ strtolower($booking->status) }}">
                                {{ $booking->status }}
                            </span>
                        </div>

                        <!-- Route -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-center" style="min-width:90px;">
                                <div class="airport-code">{{ $depCode }}</div>
                                <div class="airport-name">{{ $depCity }}</div>
                                <div class="flight-time-val">{{ $booking->flight->departure_time->format('H:i') }}</div>
                                <div class="text-muted" style="font-size:0.72rem;">{{ $booking->flight->departure_time->format('D, M d Y') }}</div>
                            </div>
                            <div class="flex-grow-1 text-center px-3">
                                <div class="text-primary fw-bold" style="font-size:1.3rem;">→</div>
                                <div class="text-muted" style="font-size:0.72rem;">Direct</div>
                            </div>
                            <div class="text-center" style="min-width:90px;">
                                <div class="airport-code">{{ $arrCode }}</div>
                                <div class="airport-name">{{ $arrCity }}</div>
                                <div class="flight-time-val">{{ $booking->flight->arrival_time->format('H:i') }}</div>
                                <div class="text-muted" style="font-size:0.72rem;">{{ $booking->flight->arrival_time->format('D, M d Y') }}</div>
                            </div>
                        </div>

                        <!-- Passenger info -->
                        <div class="row border-top pt-3 mt-2">
                            <div class="col-3">
                                <div class="text-muted" style="font-size:0.72rem; text-transform:uppercase; font-weight:600;">Passenger</div>
                                <div style="font-size:0.9rem; font-weight:600;">{{ $user->name }}</div>
                            </div>
                            <div class="col-3">
                                <div class="text-muted" style="font-size:0.72rem; text-transform:uppercase; font-weight:600;">Class</div>
                                <div style="font-size:0.9rem; font-weight:600;">{{ $booking->class }}</div>
                            </div>
                            <div class="col-3">
                                <div class="text-muted" style="font-size:0.72rem; text-transform:uppercase; font-weight:600;">Seat</div>
                                <div style="font-size:0.9rem; font-weight:600; color:#059669;">{{ $booking->seat_number ?? 'Not Selected' }}</div>
                            </div>
                            <div class="col-3">
                                <div class="text-muted" style="font-size:0.72rem; text-transform:uppercase; font-weight:600;">Booked On</div>
                                <div style="font-size:0.9rem; font-weight:600;">{{ $booking->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Stub -->
                    <div class="ticket-stub">
                        <div class="text-muted mb-1" style="font-size:0.68rem; text-transform:uppercase; font-weight:700; letter-spacing:0.06em;">Boarding Pass</div>
                        <div class="ticket-number mb-3">{{ $booking->ticket_number }}</div>
                        <div class="barcode-wrap mb-2">
                            @for($i = 0; $i < 20; $i++)
                                <div class="barcode-bar"></div>
                            @endfor
                        </div>
                        <div class="text-muted" style="font-size:0.68rem;">{{ $booking->ticket_number }}</div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@endsection
