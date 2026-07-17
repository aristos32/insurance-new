@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Users</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">New user</a>
</div>
<form class="row g-2 mb-3">
    <div class="col-md-8"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search username or name"></div>
    <div class="col-md-4"><button class="btn btn-outline-secondary w-100">Filter</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Username</th><th>Name</th><th>Role</th><th>Status</th><th>Product</th><th></th></tr></thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->fullName() }}</td>
                    <td>{{ $user->roleEnum()->label() }}</td>
                    <td>{{ $user->status }}</td>
                    <td>{{ $user->productType }}</td>
                    <td class="text-end">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $users->links() }}
@endsection
