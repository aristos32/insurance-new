@extends('layouts.app')

@section('title', $owner->exists ? 'Edit owner' : 'New owner')

@section('content')
<h1 class="h3 mb-3">{{ $owner->exists ? 'Edit owner' : 'New owner' }}</h1>
<form method="POST" action="{{ $owner->exists ? route('owners.update', $owner) : route('owners.store') }}" class="card p-4">
    @csrf
    @if($owner->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">State ID</label>
            <input name="stateId" class="form-control" value="{{ old('stateId', $owner->stateId) }}" @disabled($owner->exists) required>
            @if($owner->exists)<input type="hidden" name="stateId" value="{{ $owner->stateId }}">@endif
        </div>
        <div class="col-md-4">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
                <option value="account" @selected(old('type', $owner->type)==='account')>Account</option>
                <option value="lead" @selected(old('type', $owner->type)==='lead')>Lead</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Proposer</label>
            <select name="proposerType" class="form-select">
                <option value="PERSON" @selected(old('proposerType', $owner->proposerType)==='PERSON')>Person</option>
                <option value="COMPANY" @selected(old('proposerType', $owner->proposerType)==='COMPANY')>Company</option>
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">First name</label><input name="firstName" class="form-control" value="{{ old('firstName', $owner->firstName) }}"></div>
        <div class="col-md-4"><label class="form-label">Last name</label><input name="lastName" class="form-control" value="{{ old('lastName', $owner->lastName) }}"></div>
        <div class="col-md-4"><label class="form-label">Gender</label><input name="gender" class="form-control" value="{{ old('gender', $owner->gender) }}"></div>
        <div class="col-md-4"><label class="form-label">Birth date</label><input type="date" name="birthDate" class="form-control" value="{{ old('birthDate', optional($owner->birthDate)->format('Y-m-d')) }}"></div>
        <div class="col-md-4"><label class="form-label">Profession</label><input name="profession" class="form-control" value="{{ old('profession', $owner->profession) }}"></div>
        <div class="col-md-4"><label class="form-label">Company</label><input name="company" class="form-control" value="{{ old('company', $owner->company) }}"></div>
        <div class="col-md-4"><label class="form-label">Telephone</label><input name="telephone" class="form-control" value="{{ old('telephone', $owner->telephone) }}"></div>
        <div class="col-md-4"><label class="form-label">Cellphone</label><input name="cellphone" class="form-control" value="{{ old('cellphone', $owner->cellphone) }}"></div>
        <div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $owner->email) }}"></div>
        <div class="col-md-6"><label class="form-label">Country of birth</label><input name="countryOfBirth" class="form-control" value="{{ old('countryOfBirth', $owner->countryOfBirth) }}"></div>
        <div class="col-md-6"><label class="form-label">Country of residence</label><input name="countryOfResidence" class="form-control" value="{{ old('countryOfResidence', $owner->countryOfResidence) }}"></div>
        @unless($owner->exists)
            <div class="col-12"><hr><h2 class="h6">Correspondence address (optional)</h2></div>
            <div class="col-md-6"><label class="form-label">Street</label><input name="street" class="form-control" value="{{ old('street') }}"></div>
            <div class="col-md-3"><label class="form-label">Area code</label><input name="areaCode" class="form-control" value="{{ old('areaCode') }}"></div>
            <div class="col-md-3"><label class="form-label">City</label><input name="city" class="form-control" value="{{ old('city') }}"></div>
            <div class="col-md-4"><label class="form-label">State</label><input name="state" class="form-control" value="{{ old('state') }}"></div>
            <div class="col-md-4"><label class="form-label">Country</label><input name="country" class="form-control" value="{{ old('country', 'Cyprus') }}"></div>
        @endunless
    </div>
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('owners.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
</form>
@endsection
