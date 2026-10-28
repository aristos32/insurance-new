@extends('layouts.app')

@section('title', $owner->exists ? __('owners.edit') : __('owners.new'))

@section('content')
<h1 class="h3 mb-3">{{ $owner->exists ? __('owners.edit') : __('owners.new') }}</h1>
<form method="POST" action="{{ $owner->exists ? route('owners.update', $owner) : route('owners.store') }}" class="card p-4">
    @csrf
    @if($owner->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">{{ __('owners.state_id') }}</label>
            <input name="stateId" class="form-control" value="{{ old('stateId', $owner->stateId) }}" @disabled($owner->exists) required>
            @if($owner->exists)<input type="hidden" name="stateId" value="{{ $owner->stateId }}">@endif
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ __('common.type') }}</label>
            <select name="type" class="form-select">
                @foreach(\App\Enums\OwnerType::cases() as $type)
                    <option value="{{ $type->value }}" @selected(old('type', $owner->type)===$type->value)>{{ $type->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ __('owners.proposer') }}</label>
            <select name="proposerType" class="form-select">
                <option value="PERSON" @selected(old('proposerType', $owner->proposerType)==='PERSON')>{{ \App\Support\EnumLabel::get('proposer', 'PERSON') }}</option>
                <option value="COMPANY" @selected(old('proposerType', $owner->proposerType)==='COMPANY')>{{ \App\Support\EnumLabel::get('proposer', 'COMPANY') }}</option>
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">{{ __('owners.first_name') }}</label><input name="firstName" class="form-control" value="{{ old('firstName', $owner->firstName) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('owners.last_name') }}</label><input name="lastName" class="form-control" value="{{ old('lastName', $owner->lastName) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('owners.gender') }}</label><input name="gender" class="form-control" value="{{ old('gender', $owner->gender) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('owners.birth_date') }}</label><input type="date" name="birthDate" class="form-control" value="{{ old('birthDate', optional($owner->birthDate)->format('Y-m-d')) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('owners.profession') }}</label><input name="profession" class="form-control" value="{{ old('profession', $owner->profession) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('common.company') }}</label><input name="company" class="form-control" value="{{ old('company', $owner->company) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('owners.telephone') }}</label><input name="telephone" class="form-control" value="{{ old('telephone', $owner->telephone) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('owners.cellphone') }}</label><input name="cellphone" class="form-control" value="{{ old('cellphone', $owner->cellphone) }}"></div>
        <div class="col-md-4"><label class="form-label">{{ __('common.email') }}</label><input type="email" name="email" class="form-control" value="{{ old('email', $owner->email) }}"></div>
        <div class="col-md-6"><label class="form-label">{{ __('owners.country_of_birth') }}</label><input name="countryOfBirth" class="form-control" value="{{ old('countryOfBirth', $owner->countryOfBirth) }}"></div>
        <div class="col-md-6"><label class="form-label">{{ __('owners.country_of_residence') }}</label><input name="countryOfResidence" class="form-control" value="{{ old('countryOfResidence', $owner->countryOfResidence) }}"></div>
        @unless($owner->exists)
            <div class="col-12"><hr><h2 class="h6">{{ __('owners.address_heading') }}</h2></div>
            <div class="col-md-6"><label class="form-label">{{ __('owners.street') }}</label><input name="street" class="form-control" value="{{ old('street') }}"></div>
            <div class="col-md-3"><label class="form-label">{{ __('owners.area_code') }}</label><input name="areaCode" class="form-control" value="{{ old('areaCode') }}"></div>
            <div class="col-md-3"><label class="form-label">{{ __('owners.city') }}</label><input name="city" class="form-control" value="{{ old('city') }}"></div>
            <div class="col-md-4"><label class="form-label">{{ __('owners.state') }}</label><input name="state" class="form-control" value="{{ old('state') }}"></div>
            <div class="col-md-4"><label class="form-label">{{ __('owners.country') }}</label><input name="country" class="form-control" value="{{ old('country', 'Cyprus') }}"></div>
        @endunless
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">{{ __('common.save') }}</button>
        <a href="{{ route('owners.index') }}" class="btn btn-outline-secondary">{{ __('common.cancel') }}</a>
    </div>
</form>
@endsection
