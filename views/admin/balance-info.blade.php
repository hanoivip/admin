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
						<h4>Have no any payment</h4>
					@else
						@foreach ($balances as $bal)
							<p>Balance type:{{$bal->balance_type}}</p>
							<p>Amount:{{$bal->balance}}</p>
						@endforeach
					@endif
					
				</div>
				
	            <div class="box-header with-border">
	              <h3 class="box-title">Webcoins</h3>
	            </div>
	            <form role="form" method="POST" action="{{ route('balance-add') }}">
	            	{{ csrf_field() }}
	            	<input id="tid" name="tid" type="hidden" value="{{$tid}}">
	              <div class="box-body">
	                <div class="form-group">
	                  <input id="balance" name="balance" type="text" class="form-control" placeholder="Amount to add">
	                </div>
	                <div class="form-group">
	                  <input id="reason" name="reason" type="hidden" class="form-control" placeholder="Add Reason" value="admin panel">
	                </div>
	              </div>
	              <div class="box-footer">
	                <button type="submit" class="btn btn-primary">Add coin</button>
	              </div>
	            </form>
	            
	            <form role="form" method="POST" action="{{ route('balance-remove') }}">
	            	{{ csrf_field() }}
	            	<input id="tid" name="tid" type="hidden" value="{{$tid}}">
	              <div class="box-body">
	                <div class="form-group">
	                  <input id="balance" name="balance" type="text" class="form-control" placeholder="Amount to remove">
	                </div>
	                <div class="form-group">
	                  <input id="reason" name="reason" type="hidden" class="form-control" placeholder="Remove Reason" value="admin panel">
	                </div>
	              </div>
	              <div class="box-footer">
	                <button type="submit" class="btn btn-primary">Remove coin</button>
	              </div>
	            </form>
	            
	            <div class="box-footer">
	               {{-- 
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
        			@endif --}}
        			@if (Route::has('ecmin.webtopup.history'))
            			<form method="POST" action="{{ route('ecmin.webtopup.history') }}">
            					{{ csrf_field() }}
            						<input id="tid" name="tid" type="hidden" value="{{$tid}}">
            						<button class="btn btn-primary" type="submit">LS Nạp WebTopup</button>
            			</form>
        			@endif
        			@if (Route::has('ecmin.balance.history'))
            			<form method="POST" action="{{ route('ecmin.balance.history') }}">
            					{{ csrf_field() }}
            						<input id="tid" name="tid" type="hidden" value="{{$tid}}">
            						<button class="btn btn-primary" type="submit">LS Chuyển Xu</button>
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