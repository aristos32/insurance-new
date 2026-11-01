@extends('layouts.app')

@section('title', __('sales.title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ __('sales.title') }}</h1>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">{{ __('sales.new') }}</a>
</div>

<form class="row g-2 mb-3">
    <div class="col-md-4"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="{{ __('sales.search') }}"></div>
    <div class="col-md-3">
        <select name="insuranceType" class="form-select">
            <option value="">{{ __('common.all_types') }}</option>
            @foreach($insuranceTypes as $type)
                <option value="{{ $type->value }}" @selected(request('insuranceType')===$type->value)>{{ $type->label() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">{{ __('common.all_statuses') }}</option>
            @foreach($statuses as $status)
                <option value="{{ $status->value }}" @selected(request('status')===$status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-secondary w-100">{{ __('common.filter') }}</button></div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th>{{ __('common.contract') }}</th>
                <th>{{ __('common.owner') }}</th>
                <th>{{ __('common.type') }}</th>
                <th>{{ __('common.company') }}</th>
                <th>{{ __('common.status') }}</th>
                <th>{{ __('sales.end') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->saleId }}</a></td>
                    <td>{{ $sale->owner?->fullName() }}</td>
                    <td>{{ \App\Enums\InsuranceType::labelFor($sale->insuranceType) }}</td>
                    <td>{{ $sale->company }}</td>
                    <td>{{ \App\Enums\SaleStatus::labelFor($sale->status) }}</td>
                    <td>{{ optional($sale->endDate)->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $sales->links() }}
@endsection
