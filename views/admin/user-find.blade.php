@extends('hanoivip::admin.layouts.admin')

@section('title', 'Find user')

@section('content')

<section class="content-header">
  <h4>
    Manager users<small>Search</small>
  </h4>
</section>
 <section class="content">
    <div class="row">
      	<div>
      		<div class="box box-primary">
				<form method="POST" action="{{ route('user-detail') }}">
				{{ csrf_field() }}
					<div class="box-body">
		                <div class="form-group">
		                	<input id="tid" name="tid" type="text" value="{{ old('tid') }}" class="form-control" placeholder="User ID/Username/Email" required autofocus>
		                </div>
		            </div>
		            <div class="box-footer">
							<button type="submit" class="btn btn-primary">Find</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

@endsection