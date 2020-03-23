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
@if (!empty($message))
<p> {{ $message }} </p>
@endif

@if (!empty($error_message))
<p> Lỗi xảy ra: {{ $error_message }} </p>
@endif

@if (!empty($codes))
{{ print_r($codes) }}
@endif
</div>
</div>
</div>
</section>
@endsection
