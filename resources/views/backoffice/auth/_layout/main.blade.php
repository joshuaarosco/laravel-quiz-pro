<!DOCTYPE html>
<html>
<head>
  <meta content="text/html; charset=utf-8" http-equiv="content-type">
  <meta charset="utf-8">
  <title>Login | {{env('APP_NAME')}}</title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" name="viewport">
  <script src="{{asset('cdn-cgi/apps/head/8jwJmQl7fEk_9sdV6OByoscERU8.js')}}">
  </script>
  <link href="{{asset('pages/ico/60.png')}}" rel="apple-touch-icon">
  <link href="{{asset('pages/ico/76.png')}}" rel="apple-touch-icon" sizes="76x76">
  <link href="{{asset('pages/ico/120.png')}}" rel="apple-touch-icon" sizes="120x120">
  <link href="{{asset('pages/ico/152.png')}}" rel="apple-touch-icon" sizes="152x152">
  <link href="favicon.ico" rel="icon" type="image/x-icon">
  <meta content="yes" name="apple-mobile-web-app-capable">
  <meta content="yes" name="apple-touch-fullscreen">
  <meta content="default" name="apple-mobile-web-app-status-bar-style">
  <meta content="" name="description">
  <meta content="" name="author">
  @include('backoffice.auth._includes.styles')
  <style>
    .login-wrapper {
      background: url({{ asset('assets/img/quizpro-bg.jpg') }});
    }
  </style>
</head>
<body class="fixed-header menu-pin menu-behind">
  @stack('content')
  @include('backoffice.auth._includes.scripts')
</body>
</html>
