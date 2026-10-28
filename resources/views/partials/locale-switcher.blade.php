@php($tone = $tone ?? 'secondary')
<form method="POST" action="{{ route('locale.update') }}" class="d-inline-flex gap-1">
    @csrf
    @foreach (['el' => 'ΕΛ', 'en' => 'EN'] as $code => $label)
        <button
            type="submit"
            name="locale"
            value="{{ $code }}"
            class="btn btn-sm {{ app()->getLocale() === $code ? ($tone === 'light' ? 'btn-light' : 'btn-secondary') : ($tone === 'light' ? 'btn-outline-light' : 'btn-outline-secondary') }}"
        >{{ $label }}</button>
    @endforeach
</form>
