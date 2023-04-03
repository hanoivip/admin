@extends('hanoivip::admin.layouts.admin')

@section('title', 'Kết quả tạo mã')

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

                @if (!empty($codes))
                {{ print_r($codes) }}
                @endif
			</div>
		</div>
	</div>
</section>
@endsection
