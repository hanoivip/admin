@extends('hanoivip::admin.layouts.admin')

@section('title', 'Lich su nap & chuyen')

@section('content')

@if (empty($submits))
(( Chua nap bao gio ))
@else

Longheo: TODO: hien thi danh sach may chu
@for ($j=0; $j<count($submits); $j++)
{{ print_r($submits[$j]) }}
@endfor

@endif

@if (empty($mods))
(( Chua chuyen xu bao gio ))
@else

Longheo: TODO: hien thi danh sach may chu
@for ($j=0; $j<count($mods); $j++)

{{ print_r($mods[$j]) }}

@endfor

@endif


<form method="GET" action="{{ route('balance-info') }}">
	<input id="tid" name="tid" type="hidden" value="{{$tid}}">
	<button type="submit">Quay lai</button>
</form>
	
@endsection