@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Edit User: {{ $user->name }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-4">
                    <p class="text-muted small">Leave passwords blank if you do not want to change them.</p>

                    <div class="mb-3">
                        <label class="form-label fw-bold">New Password (Optional)</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    @if($user->avatar)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="img-thumbnail rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Update Avatar</label>
                        <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Leave blank to keep current avatar.</small>
                        @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-success">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection