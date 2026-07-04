<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyBook — Flight Management</title>
    <meta name="description" content="Search and book flights, manage your tickets and track trip status.">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f5f7fa;
            color: #1a202c;
            font-size: 15px;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: #1d4ed8 !important;
            padding: 0.65rem 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #fff !important;
            text-decoration: none;
        }
        .nav-link { color: rgba(255,255,255,0.85) !important; font-weight: 500; }
        .nav-link:hover { color: #fff !important; }
        .btn-nav-light {
            background: #fff;
            color: #1d4ed8;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
            text-decoration: none;
            display: inline-block;
        }
        .btn-nav-light:hover { background: #e0e7ff; color: #1d4ed8; }
        .btn-nav-outline {
            background: transparent;
            color: #fff;
            font-weight: 500;
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 6px;
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
            text-decoration: none;
            display: inline-block;
        }
        .btn-nav-outline:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .user-info-nav {
            background: rgba(255,255,255,0.15);
            border-radius: 6px;
            padding: 0.3rem 0.75rem;
            color: #fff;
            font-size: 0.875rem;
        }

        /* Status bar when logged in */
        .status-bar {
            background: #dbeafe;
            border-bottom: 1px solid #bfdbfe;
            padding: 0.4rem 0;
            font-size: 0.82rem;
            color: #1e40af;
            text-align: center;
        }
        .status-bar a { color: #1d4ed8; font-weight: 600; }

        /* ── CARDS ── */
        .card { border: 1px solid #e2e8f0; border-radius: 10px; background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        .card-header-blue { background: #1d4ed8; color: #fff; border-radius: 10px 10px 0 0 !important; padding: 0.85rem 1.25rem; font-weight: 600; font-size: 1rem; }

        /* ── STATUS BADGES ── */
        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .status-booking   { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .status-confirmed { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .status-onboard   { background: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe; }
        .status-arrived   { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .status-completed { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

        /* ── BUTTONS ── */
        .btn-primary { background: #1d4ed8; border-color: #1d4ed8; font-weight: 600; }
        .btn-primary:hover { background: #1e40af; border-color: #1e40af; }
        .btn-success { background: #059669; border-color: #059669; font-weight: 600; }

        /* ── FORMS ── */
        .form-control:focus, .form-select:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(29,78,216,0.1);
        }
        .form-label { font-weight: 500; color: #374151; font-size: 0.875rem; }

        /* ── TICKET CARD ── */
        .ticket-card {
            display: flex;
            background: #fff;
            border: 2px solid #bfdbfe;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(29,78,216,0.08);
        }
        .ticket-body { flex: 3; padding: 1.5rem; border-right: 2px dashed #bfdbfe; }
        .ticket-stub { flex: 1; padding: 1.25rem; background: #eff6ff; text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: space-between; }
        .ticket-number { font-size: 0.95rem; font-weight: 700; color: #1d4ed8; letter-spacing: 0.04em; word-break: break-all; }
        .airport-code { font-size: 2rem; font-weight: 700; color: #1e3a8a; line-height: 1; }
        .airport-name { font-size: 0.78rem; color: #6b7280; }
        .flight-time-val { font-size: 1rem; font-weight: 600; color: #1a202c; margin-top: 0.25rem; }
        .route-arrow { flex: 1; text-align: center; font-size: 1.25rem; color: #1d4ed8; }
        .barcode-wrap { display: flex; gap: 2px; height: 38px; width: 90%; justify-content: center; }
        .barcode-bar { background: #1d4ed8; border-radius: 1px; opacity: 0.6; }
        .barcode-bar { width: 2px; }
        .barcode-bar:nth-child(3n) { width: 4px; opacity: 0.9; }
        .barcode-bar:nth-child(5n) { width: 1px; opacity: 0.4; }

        /* ── PAGE HEADER ── */
        .page-header { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 1.25rem 0; margin-bottom: 1.5rem; }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: #1a202c; margin: 0; }

        /* ── TABLES ── */
        .table th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; background: #f8fafc; font-weight: 600; }
        .table td { vertical-align: middle; font-size: 0.9rem; color: #374151; }

        /* ── SECTION ── */
        .section-label { font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.07em; }

        @media (max-width: 768px) {
            .ticket-card { flex-direction: column; }
            .ticket-body { border-right: none; border-bottom: 2px dashed #bfdbfe; }
        }
    </style>
</head>
<body>

<!-- ╔═══════════ NAVBAR ═══════════╗ -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">✈ SkyBook</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" style="border-color:rgba(255,255,255,0.4)">
            <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Search Flights</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile') }}">My Tickets</a>
                    </li>
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Admin Panel</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.flights.index') }}">Manage Flights</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.bookings.index') }}">Manage Bookings</a></li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right auth buttons -->
            <div class="d-flex align-items-center gap-2 mt-2 mt-lg-0">
                @guest
                    <a href="{{ route('login') }}" class="btn-nav-outline">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-nav-light">Sign Up</a>
                @endguest

                @auth
                    <span class="user-info-nav">
                        👤 {{ Auth::user()->name }}
                        @if(Auth::user()->isAdmin())
                            &nbsp;<span class="badge bg-warning text-dark" style="font-size:0.7rem;">Admin</span>
                        @endif
                    </span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Account
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text text-muted small">{{ Auth::user()->email }}</span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}">My Tickets</a></li>
                            @if(Auth::user()->isAdmin())
                                <li><a class="dropdown-item" href="{{ route('admin.flights.index') }}">Manage Flights</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.bookings.index') }}">Manage Bookings</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
<!-- ╚═══════════ /NAVBAR ══════════╝ -->

<!-- Logged-in status bar -->
@auth
    <div class="status-bar">
        ✅ Logged in as <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})
        @if(Auth::user()->isAdmin()) — <strong>Administrator</strong> @endif
        &nbsp;|&nbsp; <a href="{{ route('profile') }}">View my tickets</a>
        &nbsp;|&nbsp;
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-link btn-sm p-0 text-danger" style="font-size:0.82rem;vertical-align:baseline;">Log Out</button>
        </form>
    </div>
@endauth

@guest
    <div class="status-bar" style="background:#fef9c3; border-color:#fde68a; color:#713f12;">
        ℹ️ You are not logged in. <a href="{{ route('login') }}" style="color:#92400e;font-weight:600;">Sign In</a> or <a href="{{ route('register') }}" style="color:#92400e;font-weight:600;">Sign Up</a> to book flights.
    </div>
@endguest

<main class="container py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>✅</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>⚠️</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<footer class="border-top mt-5 py-3" style="background:#fff;">
    <div class="container text-center text-muted" style="font-size:0.8rem;">
        &copy; {{ date('Y') }} SkyBook Flight Management System
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>