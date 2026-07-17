@extends('layouts.app')

@section('title', $sale->exists ? 'Edit contract' : 'New contract')

@section('content')
<h1 class="h3 mb-3">{{ $sale->exists ? 'Edit contract' : 'New contract' }}</h1>
<form method="POST" action="{{ $sale->exists ? route('sales.update', $sale) : route('sales.store') }}" class="card p-4">
    @csrf
    @if($sale->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Sale ID</label>
            <input name="saleId" class="form-control" value="{{ old('saleId', $sale->saleId) }}" @disabled($sale->exists) required>
            @if($sale->exists)<input type="hidden" name="saleId" value="{{ $sale->saleId }}">@endif
        </div>
        <div class="col-md-8">
            <label class="form-label">Owner</label>
            <select name="stateId" class="form-select" required>
                <option value="">Select owner</option>
                @foreach($owners as $owner)
                    <option value="{{ $owner->stateId }}" @selected(old('stateId', $sale->stateId)===$owner->stateId)>
                        {{ $owner->fullName() }} ({{ $owner->stateId }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Insurance type</label>
            <select name="insuranceType" class="form-select">
                @foreach($insuranceTypes as $type)
                    <option value="{{ $type->value }}" @selected(old('insuranceType', $sale->insuranceType)===$type->value)>{{ $type->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">Coverage type</label><input name="coverageType" class="form-control" value="{{ old('coverageType', $sale->coverageType) }}"></div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach($statuses as $status)
                    <option value="{{ $status->value }}" @selected(old('status', $sale->status)===$status->value)>{{ $status->value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">Company</label><input name="company" class="form-control" value="{{ old('company', $sale->company) }}"></div>
        <div class="col-md-4"><label class="form-label">Producer</label><input name="producer" class="form-control" value="{{ old('producer', $sale->producer) }}"></div>
        <div class="col-md-4"><label class="form-label">Associate</label><input name="associate" class="form-control" value="{{ old('associate', $sale->associate) }}"></div>
        <div class="col-md-4"><label class="form-label">Start date</label><input type="date" name="startDate" class="form-control" value="{{ old('startDate', optional($sale->startDate)->format('Y-m-d')) }}"></div>
        <div class="col-md-4"><label class="form-label">End date</label><input type="date" name="endDate" class="form-control" value="{{ old('endDate', optional($sale->endDate)->format('Y-m-d')) }}"></div>
        @unless($sale->exists)
            <div class="col-md-4"><label class="form-label">Initial debit</label><input type="number" step="0.01" name="initialDebit" class="form-control" value="{{ old('initialDebit') }}"></div>
            <div class="col-12"><hr><h2 class="h6">Motor vehicle (optional)</h2></div>
            <div class="col-md-3"><label class="form-label">Reg number</label><input name="regNumber" class="form-control" value="{{ old('regNumber') }}"></div>
            <div class="col-md-3"><label class="form-label">Make</label><input name="make" class="form-control" value="{{ old('make') }}"></div>
            <div class="col-md-3"><label class="form-label">Model</label><input name="model" class="form-control" value="{{ old('model') }}"></div>
            <div class="col-md-3"><label class="form-label">CC</label><input type="number" name="cubicCapacity" class="form-control" value="{{ old('cubicCapacity', 1400) }}"></div>
            <div class="col-md-3"><label class="form-label">Year</label><input type="number" name="manufacturedYear" class="form-control" value="{{ old('manufacturedYear', date('Y')) }}"></div>
            <div class="col-md-3"><label class="form-label">Type</label><input name="vehicleType" class="form-control" value="{{ old('vehicleType', 'PRIVATE') }}"></div>
            <div class="col-md-3"><label class="form-label">Design</label><input name="vehicleDesign" class="form-control" value="{{ old('vehicleDesign', 'SEDAN') }}"></div>
        @endunless
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
@endsection
