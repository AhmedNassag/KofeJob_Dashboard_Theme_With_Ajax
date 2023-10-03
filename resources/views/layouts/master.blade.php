<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
	<head>
		@include('layouts.head')
	</head>
	<body>
		@auth
			@include('layouts.main-header')
			@include('layouts.main-sidebar')
		@endauth
		@yield('content')
		@include('layouts.footer-scripts')
  </body>
</html>