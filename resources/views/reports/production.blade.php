@extends('layouts.app')

@section('title', __('reports.production_title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ __('reports.production_title') }}</h1>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">{{ __('common.back') }}</a>
</div>
<form class="row g-2 mb-3">
    <div class="col-md-3"><input type="date" name="from" value="{{ $from }}" class="form-control"></div>
    <div class="col-md-3"><input type="date" name="to" value="{{ $to }}" class="form-control"></div>
    <div class="col-md-3"><button class="btn btn-outline-secondary">{{ __('common.filter') }}</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>{{ __('common.company') }}</th><th>{{ __('reports.insurance_type') }}</th><th>{{ __('reports.contracts') }}</th></tr></thead>
            <tbody>
            @forelse($rows as $row)
                <tr>
                    <td>{{ $row->company ?: '—' }}</td>
                    <td>{{ \App\Enums\InsuranceType::labelFor($row->insuranceType) }}</td>
                    <td>{{ $row->total }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-muted">{{ __('reports.no_production') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
