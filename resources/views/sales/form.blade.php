@extends('layouts.app')

@section('title', $sale->exists ? __('sales.edit') : __('sales.new'))

@section('content')
<h1 class="h3 mb-3">{{ $sale->exists ? __('sales.edit') : __('sales.new') }}</h1>
<form method="POST" action="{{ $sale->exists ? route('sales.update', $sale) : route('sales.store') }}" class="card p-4">
    @csrf
    @if($sale->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">{{ __('sales.sale_id') }}</label>
            <input name="saleId" class="form-control" value="{{ old('saleId', $sale->saleId) }}" @disabled($sale->exists) required>
            @if($sale->exists)<input type="hidden" name="saleId" value="{{ $sale->saleId }}">@endif
        </div>
        <div class="col-md-8">
            <label class="form-label">{{ __('common.owner') }}</label>
            <select name="stateId" class="form-select" required>
                <option value="">{{ __('sales.select_owner') }}</option>
                @foreach($owners as $owner)
                    <option value="{{ $owner->stateId }}" @selected(old('stateId', $sale->stateId)===$owner->stateId)>
                        {{ $owner->fullName() }} ({{ $owner->stateId }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ __('sales.insurance_type') }}</label>
            <select name="insuranceType" class="form-select">
                @foreach($insuranceTypes as $type)
                    <option value="{{ $type->value }}" @selected(old('insuranceType', $sale->insuranceType)===$type->value)>{{ $type->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">{{ __('sales.coverage_type') }}</label><input name="coverageType" class="form-control" value="{{ old('coverageType', $sale->coverageType) }}"></div>
        <div class="col-md-4">
            <label class="form-label">{{ __('common.status') }}</label>
            <select name="status" class="form-select">
                @foreach($statuses as $status)
                    <option value="{{ $status->value }}" @selected(old('status', $sale->status)===$status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">{{ __('common.company') }}</label><input name="company" class="form-control" value="{{ old('company', $sale->company) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('common.producer') }}</label><input name="producer" class="form-control" value="{{ old('producer', $sale->producer) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('sales.associate') }}</label><input name="associate" class="form-control" value="{{ old('associate', $sale->associate) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('sales.start_date') }}</label><input type="date" name="startDate" class="form-control" value="{{ old('startDate', optional($sale->startDate)->format('Y-m-d')) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('common.end_date') }}</label><input type="date" name="endDate" class="form-control" value="{{ old('endDate', optional($sale->endDate)->format('Y-m-d')) }}"></div>
        @unless($sale->exists)
            <div class="col-md-4"><label class="form-label">{{ __('sales.initial_debit') }}</label><input type="number" step="0.01" name="initialDebit" class="form-control" value="{{ old('initialDebit') }}"></div>
            <div class="col-12"><hr><h2 class="h6">{{ __('sales.vehicle_heading') }}</h2></div>
            <div class="col-md-3"><label class="form-label">{{ __('sales.reg_number') }}</label><input name="regNumber" class="form-control" value="{{ old('regNumber') }}"></div>
            <div class="col-md-3"><label class="form-label">{{ __('sales.make') }}</label><input name="make" class="form-control" value="{{ old('make') }}"></div>
            <div class="col-md-3"><label class="form-label">{{ __('sales.model') }}</label><input name="model" class="form-control" value="{{ old('model') }}"></div>
            <div class="col-md-3"><label class="form-label">{{ __('sales.cc') }}</label><input type="number" name="cubicCapacity" class="form-control" value="{{ old('cubicCapacity', 1400) }}"></div>
            <div class="col-md-3"><label class="form-label">{{ __('sales.year') }}</label><input type="number" name="manufacturedYear" class="form-control" value="{{ old('manufacturedYear', date('Y')) }}"></div>
            <div class="col-md-3"><label class="form-label">{{ __('sales.vehicle_type') }}</label><input name="vehicleType" class="form-control" value="{{ old('vehicleType', 'PRIVATE') }}"></div>
            <div class="col-md-3"><label class="form-label">{{ __('sales.vehicle_design') }}</label><input name="vehicleDesign" class="form-control" value="{{ old('vehicleDesign', 'SEDAN') }}"></div>
        @endunless
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">{{ __('common.save') }}</button>
        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">{{ __('common.cancel') }}</a>
    </div>
</form>
@endsection
