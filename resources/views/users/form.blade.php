@extends('layouts.app')

@section('title', $user->exists ? __('users.edit') : __('users.new'))

@section('content')
<h1 class="h3 mb-3">{{ $user->exists ? __('users.edit') : __('users.new') }}</h1>
<form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}" class="card p-4">
    @csrf
    @if($user->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">{{ __('users.username') }}</label>
            <input name="username" class="form-control" value="{{ old('username', $user->username) }}" @disabled($user->exists) required>
            @if($user->exists)<input type="hidden" name="username" value="{{ $user->username }}">@endif
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ $user->exists ? __('users.password_optional') : __('users.password') }}</label>
            <input type="password" name="password" class="form-control" @unless($user->exists) required @endunless>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ __('common.role') }}</label>
            <select name="role" class="form-select">
                @foreach($roles as $role)
                    <option value="{{ $role->value }}" @selected(old('role', $user->role)===$role->value)>{{ $role->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ __('common.status') }}</label>
            <select name="status" class="form-select">
                @foreach(['ACTIVE', 'SUSPENDED'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $user->status)===$status)>{{ \App\Support\EnumLabel::get('account_status', $status) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">{{ __('users.product_type') }}</label><input name="productType" class="form-control" value="{{ old('productType', $user->productType) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('users.client_name') }}</label><input name="clientName" class="form-control" value="{{ old('clientName', $user->clientName) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('users.first_name') }}</label><input name="firstName" class="form-control" value="{{ old('firstName', $user->firstName) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('users.last_name') }}</label><input name="lastName" class="form-control" value="{{ old('lastName', $user->lastName) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('common.email') }}</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
        <div class="col-md-4"><label class="form-label">{{ __('users.linked_state_id') }}</label><input name="stateId" class="form-control" value="{{ old('stateId', $user->stateId) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('users.telephone') }}</label><input name="telephone" class="form-control" value="{{ old('telephone', $user->telephone) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('common.producer') }}</label><input name="producer" class="form-control" value="{{ old('producer', $user->producer) }}"></div>
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">{{ __('common.save') }}</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">{{ __('common.cancel') }}</a>
    </div>
</form>
@if($user->exists)
    <form method="POST" action="{{ route('users.destroy', $user) }}" class="mt-3" onsubmit="return confirm(@js(__('users.confirm_delete')))">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger">{{ __('users.delete') }}</button>
    </form>
@endif
@endsection
