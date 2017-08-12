<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title id="title">Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
        #map-canvas {
            opacity: 0.07;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  z-index: 2;
}
            html, body {
                background-color: #4a4a4a;

                color: #9e9e9e;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
                    z-index: 1;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
                z-index: 3
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 40px;
            }

            .subtitle {
                font-size: 20px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            #img{
                position: absolute;
                opacity: .1;
                width: 100%;
                height: 100%;
            }
        </style>
    </head>
    <body>
        @if (Route::has('login'))
            <div class="top-right links">
                <a href="{{ url('/login') }}">Login</a>
            </div>
        @endif
        <div class="flex-center position-ref full-height">



            <div class="content">
                <div class="title m-b-md">
                    <img width="100"src="images/map-marker-icon.png" alt="">
                </div>
                <div class="title m-b-md">
                    USAMEXGPS RASTREO SATELITAL PC
                </div>
                <div class="subtitle m-b-md">
                    PROXIMAMENTE
                </div>
            </div>
        </div>
        <div id='map-canvas'></div>
    </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>

<script type="text/javascript">
  var mapOptions = {
    zoom: 13,
    center: new google.maps.LatLng(25.683488, -100.317341),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);



</script>
