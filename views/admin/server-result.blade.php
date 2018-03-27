@extends('hanoivip::admin.layouts.admin')

@section('title', 'Quan ly server')

@section('content')

@if (!empty($message))
<p>{{ $message }}</p>
@endif

@if (!empty($error_message))
<p>{{ $error_message }}</p>
@endif

<form method="GET" action="{{ route('server-info') }}">
	<button type="submit">Quay lai</button>
</form>

@endsection