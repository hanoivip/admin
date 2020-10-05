@extends('hanoivip::admin.layouts.admin')

@section('title', 'Lich su nap & chuyen')

@section('content')
<main class="main fixCen cf">
    <div class="lnews_left">
        <div class="cf">
            <a href="javascript:void(0);" class="spr main_dl-btdl main_dl-ios controlDownload"></a>
            <a href="javascript:void(0);" class="spr main_dl-btdl main_dl-gg controlDownload"></a>
            <a href="javascript:void(0);" class="spr main_dl-btdl main_dl-apk controlDownload"></a>
        </div>
    </div>
    <div class="lnews_right"><div class="lnews_right_ct">
<style type="text/css">
	.ListServer li ul{
		width: 100%;
	}
	.ListServer li ul li{
		width: 24%;
		color:black;
		text-align: center;
		margin: 0;
		border: 1px solid black;
		height: 30px;
		line-height: 30px;
		float: left;
		font-size: 14px;
        list-style: none;
	}
	#recharge li{
		width: 24%;
		color:black;
		text-align: center;
		margin: 0;
		border: 1px solid black;
		height: 30px;
	}
</style>
<div class="content">
<div class="title">Lịch sử nạp thẻ</div>
@if (empty($submits))
<p>Chưa từng nạp thẻ</p>
@else

<table>
	<tr>
		<th>Trạng thái</th>
		<th>Mã Thẻ</th>
		<th>Giá trị đã chọn</th>
		<th>Giá trị thẻ</th>
		<th>Phạt</th>
		<th>Thực nhận</th>
		<th>Thời gian</th>
	</tr>
    @foreach ($submits as $submit)
    <tr>
        <td>{{$submit->status}}</td>
        <td>{{$submit->password}}</td>
        <td>{{$submit->dvalue}}</td>
        <td>{{$submit->value}}</td>
        <td>{{$submit->penalty}}</td>
        <td>{{ min($submit->dvalue, $submit->value) * (100 - $submit->penalty) / 100 }}</td>
        <td>{{$submit->time}}</td>
    </tr>
    @endforeach
</table>

@endif
<div class="title">Lịch sử nhận khuyến mãi và mua xu game</div>
@if (empty($mods))
<p>Chưa từng chuyển xu</p>
@else

<table>
<tr>
    <th>Loại</th>
    <th>Số xu</th>
    <th>Lý do</th>
    <th>Thời gian</th>
</tr>
@foreach ($mods as $mod)
<tr>
    <td>{{$mod->acc_type}}</td>
    <td>{{$mod->balance}}</td>
    <td>{{$mod->reason}}</td>
    <td>{{$mod->time}}</td>
</tr>
@endforeach
</table>

@endif


<form method="GET" action="{{ route('balance-info') }}">
	<input id="tid" name="tid" type="hidden" value="{{$tid}}">
	<button type="submit">Quay lai</button>
</form>
	
@endsection