@extends('layouts.app')

@section('title', __('dashboard.title'))

@section('content')
<h1 class="h3 mb-4">{{ __('dashboard.title') }}</h1>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card p-3"><div class="text-muted">{{ __('dashboard.accounts') }}</div><div class="stat">{{ $ownerCount }}</div></div></div>
    <div class="col-md-3"><div class="card p-3"><div class="text-muted">{{ __('dashboard.leads') }}</div><div class="stat">{{ $leadCount }}</div></div></div>
    <div class="col-md-3"><div class="card p-3"><div class="text-muted">{{ __('dashboard.contracts') }}</div><div class="stat">{{ $saleCount }}</div></div></div>
    <div class="col-md-3"><div class="card p-3"><div class="text-muted">{{ __('dashboard.claims') }}</div><div class="stat">{{ $claimCount }}</div></div></div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>{{ __('dashboard.expiring', ['days' => 30]) }}</strong>
        <a href="{{ route('reports.expiring') }}" class="btn btn-sm btn-outline-secondary">{{ __('dashboard.view_report') }}</a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th>{{ __('common.contract') }}</th>
                <th>{{ __('common.owner') }}</th>
                <th>{{ __('common.type') }}</th>
                <th>{{ __('common.end_date') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($expiring as $sale)
                <tr>
                    <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->saleId }}</a></td>
                    <td>{{ $sale->owner?->fullName() }}</td>
                    <td>{{ \App\Enums\InsuranceType::labelFor($sale->insuranceType) }}</td>
                    <td>{{ optional($sale->endDate)->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-muted">{{ __('dashboard.none_expiring') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
