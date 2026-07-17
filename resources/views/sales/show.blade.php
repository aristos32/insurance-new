@extends('layouts.app')

@section('title', 'Contract '.$sale->saleId)

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h1 class="h3 mb-1">Contract {{ $sale->saleId }}</h1>
        <div class="text-muted">
            <a href="{{ route('owners.show', $sale->owner) }}">{{ $sale->owner?->fullName() }}</a>
            · {{ $sale->insuranceType }} · {{ $sale->status }}
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('transactions.index', $sale) }}" class="btn btn-primary">Transactions</a>
        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-outline-secondary">Edit</a>
        <form method="POST" action="{{ route('sales.destroy', $sale) }}" onsubmit="return confirm('Delete this contract?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger">Delete</button>
        </form>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card p-3">
            <h2 class="h6">Details</h2>
            <dl class="mb-0">
                <dt>Company</dt><dd>{{ $sale->company ?: '—' }}</dd>
                <dt>Coverage</dt><dd>{{ $sale->coverageType ?: '—' }}</dd>
                <dt>Producer</dt><dd>{{ $sale->producer ?: '—' }}</dd>
                <dt>Period</dt><dd>{{ optional($sale->startDate)->format('Y-m-d') }} → {{ optional($sale->endDate)->format('Y-m-d') }}</dd>
                <dt>Balance</dt><dd><strong>{{ number_format($sale->currentRemainder(), 2) }}</strong></dd>
            </dl>
        </div>
    </div>
    <div class="col-md-8">
        @if($sale->vehicles->isNotEmpty())
            <div class="card mb-3">
                <div class="card-header"><strong>Vehicles</strong></div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Reg</th><th>Make/Model</th><th>CC</th><th>Year</th></tr></thead>
                        <tbody>
                        @foreach($sale->vehicles as $vehicle)
                            <tr>
                                <td>{{ $vehicle->regNumber }}</td>
                                <td>{{ $vehicle->make }} {{ $vehicle->model }}</td>
                                <td>{{ $vehicle->cubicCapacity }}</td>
                                <td>{{ $vehicle->manufacturedYear }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <strong>Recent transactions</strong>
                <a href="{{ route('transactions.create', $sale) }}">Add</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Date</th><th>Details</th><th>Debit</th><th>Credit</th><th>Remainder</th></tr></thead>
                    <tbody>
                    @forelse($sale->transactions->take(10) as $txn)
                        <tr>
                            <td>{{ optional($txn->transDate)->format('Y-m-d') }}</td>
                            <td>{{ $txn->details }}</td>
                            <td>{{ number_format((float)$txn->debit, 2) }}</td>
                            <td>{{ number_format((float)$txn->credit, 2) }}</td>
                            <td>{{ number_format((float)$txn->remainder, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted">No transactions.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
