@extends('layouts.app')

@section('title', 'History')

@section('content')
<h1 class="h3 mb-3">Audit history</h1>
<form class="row g-2 mb-3">
    <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search user, note, value"></div>
    <div class="col-md-4">
        <select name="type" class="form-select">
            <option value="">All types</option>
            @foreach(['CLIENT','CONTRACT','USER'] as $type)
                <option value="{{ $type }}" @selected(request('type')===$type)>{{ $type }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3"><button class="btn btn-outline-secondary w-100">Filter</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Date</th><th>User</th><th>Type</th><th>Sub type</th><th>Link</th><th>Note</th></tr></thead>
            <tbody>
            @foreach($history as $row)
                <tr>
                    <td>{{ optional($row->transDate)->format('Y-m-d H:i') }}</td>
                    <td>{{ $row->username }}</td>
                    <td>{{ $row->type }}</td>
                    <td>{{ $row->subType }}</td>
                    <td>{{ $row->parameterName }}={{ $row->parameterValue }}</td>
                    <td>{{ $row->note }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $history->links() }}
@endsection
