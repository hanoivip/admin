@extends('hanoivip::admin.layouts.admin')

@section('title', 'Quan ly')

@section('content')

<div>
	<h2 class="content_title">
		<span class="titlebullet zidsprt"></span>Thông tin chung
	</h2>
	<div id="personal">
		<div class="inforow">
			<label>Họ tên</label>

			<div class="infotext"
				style="overflow: hidden; word-wrap: break-word;">
				@if (!empty($personal->hoten)) 
				{{ $personal->hoten }} 
				@else 
				(Chưa thiết lập) 
				@endif</div>
		</div>
		<div class="inforow" id="gender">
			<label>Giới tính:</label>
			<div class="infotext">
			@if (!empty($personal->sex)) 
			{{ $personal->sex }} 
			@else 
			(Chưa thiết lập) 
			@endif</div>
		</div>
		<div class="inforow">
			<label>Ngày sinh:</label>
			<div class="infotext">
			@if (!empty($personal->birthday)) 
			{{ $personal->birthday }} 
			@else 
			(Chưa thiết lập) 
			@endif</div>
		</div>
		<div class="inforow">
			<label>Địa chỉ:</label>
			<div style="overflow: hidden; word-wrap: break-word;"
				class="infotext">
				@if (!empty($personal->address)) 
				{{ $personal->address }} 
				@else 
				(Chưa thiết lập) 
				@endif</div>
		</div>
		<div class="inforow">
			<label> Tỉnh/Thành phố:</label>
			<div class="infotext">
			@if (!empty($personal->address)) 
			{{ $personal->address }} 
			@else 
			(Chưa thiết lập) 
			@endif</div>
		</div>
		<div class="inforow">
			<label>Nghề nghiệp:</label>
			<div class="infotext">
			@if (!empty($personal->career)) 
			{{ $personal->career }} 
			@else 
			(Chưa thiết lập) 
			@endif</div>
		</div>
		<div class="inforow">
			<label>Tình trạng hôn nhân:</label>
			<div class="infotext">
			@if (!empty($personal->mariage)) 
			{{ $personal->mariage }} 
			@else 
			(Chưa thiết lập) 
			@endif</div>
		</div>
	</div>
</div>

<div>
	<p>Thông tin bảo mật</p>
	Email bao mat:
	@if (!empty($secure->email))
		@if (!empty($secure->email_verified))
			Da xac thuc
		@else
			Chua xac thuc
		@endif
	@else
		Chua thiet lap
	@endif
	
	Mat khau game:
	@if (!empty($secure->pass2))
		Da thiet lap
	@else
		Chua thiet lap
	@endif
	
	Cau hoi bao mat:
	@if (!empty($secure->answer))
		Da thiet lap
	@else
		Chua thiet lap
	@endif
</div>

<div>
	<p>Các thao tác</p>
	<form method="POST" action="{{ route('user-reset-pass') }}">
	{{ csrf_field() }}
		<input id="tid" name="tid" type="hidden" value="{{$tid}}">
		<button type="submit">Reset Pass</button>
	</form>
	<form method="POST" action="{{ route('balance-add') }}">
	{{ csrf_field() }}
		<input id="tid" name="tid" type="hidden" value="{{$tid}}">
		So tien: <input id="balance" name="balance" type="text">
		Ly do: <input id="reason" name="reason" type="text">
		<button type="submit">Add Balance</button>
	</form>
	<form method="GET" action="{{ route('user-logas') }}">
	{{ csrf_field() }}
		<input id="tid" name="tid" type="hidden" value="{{$tid}}">
		<button type="submit">Logas</button>
	</form>
	<form method="POST" action="{{ route('user-band') }}">
	{{ csrf_field() }}
		<input id="uid" name="uid" type="hidden" value="{{$tid}}">
		<input id="message" name="message" type="text">
		<input id="release" name="release" type="text">
		<button type="submit">Band</button>
	</form>
	<form method="POST" action="{{ route('user-unband') }}">
	{{ csrf_field() }}
		<input id="uid" name="uid" type="hidden" value="{{$tid}}">
		<button type="submit">Unband</button>
	</form>
	<form method="POST" action="{{ route('user-message') }}">
	{{ csrf_field() }}
		<input id="uid" name="uid" type="hidden" value="{{$tid}}">
		<input id="message" name="message" type="text">
		<button type="submit">Send Message</button>
	</form>
</div>

@endsection