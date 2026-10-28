@extends('layouts.app')

@section('title', __('notes.new'))

@section('content')
<h1 class="h3 mb-3">{{ __('notes.new') }}</h1>
<form method="POST" action="{{ route('notes.store') }}" class="card p-4 col-lg-8">
    @csrf
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">{{ __('common.type') }}</label>
            <select name="type" class="form-select">
                @foreach(['CLIENT', 'CONTRACT'] as $type)
                    <option value="{{ $type }}" @selected(old('type', $note->type)===$type)>{{ \App\Support\EnumLabel::get('record_type', $type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">{{ __('notes.parameter_name') }}</label><input name="parameterName" class="form-control" value="{{ old('parameterName', $note->parameterName) }}" placeholder="{{ __('notes.parameter_placeholder') }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('notes.parameter_value') }}</label><input name="parameterValue" class="form-control" value="{{ old('parameterValue', $note->parameterValue) }}"></div>
        <div class="col-12"><label class="form-label">{{ __('common.description') }}</label><input name="description" class="form-control" value="{{ old('description') }}" required></div>
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">{{ __('common.save') }}</button>
        <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">{{ __('common.cancel') }}</a>
    </div>
</form>
@endsection
