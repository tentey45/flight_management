@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-md-10">
        
        <div class="card shadow-sm mb-4 border-0 overflow-hidden">
            
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}" style="max-height: 500px; object-fit: cover; width: 100%;">
            @endif

            <div class="card-body p-4 p-md-5">
                <h1 class="card-title display-5 fw-bold mb-3">{{ $post->title }}</h1>
                
                <div class="text-muted mb-4 pb-3 border-bottom d-flex align-items-center flex-wrap gap-2">
                    <span>
                        @if($post->user && $post->user->avatar)
                            <img src="{{ asset('storage/' . $post->user->avatar) }}" alt="Avatar" class="rounded-circle me-1" style="width: 24px; height: 24px; object-fit: cover;">
                        @endif
                        By <strong>{{ $post->user->name ?? 'Unknown Author' }}</strong>
                    </span> 
                    <span class="text-secondary mx-1">|</span>
                    <span>Published on {{ $post->created_at->format('M d, Y') }}</span>
                    <span class="text-secondary mx-1">|</span>
                    
                    <span>
                        @foreach($post->categories as $category)
                            <span class="badge bg-primary ms-1">{{ $category->name }}</span>
                        @endforeach
                    </span>
                </div>

                <div class="card-text fs-5 text-dark" style="line-height: 1.8;">
                    {!! nl2br(e($post->body)) !!}
                </div>
            </div>
        </div>

        <h4 class="mb-4 fw-bold">Comments ({{ $post->comments->count() }})</h4>

        @foreach($post->comments as $comment)
            <div class="card shadow-sm mb-3 border-0 bg-white">
                <div class="card-body d-flex gap-3">
                    
                    <div class="flex-shrink-0">
                        @if($comment->user && $comment->user->avatar)
                            <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                {{ strtoupper(substr($comment->user ? $comment->user->name : 'G', 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">
                            {{ $comment->user ? $comment->user->name : 'Guest' }} 
                            <span class="text-muted fw-normal fs-6 ms-2" style="font-size: 0.85rem !important;">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </h6>
                        <p class="mb-0 text-dark">{{ $comment->content }}</p>
                    </div>
                    
                </div>
            </div>
        @endforeach

        <div class="card shadow-sm mt-4 bg-light border-0">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-3">Leave a Comment</h5>
                <form action="{{ route('comments.store', $post->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" class="form-control border-0 shadow-sm" rows="3" required placeholder="Write your thoughts here..."></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Submit Comment</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection