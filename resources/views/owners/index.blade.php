@extends('layouts.app')

@section('title', __('owners.title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ __('owners.heading') }}</h1>
    <a href="{{ route('owners.create') }}" class="btn btn-primary">{{ __('owners.new') }}</a>
</div>

<form class="row g-2 mb-3">
    <div class="col-md-6"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="{{ __('owners.search') }}"></div>
    <div class="col-md-3">
        <select name="type" class="form-select">
            <option value="">{{ __('common.all_types') }}</option>
            @foreach(\App\Enums\OwnerType::cases() as $type)
                <option value="{{ $type->value }}" @selected(request('type')===$type->value)>{{ $type->label() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3"><button class="btn btn-outline-secondary w-100">{{ __('common.filter') }}</button></div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th>{{ __('common.id') }}</th>
                <th>{{ __('common.name') }}</th>
                <th>{{ __('common.type') }}</th>
                <th>{{ __('common.phone') }}</th>
                <th>{{ __('common.email') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($owners as $owner)
                <tr>
                    <td>{{ $owner->stateId }}</td>
                    <td><a href="{{ route('owners.show', $owner) }}">{{ $owner->fullName() }}</a></td>
                    <td><span class="badge text-bg-secondary">{{ \App\Enums\OwnerType::labelFor($owner->type) }}</span></td>
                    <td>{{ $owner->telephone }}</td>
                    <td>{{ $owner->email }}</td>
                    <td class="text-end">
                        <a href="{{ route('owners.edit', $owner) }}" class="btn btn-sm btn-outline-secondary">{{ __('common.edit') }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $owners->links() }}
@endsection
