<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>@stack('title') | {{config('app.name')}}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
<script src="{{asset('cdn-cgi/apps/head/8jwJmQl7fEk_9sdV6OByoscERU8.js')}}"></script>
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/img/favicons/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/img/favicons/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/img/favicons/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/favicons/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/img/favicons/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/favicons/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/img/favicons/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/img/favicons/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-icon-180x180.png') }}">
<link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('assets/img/favicons/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/favicons/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset('assets/img/favicons/ms-icon-144x144.png') }}">
<meta name="theme-color" content="#ffffff">
<meta content="" name="description" />
<meta content="" name="author" />
@include('backoffice._includes.styles')
@stack('css')
</head>
<body class="fixed-header dashboard menu-pin {{-- menu-unpinned menu-behind --}}">
	@include('backoffice._components.nav')
	<div class="page-container">
		@include('backoffice._components.header')
		<div class="page-content-wrapper">
            @include('backoffice._components.page_load')
			@stack('content')
			@include('backoffice._components.footer')
		</div>
	</div>
	@include('backoffice._components.quick_view')
	@include('backoffice._components.search')
    @include('commons.modal',['logout' => route('backoffice.logout')])
    @include('backoffice._components.modal')
    @include('backoffice._includes.scripts')
    @stack('js')
</body>
</html>
