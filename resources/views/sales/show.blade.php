@extends('layouts.app')

@section('title', __('sales.show_title', ['id' => $sale->saleId]))

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h1 class="h3 mb-1">{{ __('sales.show_title', ['id' => $sale->saleId]) }}</h1>
        <div class="text-muted">
            <a href="{{ route('owners.show', $sale->owner) }}">{{ $sale->owner?->fullName() }}</a>
            · {{ \App\Enums\InsuranceType::labelFor($sale->insuranceType) }} · {{ \App\Enums\SaleStatus::labelFor($sale->status) }}
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('transactions.index', $sale) }}" class="btn btn-primary">{{ __('sales.transactions') }}</a>
        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-outline-secondary">{{ __('common.edit') }}</a>
        <form method="POST" action="{{ route('sales.destroy', $sale) }}" onsubmit="return confirm(@js(__('sales.confirm_delete')))">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger">{{ __('common.delete') }}</button>
        </form>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card p-3">
            <h2 class="h6">{{ __('common.details') }}</h2>
            <dl class="mb-0">
                <dt>{{ __('common.company') }}</dt><dd>{{ $sale->company ?: '—' }}</dd>
                <dt>{{ __('common.coverage') }}</dt><dd>{{ $sale->coverageType ?: '—' }}</dd>
                <dt>{{ __('common.producer') }}</dt><dd>{{ $sale->producer ?: '—' }}</dd>
                <dt>{{ __('common.period') }}</dt><dd>{{ optional($sale->startDate)->format('Y-m-d') }} → {{ optional($sale->endDate)->format('Y-m-d') }}</dd>
                <dt>{{ __('common.balance') }}</dt><dd><strong>{{ number_format($sale->currentRemainder(), 2) }}</strong></dd>
            </dl>
        </div>
    </div>
    <div class="col-md-8">
        @if($sale->vehicles->isNotEmpty())
            <div class="card mb-3">
                <div class="card-header"><strong>{{ __('sales.vehicles') }}</strong></div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>{{ __('sales.reg') }}</th><th>{{ __('sales.make_model') }}</th><th>{{ __('sales.cc') }}</th><th>{{ __('sales.year') }}</th></tr></thead>
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
                <strong>{{ __('sales.recent_transactions') }}</strong>
                <a href="{{ route('transactions.create', $sale) }}">{{ __('common.add') }}</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>{{ __('common.date') }}</th><th>{{ __('common.details') }}</th><th>{{ __('common.debit') }}</th><th>{{ __('common.credit') }}</th><th>{{ __('common.remainder') }}</th></tr></thead>
                    <tbody>
                    @forelse($sale->transactions->take(10) as $txn)
                        <tr>
                            <td>{{ optional($txn->transDate)->format('Y-m-d') }}</td>
                            <td>{{ \App\Support\EnumLabel::get('transaction_detail', $txn->details) }}</td>
                            <td>{{ number_format((float)$txn->debit, 2) }}</td>
                            <td>{{ number_format((float)$txn->credit, 2) }}</td>
                            <td>{{ number_format((float)$txn->remainder, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted">{{ __('sales.no_transactions') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
