@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-md-8">
        
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <span class="text-muted fs-4">Category:</span> {{ $category->name }}
                </h2>
                <p class="text-muted mb-0">Showing all posts tagged with "{{ $category->name }}"</p>
            </div>
            <span class="badge bg-primary fs-5 rounded-pill">{{ $category->posts->count() }} Posts</span>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <ul class="list-group list-group-flush rounded">
                    @forelse($category->posts as $post)
                        <li class="list-group-item p-4">
                            <div class="row">
                                @if($post->image)
                                <div class="col-md-3">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="Current Featured Image" class="rounded shadow-sm" style="width: 150px; height: 100px; object-fit: cover;">
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <h4 class="mb-1 fw-bold">
                                        <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                                            {{ $post->title }}
                                        </a>
                                    </h4>
                                    
                                    <div class="text-muted small mb-2">
                                        By <strong>{{ $post->user->name ?? 'Unknown Author' }}</strong> 
                                        | Published {{ $post->created_at->format('M d, Y') }}
                                    </div>
                                    
                                    <p class="mb-0 text-secondary">
                                        {{ Str::limit(strip_tags($post->body), 120) }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-outline-primary float-end">Read More</a>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item p-5 text-center text-muted">
                            <h5 class="mb-0">No posts found in this category.</h5>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('posts.index') }}" class="btn btn-light border px-4">← Back to All Posts</a>
        </div>

    </div>
</div>
@endsection