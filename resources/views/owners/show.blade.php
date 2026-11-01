@extends('layouts.app')

@section('title', $owner->fullName())

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h1 class="h3 mb-1">{{ $owner->fullName() }}</h1>
        <div class="text-muted">{{ $owner->stateId }} · {{ \App\Enums\OwnerType::labelFor($owner->type) }}</div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('sales.create', ['stateId' => $owner->stateId]) }}" class="btn btn-primary">{{ __('owners.new_contract') }}</a>
        <a href="{{ route('claims.create', ['stateId' => $owner->stateId]) }}" class="btn btn-outline-secondary">{{ __('owners.new_claim') }}</a>
        <a href="{{ route('owners.edit', $owner) }}" class="btn btn-outline-secondary">{{ __('common.edit') }}</a>
        <form method="POST" action="{{ route('owners.destroy', $owner) }}" onsubmit="return confirm(@js(__('owners.confirm_delete')))">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger">{{ __('common.delete') }}</button>
        </form>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card p-3">
            <h2 class="h6">{{ __('owners.contact') }}</h2>
            <dl class="mb-0">
                <dt>{{ __('common.phone') }}</dt><dd>{{ $owner->telephone ?: '—' }}</dd>
                <dt>{{ __('common.mobile') }}</dt><dd>{{ $owner->cellphone ?: '—' }}</dd>
                <dt>{{ __('common.email') }}</dt><dd>{{ $owner->email ?: '—' }}</dd>
                <dt>{{ __('owners.profession') }}</dt><dd>{{ $owner->profession ?: '—' }}</dd>
                <dt>{{ __('common.company') }}</dt><dd>{{ $owner->company ?: '—' }}</dd>
            </dl>
        </div>
        <div class="card p-3 mt-3">
            <h2 class="h6">{{ __('owners.addresses') }}</h2>
            @forelse($owner->addresses as $address)
                <div class="mb-2">
                    <div class="small text-muted">{{ \App\Support\EnumLabel::get('address', $address->addressType) }}</div>
                    {{ $address->street }}, {{ $address->city }} {{ $address->areaCode }}<br>
                    {{ $address->country }}
                </div>
            @empty
                <div class="text-muted">{{ __('owners.no_addresses') }}</div>
            @endforelse
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><strong>{{ __('owners.contracts') }}</strong></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>{{ __('common.id') }}</th><th>{{ __('common.type') }}</th><th>{{ __('common.company') }}</th><th>{{ __('common.status') }}</th><th>{{ __('common.period') }}</th></tr></thead>
                    <tbody>
                    @forelse($owner->sales as $sale)
                        <tr>
                            <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->saleId }}</a></td>
                            <td>{{ \App\Enums\InsuranceType::labelFor($sale->insuranceType) }}</td>
                            <td>{{ $sale->company }}</td>
                            <td>{{ \App\Enums\SaleStatus::labelFor($sale->status) }}</td>
                            <td>{{ optional($sale->startDate)->format('Y-m-d') }} → {{ optional($sale->endDate)->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted">{{ __('owners.no_contracts') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header"><strong>{{ __('owners.claims') }}</strong></div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>{{ __('common.id') }}</th><th>{{ __('common.amount') }}</th><th>{{ __('common.date') }}</th><th>{{ __('common.description') }}</th></tr></thead>
                    <tbody>
                    @forelse($owner->claims as $claim)
                        <tr>
                            <td>{{ $claim->claimId }}</td>
                            <td>{{ number_format($claim->amount, 0) }}</td>
                            <td>{{ optional($claim->claimDate)->format('Y-m-d') }}</td>
                            <td>{{ $claim->description }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-muted">{{ __('owners.no_claims') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
