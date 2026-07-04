@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-5">
        <div class="glass-card p-4 mt-4">
            <div class="text-center py-3 mb-3">
                <h2 class="mb-0 text-white font-heading">Create Account</h2>
                <p class="text-muted small mt-1">Join us to search and book flights instantly</p>
            </div>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label text-muted">Full Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-glow w-100 py-2">Sign Up</button>
                
                <div class="text-center mt-4">
                    <span class="text-muted small">Already have an account? <a href="{{ route('login') }}" class="text-link">Log in here</a></span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection