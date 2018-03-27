<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ app()->getLocale() }}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Admin - @yield('title')</title>
</head>

<body>

Quan ly nguoi dung
<a href="{{ route('user-find') }}">Tim kiem</a>

Quan ly may chu
<a href="{{ route('server-info') }}">Danh sach</a>

Quan ly web
<a href="{{ route('site-status') }}">Trang thai</a>


@yield('content')

</body></html>
