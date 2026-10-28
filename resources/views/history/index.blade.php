@extends('layouts.app')

@section('title', __('history.title'))

@section('content')
<h1 class="h3 mb-3">{{ __('history.title') }}</h1>
<form class="row g-2 mb-3">
    <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="{{ __('history.search') }}"></div>
    <div class="col-md-4">
        <select name="type" class="form-select">
            <option value="">{{ __('common.all_types') }}</option>
            @foreach(['CLIENT','CONTRACT','USER'] as $type)
                <option value="{{ $type }}" @selected(request('type')===$type)>{{ \App\Support\EnumLabel::get('record_type', $type) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3"><button class="btn btn-outline-secondary w-100">{{ __('common.filter') }}</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>{{ __('common.date') }}</th><th>{{ __('common.user') }}</th><th>{{ __('common.type') }}</th><th>{{ __('history.sub_type') }}</th><th>{{ __('common.link') }}</th><th>{{ __('common.note') }}</th></tr></thead>
            <tbody>
            @foreach($history as $row)
                <tr>
                    <td>{{ optional($row->transDate)->format('Y-m-d H:i') }}</td>
                    <td>{{ $row->username }}</td>
                    <td>{{ \App\Support\EnumLabel::get('record_type', $row->type) }}</td>
                    <td>{{ $row->subType }}</td>
                    <td>{{ $row->parameterName }}={{ $row->parameterValue }}</td>
                    <td>{{ $row->note }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $history->links() }}
@endsection
