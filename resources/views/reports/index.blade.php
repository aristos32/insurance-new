@extends('layouts.app')

@section('title', __('reports.title'))

@section('content')
<h1 class="h3 mb-4">{{ __('reports.title') }}</h1>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <h2 class="h5">{{ __('reports.expiring_title') }}</h2>
            <p class="text-muted">{{ __('reports.expiring_body') }}</p>
            <a href="{{ route('reports.expiring') }}" class="btn btn-primary">{{ __('common.open') }}</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <h2 class="h5">{{ __('reports.balances_title') }}</h2>
            <p class="text-muted">{{ __('reports.balances_body') }}</p>
            <a href="{{ route('reports.balances') }}" class="btn btn-primary">{{ __('common.open') }}</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <h2 class="h5">{{ __('reports.production_title') }}</h2>
            <p class="text-muted">{{ __('reports.production_body') }}</p>
            <a href="{{ route('reports.production') }}" class="btn btn-primary">{{ __('common.open') }}</a>
        </div>
    </div>
</div>
@endsection
