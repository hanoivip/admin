@extends('hanoivip::admin.layouts.admin')

@section('title', 'Process result..')

@section('content')

<form method="POST" action="{{ route('user-detail') }}">
	{{ csrf_field() }}
	<input id="tid" name="tid" type="hidden" value="{{$tid}}">
	<button type="submit">Back</button>
</form>

@endsection