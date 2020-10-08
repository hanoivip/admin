@extends('hanoivip::admin.layouts.admin')

@section('title', 'Nạp thẻ hộ người chơi')

@section('content')

<form method="post" action="{{ route('admin-recharge-do') }}">
{{ csrf_field() }}
<input type="hidden" name="tid" value="{{$tid}}"/>
	<p>Chọn máy chủ:</p>
	<select id="svname" name="svname"
		onchange="document.location.href='{{ route('admin-recharge') }}?svname=' + this.value + '&tid={{$tid}}'">
		@foreach ($servers as $sv)
			@if (isset($selected) && $sv->name == $selected)
				<option value="{{ $sv->name }}" selected>{{ $sv->title }}</option>
			@else
				<option value="{{ $sv->name }}">{{ $sv->title }}</option>
			@endif
		@endforeach
	</select>
	<p>Chọn số tiền:</p>
	<select id="package" name="package">
		@foreach ($packs as $p)
			<option value="{{ $p->code }}">{{ $p->title }}</option>
		@endforeach
	</select>
	@if (!empty($roles))
        <p>Chọn nhân vật:</p>
        <select id="roleid" name="roleid">
        	@foreach ($roles as $roleid => $rolename)
        		<option value="{{ $roleid }}">{{ $rolename }}</option>
        	@endforeach
        </select>
    @else
    	<p>Chưa có nhân vật nào trong sv này!</p>
    @endif
	<br/>
	<button type="submit">Chuyển Xu</button>
</form>
	
@endsection