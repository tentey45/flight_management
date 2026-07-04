<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'AeroGlass Flight Management') }}</title>
    <!-- Bootstrap 5.3.0 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <!-- Compiled Assets via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dark-theme">
    <!-- Glowing background elements -->
    <div class="glow-orb orb-1"></div>
    <div class="glow-orb orb-2"></div>
    <div class="glow-orb orb-3"></div>

    <nav class="navbar navbar-expand-lg navbar-dark border-bottom border-secondary border-opacity-25 mb-4 navbar-glass">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <span class="logo-icon me-2">✈</span>
                <span class="logo-text">AeroGlass</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Search Flights</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">My Tickets</a></li>
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-info fw-semibold" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Admin Control
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark dropdown-glass shadow" aria-labelledby="adminDropdown">
                                    <li><a class="dropdown-item" href="{{ route('admin.flights.index') }}">Manage Flights</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.bookings.index') }}">Manage Bookings</a></li>
                                </ul>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto align-items-center">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Log In</a></li>
                        <li class="nav-item ms-2"><a class="btn btn-glow btn-sm" href="{{ route('register') }}">Sign Up</a></li>
                    @endguest

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-bold d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="user-avatar-mini me-2">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                Hi, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark dropdown-glass shadow" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">My Profile</a></li>
                                <li><hr class="dropdown-divider border-secondary border-opacity-50"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert alert-glass alert-success alert-dismissible fade show" role="alert">
                <span class="alert-icon">✓</span>
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-glass alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-icon">⚠</span>
                {{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap 5.3.0 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>