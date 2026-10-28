@extends('layouts.app')

@section('title', __('reports.balances_title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ __('reports.balances_title') }}</h1>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">{{ __('common.back') }}</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>{{ __('common.contract') }}</th><th>{{ __('common.owner') }}</th><th>{{ __('common.remainder') }}</th></tr></thead>
            <tbody>
            @forelse($rows as $row)
                <tr>
                    <td><a href="{{ route('sales.show', $row->sale) }}">{{ $row->saleId }}</a></td>
                    <td>{{ $row->sale?->owner?->fullName() }}</td>
                    <td>{{ number_format((float)$row->remainder, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-muted">{{ __('reports.no_balances') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
