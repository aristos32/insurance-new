@extends('layouts.app')

@section('title', __('transactions.title', ['id' => $sale->saleId]))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="h3 mb-0">{{ __('transactions.heading', ['id' => $sale->saleId]) }}</h1>
        <div class="text-muted">{{ $sale->owner?->fullName() }} · {{ __('common.balance') }} {{ number_format($sale->currentRemainder(), 2) }}</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('transactions.create', $sale) }}" class="btn btn-primary">{{ __('transactions.add') }}</a>
        <a href="{{ route('sales.show', $sale) }}" class="btn btn-outline-secondary">{{ __('common.back') }}</a>
    </div>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>{{ __('common.id') }}</th><th>{{ __('common.date') }}</th><th>{{ __('common.details') }}</th><th>{{ __('common.receipt') }}</th><th>{{ __('common.debit') }}</th><th>{{ __('common.credit') }}</th><th>{{ __('common.remainder') }}</th></tr></thead>
            <tbody>
            @foreach($sale->transactions as $txn)
                <tr>
                    <td>{{ $txn->transId }}</td>
                    <td>{{ optional($txn->transDate)->format('Y-m-d') }}</td>
                    <td>{{ \App\Support\EnumLabel::get('transaction_detail', $txn->details) }}</td>
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
