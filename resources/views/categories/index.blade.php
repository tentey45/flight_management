@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Post Categories</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Total Posts</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td class="align-middle fw-bold">
                        <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none text-primary">
                            {{ $category->name }}
                        </a>
                    </td>
                    <td class="align-middle text-muted">{{ $category->slug }}</td>
                    <td class="align-middle">
                        <span class="badge bg-secondary rounded-pill">{{ $category->posts_count }}</span>
                    </td>
                    <td class="text-end align-middle">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?');">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $categories->links('pagination::bootstrap-5') }}</div>
@endsection