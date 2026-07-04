@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>User Management</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Add New User</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Total Posts</th>
                    <th>Joined</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="align-middle fw-bold">{{ $user->name }}</td>
                    <td class="align-middle text-muted">{{ $user->email }}</td>
                    <td class="align-middle">
                        <span class="badge bg-info text-dark rounded-pill">{{ $user->posts_count }}</span>
                    </td>
                    <td class="align-middle">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="text-end align-middle">
                        <a href="{{ route('users.show', $user->name) }}" class="btn btn-sm btn-info text-white">View</a>
                        <a href="{{ route('users.edit', $user->name) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('users.destroy', $user->name) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user? All their posts will also be deleted.');">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $users->links('pagination::bootstrap-5') }}</div>
@endsection