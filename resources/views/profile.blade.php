@extends('layouts.app')

@section('content')
<div class="profile-container py-4">
    <div class="row">
        <!-- User Profile Card -->
        <div class="col-md-4 mb-4">
            <div class="glass-card p-4">
                <div class="profile-header text-center mb-4">
                    <div class="avatar-glow mb-3">
                        <span class="avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <h3 class="profile-name mb-1 text-white">{{ $user->name }}</h3>
                    <p class="profile-email mb-0 text-muted">{{ $user->email }}</p>
                    @if($user->isAdmin())
                        <span class="badge badge-admin mt-2 d-inline-block">Administrator</span>
                    @else
                        <span class="badge badge-customer mt-2 d-inline-block">Passenger</span>
                    @endif
                </div>
                
                <div class="profile-stats border-top pt-3 border-secondary">
                    <div class="d-flex justify-content-between text-muted">
                        <span>Total Bookings:</span>
                        <span class="fw-bold text-white">{{ $bookings->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings & Tickets Column -->
        <div class="col-md-8">
            <h2 class="mb-4 text-white">Your Boarding Passes & Tickets</h2>
            
            @if($bookings->isEmpty())
                <div class="glass-card p-5 text-center">
                    <div class="mb-3 text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-airplane text-glow" viewBox="0 0 16 16">
                            <path d="M6.428 1.151C6.708.591 7.303 0 8 0s1.293.591 1.572 1.151C9.89 1.787 10.25 3.5 10.25 3.5s1.387 1.14 2.877 2.457c1.49 1.317 2.451 2.327 2.451 2.327-.014.07-.152.179-.49.264-.34.086-.889.117-1.477.107L10.25 8.5v3.5l1.625 1.125c.125.086.177.243.125.385l-.25.625a.25.25 0 0 1-.415.082L8 12.025l-3.335 2.227a.25.25 0 0 1-.415-.082l-.25-.625a.25.25 0 0 1 .125-.385L5.75 12V8.5L2.366 8.651c-.588.01-1.138-.02-1.477-.107-.338-.085-.476-.194-.49-.264 0 0 .96-1.01 2.45-2.327C4.339 4.64 5.727 3.5 5.727 3.5s.36-1.713.67-2.349zM8.5 6a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-white">No flights booked yet</h4>
                    <p class="text-muted">Start planning your next adventure today!</p>
                    <a href="{{ route('home') }}" class="btn btn-glow mt-2">Search Flights</a>
                </div>
            @else
                <div class="tickets-list">
                    @foreach($bookings as $booking)
                        <div class="ticket-card mb-4">
                            <!-- Main ticket part -->
                            <div class="ticket-main p-4">
                                <div class="ticket-header d-flex justify-content-between align-items-center mb-3">
                                    <div class="flight-tag">
                                        <span class="flight-icon">✈</span>
                                        <strong>{{ $booking->flight->flight_number }}</strong>
                                    </div>
                                    <div class="status-indicator">
                                        <span class="badge-status status-{{ strtolower($booking->status) }}">
                                            {{ $booking->status }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="ticket-route d-flex justify-content-between align-items-center my-4">
                                    <div class="route-point">
                                        @php
                                            // Extract 3 letter airport code or fallback
                                            preg_match('/\((.*?)\)/', $booking->flight->departure_location, $depCode);
                                            $depAirportCode = isset($depCode[1]) ? $depCode[1] : 'DEP';
                                            $depName = trim(preg_replace('/\s*\(.*?\)\s*/', '', $booking->flight->departure_location));

                                            preg_match('/\((.*?)\)/', $booking->flight->destination, $dstCode);
                                            $dstAirportCode = isset($dstCode[1]) ? $dstCode[1] : 'DST';
                                            $dstName = trim(preg_replace('/\s*\(.*?\)\s*/', '', $booking->flight->destination));
                                        @endphp
                                        <div class="airport-code">{{ $depAirportCode }}</div>
                                        <div class="airport-name text-muted text-truncate" style="max-width: 150px;">{{ $depName }}</div>
                                        <div class="flight-time text-white">{{ $booking->flight->departure_time->format('H:i') }}</div>
                                        <div class="flight-date text-muted">{{ $booking->flight->departure_time->format('D, M d Y') }}</div>
                                    </div>
                                    
                                    <div class="route-connector text-center flex-grow-1 mx-3">
                                        <div class="plane-line">
                                            <span class="plane-mini">✈</span>
                                        </div>
                                        <span class="duration-badge text-muted">Direct</span>
                                    </div>
                                    
                                    <div class="route-point text-end">
                                        <div class="airport-code">{{ $dstAirportCode }}</div>
                                        <div class="airport-name text-muted text-truncate" style="max-width: 150px;">{{ $dstName }}</div>
                                        <div class="flight-time text-white">{{ $booking->flight->arrival_time->format('H:i') }}</div>
                                        <div class="flight-date text-muted">{{ $booking->flight->arrival_time->format('D, M d Y') }}</div>
                                    </div>
                                </div>
                                
                                <div class="ticket-details d-flex justify-content-between pt-3 border-top border-dashed">
                                    <div>
                                        <div class="detail-label text-muted">PASSENGER</div>
                                        <div class="detail-value text-white">{{ $user->name }}</div>
                                    </div>
                                    <div>
                                        <div class="detail-label text-muted">CLASS</div>
                                        <div class="detail-value text-white">Economy</div>
                                    </div>
                                    <div>
                                        <div class="detail-label text-muted">GATE</div>
                                        <div class="detail-value text-white">B24</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Ticket stub / rip-off right part -->
                            <div class="ticket-stub p-4 text-center d-flex flex-column justify-content-between border-start border-dashed">
                                <div class="stub-top">
                                    <div class="stub-logo">BOARDING PASS</div>
                                    <div class="ticket-number-label text-muted mt-3">TICKET NUMBER</div>
                                    <div class="ticket-number-code text-white">{{ $booking->ticket_number }}</div>
                                </div>
                                
                                <div class="barcode-container mt-3">
                                    <div class="barcode">
                                        <span></span><span></span><span></span><span></span><span></span>
                                        <span></span><span></span><span></span><span></span><span></span>
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </div>
                                    <div class="barcode-text text-muted">{{ $booking->ticket_number }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
