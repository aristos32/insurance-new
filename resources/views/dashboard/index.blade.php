@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-4">Dashboard</h1>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card p-3"><div class="text-muted">Accounts</div><div class="stat">{{ $ownerCount }}</div></div></div>
    <div class="col-md-3"><div class="card p-3"><div class="text-muted">Leads</div><div class="stat">{{ $leadCount }}</div></div></div>
    <div class="col-md-3"><div class="card p-3"><div class="text-muted">Contracts</div><div class="stat">{{ $saleCount }}</div></div></div>
    <div class="col-md-3"><div class="card p-3"><div class="text-muted">Claims</div><div class="stat">{{ $claimCount }}</div></div></div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Contracts expiring within 30 days</strong>
        <a href="{{ route('reports.expiring') }}" class="btn btn-sm btn-outline-secondary">View report</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th>Contract</th>
                <th>Owner</th>
                <th>Type</th>
                <th>End date</th>
            </tr>
            </thead>
            <tbody>
            @forelse($expiring as $sale)
                <tr>
                    <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->saleId }}</a></td>
                    <td>{{ $sale->owner?->fullName() }}</td>
                    <td>{{ $sale->insuranceType }}</td>
                    <td>{{ optional($sale->endDate)->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-muted">No contracts expiring soon.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
