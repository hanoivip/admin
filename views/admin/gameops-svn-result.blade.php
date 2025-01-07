@extends('hanoivip::admin.layouts.admin')

@section('title', 'Svn result..')

@section('content')

@if (!empty($files))
    @foreach($files as $f)
    <p>{{$f}}</p>
    @endforeach
@endif

@endsection