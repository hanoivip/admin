@extends('hanoivip::admin.layouts.admin')

@section('title', 'Kiểm tra hoạt động')

@section('content')

<form method="POST" action="{{ route('event.test.topup') }}">
	{{ csrf_field() }}
		<input id="tid" name="tid" type="hidden" value="{{$tid}}">
		Giá trị thẻ: <input id="topup" name="topup" value="10000">
		<button type="submit">Giả lập nạp thẻ</button>
</form>

<form method="POST" action="{{ route('event.test.recharge') }}">
	{{ csrf_field() }}
		<input id="tid" name="tid" type="hidden" value="{{$tid}}">
		Giá trị xu:<input id="recharge" name="recharge" value="10000">
		Server: <input id="svname" name="svname" value="s1">
		Nhân vật:<input id="role" name="role" value="">
		<button type="submit">Giả lập chuyển xu</button>
</form>
	
@endsection