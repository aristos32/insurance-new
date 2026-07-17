@extends('layouts.app')

@section('title', 'New transaction')

@section('content')
<h1 class="h3 mb-3">New transaction · {{ $sale->saleId }}</h1>
<form method="POST" action="{{ route('transactions.store', $sale) }}" class="card p-4 col-lg-8">
    @csrf
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Details</label>
            <select name="details" class="form-select" required>
                @foreach(['NEW','CASH','CHECK','RENEWAL','CANCEL','DISCOUNT','ALTER','TRANSFER','CORRECTION'] as $detail)
                    <option value="{{ $detail }}" @selected(old('details')===$detail)>{{ $detail }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label">Date</label><input type="date" name="transDate" class="form-control" value="{{ old('transDate', now()->toDateString()) }}"></div>
        <div class="col-md-4"><label class="form-label">Debit</label><input type="number" step="0.01" name="debit" class="form-control" value="{{ old('debit', 0) }}"></div>
        <div class="col-md-4"><label class="form-label">Credit</label><input type="number" step="0.01" name="credit" class="form-control" value="{{ old('credit', 0) }}"></div>
        <div class="col-md-4"><label class="form-label">Receipt no</label><input name="receiptNo" class="form-control" value="{{ old('receiptNo') }}"></div>
        <div class="col-md-6"><label class="form-label">Producer</label><input name="producer" class="form-control" value="{{ old('producer', $sale->producer) }}"></div>
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('transactions.index', $sale) }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
@endsection
