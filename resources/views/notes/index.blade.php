@extends('layouts.app')

@section('title', 'Notes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Notes</h1>
    <a href="{{ route('notes.create') }}" class="btn btn-primary">New note</a>
</div>
<form class="row g-2 mb-3">
    <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search"></div>
    <div class="col-md-4">
        <select name="type" class="form-select">
            <option value="">All types</option>
            <option value="CLIENT" @selected(request('type')==='CLIENT')>CLIENT</option>
            <option value="CONTRACT" @selected(request('type')==='CONTRACT')>CONTRACT</option>
        </select>
    </div>
    <div class="col-md-3"><button class="btn btn-outline-secondary w-100">Filter</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Date</th><th>Type</th><th>Link</th><th>Description</th><th></th></tr></thead>
            <tbody>
            @foreach($notes as $note)
                <tr>
                    <td>{{ optional($note->entryDate)->format('Y-m-d H:i') }}</td>
                    <td>{{ $note->type }}</td>
                    <td>{{ $note->parameterName }}={{ $note->parameterValue }}</td>
                    <td>{{ $note->description }}</td>
                    <td>
                        <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('Delete note?')">
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
{{ $notes->links() }}
@endsection
