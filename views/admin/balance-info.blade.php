@extends('hanoivip::admin.layouts.admin')

@section('title', 'Thong tin tai khoan')

@section('content')
<section class="content-header">
  <h4>
    Thông Tin Tài Khoản
    <small>Xu</small>
  </h4>
</section>
 <section class="content">
    <div class="row">
      	<div>
      		<div class="box box-primary">
      			<div class="box-header with-border">
      				@if (empty($balances))
						<h4>(( Chưa có tài khoản ))</h4>
					@else
						@foreach ($balances as $bal)
						<h4><p>Loại tài khoản:{{$bal->balance_type}}</p></h4>
						<h4><p>Số dư:{{$bal->balance}}</p></h4>
						@endforeach
					@endif
					
				</div>
	            <div class="box-header with-border">
	              <h3 class="box-title">Quản lý xu</h3>
	            </div>
	            <!-- /.box-header -->
	            <!-- form start -->
	            <form role="form" method="POST" action="{{ route('balance-add') }}">
	            	{{ csrf_field() }}
	            	<input id="tid" name="tid" type="hidden" value="{{$tid}}">
	              <div class="box-body">
	                <div class="form-group">
	                  <label>Số xu</label>
	                  <input id="balance" name="balance" type="text" class="form-control" placeholder="Nhập số xu">
	                </div>
	                <div class="form-group">
	                  <label>Lý Do</label>
	                  <input id="reason" name="reason" type="text" class="form-control" placeholder="Nhập lý do">
	                </div>
	              </div>
	              <div class="box-footer">
	                <button type="submit" class="btn btn-primary">Add xu</button>
	              </div>
	            </form>
	            
	            <div class="box-footer">
    	            @if (Route::has('ecmin.topup.history'))
                        <form method="POST" action="{{ route('ecmin.topup.history') }}">
            					{{ csrf_field() }}
            						<input id="tid" name="tid" type="hidden" value="{{$tid}}">
            						<button class="btn btn-primary" type="submit">View History - OldFlow</button>
            			</form>
        			@endif
        			@if (Route::has('ecmin.newrecharge.history'))
            			<form method="POST" action="{{ route('ecmin.newrecharge.history') }}">
            					{{ csrf_field() }}
            						<input id="tid" name="tid" type="hidden" value="{{$tid}}">
            						<button class="btn btn-primary" type="submit">View History - NewFlow</button>
            			</form>
        			@endif
		            <form method="POST" action="{{ route('user-detail') }}">
					{{ csrf_field() }}
						<input id="tid" name="tid" type="hidden" value="{{$tid}}">
						<button type="submit" class="btn btn-primary">Quay lại</button>
					</form>
          		</div>
          		
          	</div>
      	</div>
    </div>
</section>
@endsection