@extends('layouts.app')

@section('title', 'Production report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Production</h1>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Back</a>
</div>
<form class="row g-2 mb-3">
    <div class="col-md-3"><input type="date" name="from" value="{{ $from }}" class="form-control"></div>
    <div class="col-md-3"><input type="date" name="to" value="{{ $to }}" class="form-control"></div>
    <div class="col-md-3"><button class="btn btn-outline-secondary">Filter</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Company</th><th>Insurance type</th><th>Contracts</th></tr></thead>
            <tbody>
            @forelse($rows as $row)
                <tr>
                    <td>{{ $row->company ?: '—' }}</td>
                    <td>{{ $row->insuranceType }}</td>
                    <td>{{ $row->total }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-muted">No production in range.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
