@extends('layouts.app')

@section('title', __('users.title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ __('users.title') }}</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">{{ __('users.new') }}</a>
</div>
<form class="row g-2 mb-3">
    <div class="col-md-8"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="{{ __('users.search') }}"></div>
    <div class="col-md-4"><button class="btn btn-outline-secondary w-100">{{ __('common.filter') }}</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>{{ __('users.username') }}</th><th>{{ __('common.name') }}</th><th>{{ __('common.role') }}</th><th>{{ __('common.status') }}</th><th>{{ __('common.product') }}</th><th></th></tr></thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->fullName() }}</td>
                    <td>{{ $user->roleEnum()->label() }}</td>
                    <td>{{ \App\Support\EnumLabel::get('account_status', $user->status) }}</td>
                    <td>{{ $user->productType }}</td>
                    <td class="text-end">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">{{ __('common.edit') }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $users->links() }}
@endsection
