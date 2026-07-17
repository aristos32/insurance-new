@extends('layouts.app')

@section('title', 'Transactions '.$sale->saleId)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-0">Transactions · {{ $sale->saleId }}</h1>
        <div class="text-muted">{{ $sale->owner?->fullName() }} · Balance {{ number_format($sale->currentRemainder(), 2) }}</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('transactions.create', $sale) }}" class="btn btn-primary">Add transaction</a>
        <a href="{{ route('sales.show', $sale) }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>ID</th><th>Date</th><th>Details</th><th>Receipt</th><th>Debit</th><th>Credit</th><th>Remainder</th></tr></thead>
            <tbody>
            @foreach($sale->transactions as $txn)
                <tr>
                    <td>{{ $txn->transId }}</td>
                    <td>{{ optional($txn->transDate)->format('Y-m-d') }}</td>
                    <td>{{ $txn->details }}</td>
                    <td>{{ $txn->receiptNo }}</td>
                    <td>{{ number_format((float)$txn->debit, 2) }}</td>
                    <td>{{ number_format((float)$txn->credit, 2) }}</td>
                    <td>{{ number_format((float)$txn->remainder, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
