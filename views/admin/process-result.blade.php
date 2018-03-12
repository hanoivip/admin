@extends('hanoivip::admin.layouts.admin')

@section('title', 'Quan ly')

@section('content')

@if (!empty($message))
<p>{{ $message }}</p>
@endif

@if (!empty($error_message))
<p>{{ $error_message }}</p>
@endif

@if (isset($tid))
<form method="POST" action="{{ route('user-detail') }}">
{{ csrf_field() }}
	<input id="tid" name="tid" type="hidden" value="{{$tid}}">
	<button type="submit">Quay lai</button>
</form>
@else
<form method="GET" action="{{ route('admin-home') }}">
	<button type="submit">Quay lai</button>
</form>
@endif

@endsection