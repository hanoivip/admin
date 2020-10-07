@extends('hanoivip::admin.layouts.admin')

@section('title', 'Quan ly')

@section('content')
<style type="text/css">
	form{
		float: left;
    margin-right: 10px;

	}
</style>
<section class="content-header">
  <h4>
    Thông tin chung
  </h4>
</section>
 <section class="content">
    <div class="row">
    	<div class="col-sm-12">
    		<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                <thead>
	                <tr role="row">
	                	<th class="sorting">Họ tên</th>
	                	<th class="sorting">Giới tính</th>
	                	<th class="sorting">Ngày sinh</th>
	                	<th class="sorting">Địa chỉ</th>
	                	<th class="sorting">Tỉnh/Thành phố</th>
	                	<th class="sorting">Nghề nghiệp</th>
	                	<th class="sorting">Tình trạng hôn nhân</th>
	                </tr>
                </thead>
                <tbody>     
	                <tr role="row" class="odd">
	                  	<td>
		                  	@if (!empty($personal['hoten'])) 
								{{ $personal['hoten'] }} 
							@else 
								(Chưa thiết lập) 
							@endif
						</td>
		                <td>
		                	@if (!empty($personal['sex'])) 
								{{ __('credential.personal.sex' . $personal['sex'])}}
							@else 
								(Chưa thiết lập) 
							@endif
						</td>
		                <td>
		                	@if (!empty($personal['birthday'])) 
								{{ $personal['birthday'] }} 
							@else 
								(Chưa thiết lập) 
							@endif
		                </td>
		                <td>
		                	@if (!empty($personal['address'])) 
								{{ $personal['address'] }} 
							@else 
								(Chưa thiết lập) 
							@endif
	                	</td>
		                <td>
		                	@if (!empty($personal['city'])) 
								{{ __('credential.personal.city' . $personal['city'])}}
							@else 
								(Chưa thiết lập) 
							@endif
						</td>
						<td>
							@if (!empty($personal['career'])) 
							{{ __('credential.personal.career' . $personal['career'])}}
							@else 
							(Chưa thiết lập) 
							@endif
						</td>
						<td>
							@if (!empty($personal['mariage'])) 
							{{ __('credential.personal.marriage' . $personal['mariage'])}}
							@else 
							(Chưa thiết lập) 
							@endif
						</td>
	                </tr>
	            </tbody>
            </table>
            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                <thead>
	                <tr role="row">
	                	<th class="sorting">Email bảo mật</th>
	                	<th class="sorting">Mật khẩu bảo mật</th>
	                	<th class="sorting">Câu hỏi bảo mật</th>
	                </tr>
                </thead>
                <tbody>     
	                <tr role="row" class="odd">
	                  	<td>
		                  	@if (!empty($secure['email']))
								@if (!empty($secure['email_verified']))
									Đã xác thực
								@else
									Chưa xác thực
								@endif
							@else
								Chưa thiết lập
							@endif
						</td>
		                <td>
		                	@if (!empty($secure['pass2']))
								Đã thiết lập
							@else
								Chưa thiết lập
							@endif
						</td>
		                <td>
		                	@if (!empty($secure['answer']))
								Đã thiết lập
							@else
								Chưa thiết lập
							@endif
		                </td>
	                </tr>
	            </tbody>
            </table>
        


<div id='action'>
	<h2>Các thao tác</h2>
	<div class="action_form">
		<form method="POST" action="{{ route('user-reset-pass') }}">
		{{ csrf_field() }}
			<input id="tid" name="tid" type="hidden" value="{{$tid}}">
			<button type="submit" class="btn btn-primary">Reset mật khẩu</button>
		</form>
	</div>
	<div>
    	<form method="GET" action="{{ route('balance-info') }}">
    		<input id="tid" name="tid" type="hidden" value="{{$tid}}">
    		<button type="submit" class="btn btn-primary">Tài khoản xu</button>
    	</form>
	</div>
	<div class="action_form">
		<form method="GET" action="{{ route('admin-recharge') }}">
			<input id="tid" name="tid" type="hidden" value="{{$tid}}">
			<button type="submit" class="btn btn-primary">Chuyển xu hộ</button>
		</form>
	</div>
	<div class="action_form">
		<form method="GET" action="{{ route('user-logas') }}">
			<input id="tid" name="tid" type="hidden" value="{{$tid}}">
			<button type="submit" class="btn btn-primary">Logas</button>
		</form>
	</div>
	<div class="action_form">
		<form method="GET" action="{{ route('event.test') }}">
			<input id="tid" name="tid" type="hidden" value="{{$tid}}">
			<button type="submit" class="btn btn-primary">Test Khuyen Mai</button>
		</form>
	</div>
	<div class="action_form">
		<form method="POST" action="{{ route('user-unband') }}">
		{{ csrf_field() }}
			<input id="uid" name="uid" type="hidden" value="{{$tid}}">
			<button type="submit" class="btn btn-primary">Unban User</button>
		</form>
	</div>
	<div class="action_form">
		<form method="POST" action="{{ route('user-band') }}" style="width: 100%">
		{{ csrf_field() }}
			<input id="uid" name="uid" type="hidden" value="{{$tid}}">
			<input id="message" name="message" type="text" placeholder="Lí Do">
			<input type="date"  name="release" id="release" value=""  placeholder="Ngày Cấm" />
			<button type="submit" class="btn btn-primary">Ban User</button>
		</form>
	</div>
	<div class="action_form">
		<form method="POST" action="{{ route('user-message') }}" style="width: 100%">
		{{ csrf_field() }}
			<input id="uid" name="uid" type="hidden" value="{{$tid}}">
			<input id="message" name="message" type="text">
			<button type="submit" class="btn btn-primary">Send Message</button>
		</form>
	</div>
</div>
</div>
</div>
</section>
@endsection