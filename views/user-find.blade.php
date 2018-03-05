@if (!empty($error_message))
<p> {{ $error_message }} </p>
@endif

<form method="POST" action="{{ route('user-detail') }}">
{{ csrf_field() }}
	<input id="tid" name="tid" type="text" value="{{ old('tid') }}" required autofocus>
	<button type="submit">Tìm kiếm</button>
</form>