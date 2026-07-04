@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-5">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0 fw-bold text-primary">Create New Post</h4>
            </div>
            <div class="card-body p-4">
                
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Post Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Featured Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Max file size: 5MB. Formats: jpeg, png, jpg, gif, webp.</small>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Select Existing Categories</label>
                            <select name="category_ids[]" class="form-select @error('category_ids') is-invalid @enderror" multiple size="4">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple.</small>
                            @error('category_ids') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="p-3 bg-light border rounded h-100">
                                <label class="form-label fw-bold text-primary mb-1">Or Create a New Category</label>
                                <input type="text" name="new_category" class="form-control @error('new_category') is-invalid @enderror" value="{{ old('new_category') }}" placeholder="Type a new category name...">
                                <small class="text-muted d-block mt-2">If you can't find the right category on the left, type it here to instantly create and assign it.</small>
                                @error('new_category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 mt-2">
                        <label class="form-label fw-bold">Content Body</label>
                        <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="8" required>{{ old('body') }}</textarea>
                        @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <h5 class="border-bottom pb-2 mb-3 mt-5 fw-bold text-secondary">SEO Meta Data</h5>

                    <div class="mb-3">
                        <label class="form-label">SEO Title</label>
                        <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}" placeholder="Optimized title for search engines...">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">SEO Keywords</label>
                        <input type="text" name="keywords" class="form-control" value="{{ old('keywords') }}" placeholder="laravel, php, eloquent (comma separated)">
                    </div>

                    <div class="d-flex justify-content-end border-top pt-4">
                        <a href="{{ route('posts.index') }}" class="btn btn-light border me-2 px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Save Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection