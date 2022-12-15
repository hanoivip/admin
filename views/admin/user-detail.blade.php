@extends('hanoivip::admin.layouts.admin')

@section('title', 'User management')

@section('content')
<style type="text/css">
	form{
		float: left;
    margin-right: 10px;

	}
</style>
<section class="content-header">
  <h2>User Management</h2>
</section>
 <section class="content">
    <div class="row">
    	<div class="col-sm-12">
    		
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
            	<h3>Các thao tác</h3>
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
            </div>
</div>
</div>
</section>
@endsection