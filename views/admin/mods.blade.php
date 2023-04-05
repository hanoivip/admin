@extends('hanoivip::admin.layouts.admin')

@section('title', 'Add mod user')

@section('content')

<form method="POST" action="{{ route('ecmin.mods') }}">
	{{ csrf_field() }}
	Enter Username: <input id="username" name="username" type="text" value="">
	<button type="submit">Add Mod</button>
</form>

@endsection