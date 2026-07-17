@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<h1 class="h3 mb-4">Reports</h1>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <h2 class="h5">Expiring contracts</h2>
            <p class="text-muted">Active policies ending within a chosen window.</p>
            <a href="{{ route('reports.expiring') }}" class="btn btn-primary">Open</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <h2 class="h5">Outstanding balances</h2>
            <p class="text-muted">Contracts with a non-zero transaction remainder.</p>
            <a href="{{ route('reports.balances') }}" class="btn btn-primary">Open</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <h2 class="h5">Production</h2>
            <p class="text-muted">Contracts grouped by company and insurance type.</p>
            <a href="{{ route('reports.production') }}" class="btn btn-primary">Open</a>
        </div>
    </div>
</div>
@endsection
