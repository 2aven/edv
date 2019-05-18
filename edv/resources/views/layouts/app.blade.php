<!doctype html>
<html lang="{{ config( 'app.locale','ca') }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>{{config('app.name','eDv')}}</title>

  </head>
  <body>
    <div id="app">
      <div class="container">
        @include('inc.navbar')
        @yield('content')
      </div>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
  </body>
</html>