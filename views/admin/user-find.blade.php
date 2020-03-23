@extends('hanoivip::admin.layouts.admin')

@section('title', 'Quan ly')

@section('content')

<section class="content-header">
  <h4>
    Quản lý tài khoản<small>Search</small>
  </h4>
</section>
 <section class="content">
    <div class="row">
      	<div>
      		<div class="box box-primary">
				@if (!empty($error_message))
				<p> {{ $error_message }} </p>
				@endif

				<form method="POST" action="{{ route('user-detail') }}">
				{{ csrf_field() }}
					<div class="box-body">
		                <div class="form-group">
		                	<input id="tid" name="tid" type="text" value="{{ old('tid') }}" class="form-control" placeholder="Nhập ID người dùng" required autofocus>
		                </div>
		            </div>
		            <div class="box-footer">
							<button type="submit" class="btn btn-primary">Tìm kiếm</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

@endsection