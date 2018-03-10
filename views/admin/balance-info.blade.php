@extends('hanoivip::admin.layouts.admin')

@section('title', 'Thong tin tai khoan')

@section('content')

@if (empty($balances))
(( Chua co tai khoan nao ))
@else
Longheo TODO: hien thi cac loai tai khoan va gia tri
@foreach ($balances as $bal)
<p>Loại tài khoản:</p>{{$bal->balance_type}} <br/>
<p>Số dư:</p>{{$bal->balance}} <br/>
@endforeach
@endif

<form method="POST" action="{{ route('balance-add') }}">
	{{ csrf_field() }}
		<input id="tid" name="tid" type="hidden" value="{{$tid}}">
		So tien: <input id="balance" name="balance" type="text">
		Ly do: <input id="reason" name="reason" type="text">
		<button type="submit">Add Balance</button>
</form>

<form method="GET" action="{{ route('balance-history') }}">
	{{ csrf_field() }}
		<input id="tid" name="tid" type="hidden" value="{{$tid}}">
		<button type="submit">View History</button>
</form>

<form method="POST" action="{{ route('user-detail') }}">
{{ csrf_field() }}
	<input id="tid" name="tid" type="hidden" value="{{$tid}}">
	<button type="submit">Quay lai</button>
</form>
	
@endsection