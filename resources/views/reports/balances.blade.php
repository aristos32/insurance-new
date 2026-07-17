@extends('layouts.app')

@section('title', 'Outstanding balances')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Outstanding balances</h1>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Back</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Contract</th><th>Owner</th><th>Remainder</th></tr></thead>
            <tbody>
            @forelse($rows as $row)
                <tr>
                    <td><a href="{{ route('sales.show', $row->sale) }}">{{ $row->saleId }}</a></td>
                    <td>{{ $row->sale?->owner?->fullName() }}</td>
                    <td>{{ number_format((float)$row->remainder, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-muted">No outstanding balances.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
