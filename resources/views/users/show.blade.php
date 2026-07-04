@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}'s Avatar" class="rounded-circle shadow-sm mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #fff;">
                @else
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-3" style="width: 120px; height: 120px; font-size: 3rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <h3 class="mb-1 fw-bold">{{ $user->name }}</h3>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                
                <p class="small text-muted mb-0">
                    <i class="bi bi-calendar3"></i> Member since {{ $user->created_at->format('F Y') }}
                </p>
                
                <div class="mt-4">
                    <a href="{{ route('users.edit', $user->name) }}" class="btn btn-outline-primary w-100">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">Posts by {{ $user->name }}</h5>
                <span class="badge bg-primary rounded-pill">{{ $user->posts->count() }} Posts</span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($user->posts as $post)
                        <li class="list-group-item p-4 hover-bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">
                                        <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark fw-bold">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    <small class="text-muted">Published on {{ $post->created_at->format('M d, Y') }}</small>
                                </div>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-light border">Edit</a>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item p-5 text-center text-muted">
                            <div class="mb-2 fs-4">📝</div>
                            This user hasn't written any posts yet.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection