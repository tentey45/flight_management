@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold text-primary">Edit Post: {{ $post->title }}</h4>
            </div>
            <div class="card-body p-4">
                
                <form action="{{ route('posts.update', $post->slug) }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Post Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    @if($post->image)
                        <div class="mb-3 p-3 bg-light rounded border d-flex align-items-center gap-3">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Current Featured Image" class="rounded shadow-sm" style="width: 150px; height: 100px; object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-1">Current Image</h6>
                                <p class="small text-muted mb-0">Uploading a new image below will replace this one automatically.</p>
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label fw-bold">Update Featured Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Select Existing Categories</label>
                            <select name="category_ids[]" class="form-select @error('category_ids') is-invalid @enderror" multiple size="4">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $post->categories->contains($category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple.</small>
                            @error('category_ids') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light border rounded h-100">
                                <label class="form-label fw-bold text-primary mb-1">Add Another Category</label>
                                <input type="text" name="new_category" class="form-control @error('new_category') is-invalid @enderror" value="{{ old('new_category') }}" placeholder="Type a new category name...">
                                <small class="text-muted d-block mt-2">Type here to instantly create and assign a new category to this post.</small>
                                @error('new_category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 mt-2">
                        <label class="form-label fw-bold">Content Body</label>
                        <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="8" required>{{ old('body', $post->body) }}</textarea>
                        @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <h5 class="border-bottom pb-2 mb-3 mt-5 fw-bold text-secondary">SEO Meta Data</h5>

                    <div class="mb-3">
                        <label class="form-label">SEO Title</label>
                        <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title', $post->meta->seo_title ?? '') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">SEO Keywords</label>
                        <input type="text" name="keywords" class="form-control" value="{{ old('keywords', $post->meta->keywords ?? '') }}">
                    </div>

                    <div class="d-flex justify-content-end border-top pt-4">
                        <a href="{{ route('posts.index') }}" class="btn btn-light border me-2 px-4">Cancel</a>
                        <button type="submit" class="btn btn-success px-4 fw-bold">Update Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection