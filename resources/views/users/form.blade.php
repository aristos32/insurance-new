@extends('layouts.app')

@section('title', $user->exists ? 'Edit user' : 'New user')

@section('content')
<h1 class="h3 mb-3">{{ $user->exists ? 'Edit user' : 'New user' }}</h1>
<form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}" class="card p-4">
    @csrf
    @if($user->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Username</label>
            <input name="username" class="form-control" value="{{ old('username', $user->username) }}" @disabled($user->exists) required>
            @if($user->exists)<input type="hidden" name="username" value="{{ $user->username }}">@endif
        </div>
        <div class="col-md-4">
            <label class="form-label">Password {{ $user->exists ? '(leave blank to keep)' : '' }}</label>
            <input type="password" name="password" class="form-control" @unless($user->exists) required @endunless>
        </div>
        <div class="col-md-4">
            <label class="form-label">Role</label>
            <select name="role" class="form-select">
                @foreach($roles as $role)
                    <option value="{{ $role->value }}" @selected(old('role', $user->role)===$role->value)>{{ $role->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="ACTIVE" @selected(old('status', $user->status)==='ACTIVE')>ACTIVE</option>
                <option value="SUSPENDED" @selected(old('status', $user->status)==='SUSPENDED')>SUSPENDED</option>
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">Product type</label><input name="productType" class="form-control" value="{{ old('productType', $user->productType) }}"></div>
        <div class="col-md-4"><label class="form-label">Client name</label><input name="clientName" class="form-control" value="{{ old('clientName', $user->clientName) }}"></div>
        <div class="col-md-4"><label class="form-label">First name</label><input name="firstName" class="form-control" value="{{ old('firstName', $user->firstName) }}"></div>
        <div class="col-md-4"><label class="form-label">Last name</label><input name="lastName" class="form-control" value="{{ old('lastName', $user->lastName) }}"></div>
        <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"></div>
        <div class="col-md-4"><label class="form-label">Linked stateId</label><input name="stateId" class="form-control" value="{{ old('stateId', $user->stateId) }}"></div>
        <div class="col-md-4"><label class="form-label">Telephone</label><input name="telephone" class="form-control" value="{{ old('telephone', $user->telephone) }}"></div>
        <div class="col-md-4"><label class="form-label">Producer</label><input name="producer" class="form-control" value="{{ old('producer', $user->producer) }}"></div>
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
@if($user->exists)
    <form method="POST" action="{{ route('users.destroy', $user) }}" class="mt-3" onsubmit="return confirm('Delete user?')">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger">Delete user</button>
    </form>
@endif
@endsection
