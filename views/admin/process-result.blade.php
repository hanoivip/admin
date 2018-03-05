@extends('hanoivip::admin.layouts.admin')

@section('title', 'Quan ly')

@section('content')

@if (!empty($message))
<p>{{ $message }}</p>
@endif

@if (!empty($error_message))
<p>{{ $error_message }}</p>
@endif

<form method="POST" action="{{ route('user-detail') }}">
{{ csrf_field() }}
	<input id="tid" name="tid" type="hidden" value="{{$tid}}">
	<button type="submit">Quay lai</button>
</form>

@endsection