<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Digital Admin Track</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/usamex.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,900i" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body style="background: #005ddc;">
    <div id="app">
     

        @yield('content')
    </div>
    <style type="text/css">
        body{
            font-family: Raleway !important;
        }
    </style>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <!-- Google Maps JS API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
    <script src="/js/gmaps.min.js"></script>
    <script src="/js/map.js"></script>
    <script src="/js/functions.js"></script>
</body>
</html>
