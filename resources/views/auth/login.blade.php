@extends('layouts.app')

@section('title', __('auth.title'))

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body p-4">
                <h1 class="h3 mb-3">{{ __('nav.brand') }}</h1>
                <p class="text-muted">{{ __('auth.subtitle') }}</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('auth.username') }}</label>
                        <input type="text" name="username" value="{{ old('username') }}" class="form-control" autofocus required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('auth.password') }}</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100">{{ __('auth.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
