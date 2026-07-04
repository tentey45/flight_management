@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-5 col-lg-4">
        <div class="card">
            <div class="card-body p-4">
                <h4 class="mb-1 text-center">Create Account</h4>
                <p class="text-muted text-center mb-4" style="font-size:0.875rem;">Sign up to search and book flights</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        @foreach ($errors->all() as $error) <div>{{ $error }}</div> @endforeach
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" autofocus required placeholder="John Doe">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required placeholder="you@email.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               required placeholder="Min 8 characters">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required placeholder="Repeat password">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Create Account</button>

                    <div class="text-center mt-3" style="font-size:0.875rem;">
                        Already have an account? <a href="{{ route('login') }}">Sign in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection