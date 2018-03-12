@extends('hanoivip::admin.layouts.admin')

@section('title', 'Danh sach may chu')

@section('content')

@if (empty($servers))
(( Chua co sv nao ))
@else

Longheo: TODO: hien thi danh sach may chu
@for ($j=0; $j<count($servers); $j++)

{{ print_r($servers[$j]) }}

<form method="POST" action="{{ route('server-remove') }}">
{{ csrf_field() }}
	<input id="ident" name="ident" type="hidden" value="{{$servers[$j]->ident}}">
	<button type="submit">Xoa</button>
</form>

@endfor

@endif

<form method="POST" action="{{ route('server-add') }}">
{{ csrf_field() }}
	Server name (s1, s2,...) (khong trung lap)
	<input id="name" name="name" type="text">
	Server ident (1, 2, 3..) (khong trung lap)
	<input id="ident" name="ident" type="text">
	Ten hien thi
	<input id="title" name="title" type="text">
	Mieu ta
	<input id="description" name="description" type="text">
	Login Uri
	<input id="login_uri" name="login_uri" type="text">
	Recharge Uri
	<input id="recharge_uri" name="recharge_uri" type="text">
	Operate Uri
	<input id="operate_uri" name="operate_uri" type="text">
	
	<button type="submit">Them</button>
</form>

<form method="GET" action="{{ route('user-find') }}">
{{ csrf_field() }}
	<button type="submit">Quay lai</button>
</form>
	
@endsection