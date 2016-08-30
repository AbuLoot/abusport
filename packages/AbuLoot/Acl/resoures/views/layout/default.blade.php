<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ACL</title>
  <link rel="stylesheet" href="/vendor/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    @yield('content')
  </div>
  <script src="{!! asset('/vendor/jquery/dist/jquery.min.js') !!}"></script>
  <script src="{!! asset('/vendor/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
  @yield('scripts')
</body>
</html>