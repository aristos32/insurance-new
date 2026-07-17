@extends('layouts.app')

@section('title', 'Expiring contracts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Expiring contracts</h1>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Back</a>
</div>
<form class="row g-2 mb-3">
    <div class="col-md-3"><input type="number" name="days" value="{{ $days }}" class="form-control" min="1"></div>
    <div class="col-md-3"><button class="btn btn-outline-secondary">Days ahead</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Contract</th><th>Owner</th><th>Type</th><th>Company</th><th>End date</th></tr></thead>
            <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->saleId }}</a></td>
                    <td>{{ $sale->owner?->fullName() }}</td>
                    <td>{{ $sale->insuranceType }}</td>
                    <td>{{ $sale->company }}</td>
                    <td>{{ optional($sale->endDate)->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-muted">No matching contracts.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
{{ $sales->links() }}
@endsection
