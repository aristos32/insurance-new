@extends('layouts.app')

@section('title', __('claims.new'))

@section('content')
<h1 class="h3 mb-3">{{ __('claims.new') }}</h1>
<form method="POST" action="{{ route('claims.store') }}" class="card p-4 col-lg-8">
    @csrf
    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label">{{ __('common.owner') }}</label>
            <select name="stateId" class="form-select" required>
                @foreach($owners as $owner)
                    <option value="{{ $owner->stateId }}" @selected(old('stateId', $claim->stateId)===$owner->stateId)>
                        {{ $owner->fullName() }} ({{ $owner->stateId }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">{{ __('common.amount') }}</label><input type="number" name="amount" class="form-control" value="{{ old('amount') }}" required></div>
        <div class="col-md-4"><label class="form-label">{{ __('common.date') }}</label><input type="date" name="claimDate" class="form-control" value="{{ old('claimDate', now()->toDateString()) }}"></div>
        <div class="col-md-8"><label class="form-label">{{ __('common.description') }}</label><input name="description" class="form-control" value="{{ old('description') }}"></div>
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">{{ __('common.save') }}</button>
        <a href="{{ route('claims.index') }}" class="btn btn-outline-secondary">{{ __('common.cancel') }}</a>
    </div>
</form>
@endsection
