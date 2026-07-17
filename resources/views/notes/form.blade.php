@extends('layouts.app')

@section('title', 'New note')

@section('content')
<h1 class="h3 mb-3">New note</h1>
<form method="POST" action="{{ route('notes.store') }}" class="card p-4 col-lg-8">
    @csrf
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
                <option value="CLIENT" @selected(old('type', $note->type)==='CLIENT')>CLIENT</option>
                <option value="CONTRACT" @selected(old('type', $note->type)==='CONTRACT')>CONTRACT</option>
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">Parameter name</label><input name="parameterName" class="form-control" value="{{ old('parameterName', $note->parameterName) }}" placeholder="stateId or saleId"></div>
        <div class="col-md-4"><label class="form-label">Parameter value</label><input name="parameterValue" class="form-control" value="{{ old('parameterValue', $note->parameterValue) }}"></div>
        <div class="col-12"><label class="form-label">Description</label><input name="description" class="form-control" value="{{ old('description') }}" required></div>
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
@endsection
