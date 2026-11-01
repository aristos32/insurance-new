@extends('layouts.app')

@section('title', __('notes.title'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ __('notes.title') }}</h1>
    <a href="{{ route('notes.create') }}" class="btn btn-primary">{{ __('notes.new') }}</a>
</div>
<form class="row g-2 mb-3">
    <div class="col-md-5"><input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="{{ __('notes.search') }}"></div>
    <div class="col-md-4">
        <select name="type" class="form-select">
            <option value="">{{ __('common.all_types') }}</option>
            @foreach(['CLIENT', 'CONTRACT'] as $type)
                <option value="{{ $type }}" @selected(request('type')===$type)>{{ \App\Support\EnumLabel::get('record_type', $type) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3"><button class="btn btn-outline-secondary w-100">{{ __('common.filter') }}</button></div>
</form>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>{{ __('common.date') }}</th><th>{{ __('common.type') }}</th><th>{{ __('common.link') }}</th><th>{{ __('common.description') }}</th><th></th></tr></thead>
            <tbody>
            @foreach($notes as $note)
                <tr>
                    <td>{{ optional($note->entryDate)->format('Y-m-d H:i') }}</td>
                    <td>{{ \App\Support\EnumLabel::get('record_type', $note->type) }}</td>
                    <td>{{ $note->parameterName }}={{ $note->parameterValue }}</td>
                    <td>{{ $note->description }}</td>
                    <td>
                        <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm(@js(__('notes.confirm_delete')))">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">{{ __('common.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $notes->links() }}
@endsection
