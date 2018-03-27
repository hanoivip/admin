@extends('hanoivip::admin.layouts.admin')

@section('title', 'Cau hinh website')

@section('content')



<form method="POST" action="{{ route('site-down') }}">
{{ csrf_field() }}
	Thong bao: <input id="message" name="message" value="">
	<button type="submit">Dong site</button>
</form>

<form method="POST" action="{{ route('site-up') }}">
{{ csrf_field() }}
	<button type="submit">Mo site</button>
</form>

@endsection