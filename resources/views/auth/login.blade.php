@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-5 col-lg-4">
        <div class="card">
            <div class="card-body p-4">
                <h4 class="mb-1 text-center">Sign In</h4>
                <p class="text-muted text-center mb-4" style="font-size:0.875rem;">Access your flights and tickets</p>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        @foreach ($errors->all() as $error) <div>{{ $error }}</div> @endforeach
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" autofocus required placeholder="you@email.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="••••••••">
                    </div>

                    <div class="mb-4 d-flex align-items-center gap-2">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label text-muted" for="remember" style="font-size:0.875rem;">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">Sign In</button>

                    <div class="text-center mt-3" style="font-size:0.875rem;">
                        Don't have an account? <a href="{{ route('register') }}">Sign up here</a>
                    </div>
                </form>

                <hr class="my-4">
                <div class="p-3 rounded" style="background:#f8fafc; font-size:0.8rem;">
                    <strong class="text-muted d-block mb-1">Demo Accounts:</strong>
                    <div>Admin: <code>admin@flight.com</code> / <code>password</code></div>
                    <div>User: <code>customer@flight.com</code> / <code>password</code></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection