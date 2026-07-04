@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">All Posts</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Categories</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td class="align-middle fw-bold">{{ $post->title }}</td>
                        <td class="align-middle">{{ $post->user->name ?? 'Unknown' }}</td>
                        <td class="align-middle">
                            @foreach($post->categories as $category)
                                <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                                    <span class="badge bg-primary shadow-sm hover-overlay">{{ $category->name }}</span>
                                </a>
                            @endforeach
                        </td>
                        <td class="text-end align-middle">
                            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-info text-white">View</a>
                            <a href="{{ route('posts.edit', $post->slug) }}" class="btn btn-sm btn-warning">Edit</a>
                            
                            <form action="{{ route('posts.destroy', $post->slug) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No posts found. Create one to get started!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $posts->links('pagination::bootstrap-5') }}
</div>
@endsection