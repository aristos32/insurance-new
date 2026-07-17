@extends('layouts.app')

@section('title', $owner->fullName())

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h1 class="h3 mb-1">{{ $owner->fullName() }}</h1>
        <div class="text-muted">{{ $owner->stateId }} · {{ $owner->type }}</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('sales.create', ['stateId' => $owner->stateId]) }}" class="btn btn-primary">New contract</a>
        <a href="{{ route('claims.create', ['stateId' => $owner->stateId]) }}" class="btn btn-outline-secondary">New claim</a>
        <a href="{{ route('owners.edit', $owner) }}" class="btn btn-outline-secondary">Edit</a>
        <form method="POST" action="{{ route('owners.destroy', $owner) }}" onsubmit="return confirm('Delete this owner?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger">Delete</button>
        </form>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card p-3">
            <h2 class="h6">Contact</h2>
            <dl class="mb-0">
                <dt>Phone</dt><dd>{{ $owner->telephone ?: '—' }}</dd>
                <dt>Mobile</dt><dd>{{ $owner->cellphone ?: '—' }}</dd>
                <dt>Email</dt><dd>{{ $owner->email ?: '—' }}</dd>
                <dt>Profession</dt><dd>{{ $owner->profession ?: '—' }}</dd>
                <dt>Company</dt><dd>{{ $owner->company ?: '—' }}</dd>
            </dl>
        </div>
        <div class="card p-3 mt-3">
            <h2 class="h6">Addresses</h2>
            @forelse($owner->addresses as $address)
                <div class="mb-2">
                    <div class="small text-muted">{{ $address->addressType }}</div>
                    {{ $address->street }}, {{ $address->city }} {{ $address->areaCode }}<br>
                    {{ $address->country }}
                </div>
            @empty
                <div class="text-muted">No addresses.</div>
            @endforelse
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><strong>Contracts</strong></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>ID</th><th>Type</th><th>Company</th><th>Status</th><th>Period</th></tr></thead>
                    <tbody>
                    @forelse($owner->sales as $sale)
                        <tr>
                            <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->saleId }}</a></td>
                            <td>{{ $sale->insuranceType }}</td>
                            <td>{{ $sale->company }}</td>
                            <td>{{ $sale->status }}</td>
                            <td>{{ optional($sale->startDate)->format('Y-m-d') }} → {{ optional($sale->endDate)->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted">No contracts.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header"><strong>Claims</strong></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>ID</th><th>Amount</th><th>Date</th><th>Description</th></tr></thead>
                    <tbody>
                    @forelse($owner->claims as $claim)
                        <tr>
                            <td>{{ $claim->claimId }}</td>
                            <td>{{ number_format($claim->amount, 0) }}</td>
                            <td>{{ optional($claim->claimDate)->format('Y-m-d') }}</td>
                            <td>{{ $claim->description }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-muted">No claims.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
