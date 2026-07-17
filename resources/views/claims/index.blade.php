@extends('layouts.app')

@section('title', 'Claims')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Claims</h1>
    <a href="{{ route('claims.create') }}" class="btn btn-primary">New claim</a>
</div>
<form class="row g-2 mb-3">
    <div class="col-md-8"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search owner or description"></div>
    <div class="col-md-4"><button class="btn btn-outline-secondary w-100">Filter</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>ID</th><th>Owner</th><th>Amount</th><th>Date</th><th>Description</th><th></th></tr></thead>
            <tbody>
            @foreach($claims as $claim)
                <tr>
                    <td>{{ $claim->claimId }}</td>
                    <td>{{ $claim->owner?->fullName() }} ({{ $claim->stateId }})</td>
                    <td>{{ number_format($claim->amount) }}</td>
                    <td>{{ optional($claim->claimDate)->format('Y-m-d') }}</td>
                    <td>{{ $claim->description }}</td>
                    <td>
                        <form method="POST" action="{{ route('claims.destroy', $claim) }}" onsubmit="return confirm('Delete claim?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $claims->links() }}
@endsection
