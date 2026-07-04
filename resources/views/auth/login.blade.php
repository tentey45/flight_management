@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-5">
        <div class="glass-card p-4 mt-5">
            <div class="text-center py-3 mb-3">
                <h2 class="mb-0 text-white font-heading">Welcome Back</h2>
                <p class="text-muted small mt-1">Please sign in to access your flight tickets</p>
            </div>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label text-muted">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-4 form-check d-flex justify-content-between align-items-center">
                    <div>
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label text-muted" for="remember">Remember Me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-glow w-100 py-2">Log In</button>
                
                <div class="text-center mt-4">
                    <span class="text-muted small">Don't have an account? <a href="{{ route('register') }}" class="text-link">Sign up here</a></span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection