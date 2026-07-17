@extends('layouts.app')

@section('title', 'Owners')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Owners & Leads</h1>
    <a href="{{ route('owners.create') }}" class="btn btn-primary">New owner</a>
</div>

<form class="row g-2 mb-3">
    <div class="col-md-6"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search id, name, email, phone"></div>
    <div class="col-md-3">
        <select name="type" class="form-select">
            <option value="">All types</option>
            <option value="account" @selected(request('type')==='account')>Account</option>
            <option value="lead" @selected(request('type')==='lead')>Lead</option>
        </select>
    </div>
    <div class="col-md-3"><button class="btn btn-outline-secondary w-100">Filter</button></div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Phone</th>
                <th>Email</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($owners as $owner)
                <tr>
                    <td>{{ $owner->stateId }}</td>
                    <td><a href="{{ route('owners.show', $owner) }}">{{ $owner->fullName() }}</a></td>
                    <td><span class="badge text-bg-secondary">{{ $owner->type }}</span></td>
                    <td>{{ $owner->telephone }}</td>
                    <td>{{ $owner->email }}</td>
                    <td class="text-end">
                        <a href="{{ route('owners.edit', $owner) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $owners->links() }}
@endsection
