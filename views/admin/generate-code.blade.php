@extends('hanoivip::admin.layouts.admin')

@section('title', 'Admin sinh mã')

@section('content')
<section class="content-header">
  <h4>
    Gift
  </h4>
</section>
 <section class="content">
    <div class="row">
      	<div>
      		<div class="box box-primary">
				<form method="POST" action="{{ route('gift.batch-generate') }}">
					{{ csrf_field() }}
					Chọn gói/hoạt động:
					<select id="package" name="package">
					@foreach ($packages as $pkg)
						<option value="{{$pkg->pack_code}}">{{$pkg->name}}</option>
					@endforeach
					</select>
					Số lượng mã:
					<input id="count" name="count" value="20" />
					<button type="submit" class="btn btn-primary">Sinh mã</button>
				</form>
			</div>
    	</div>
    </div>
</section>
@endsection
