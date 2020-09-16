<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Landing Page</title>
    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,200;0,300;0,400;0,600;0,700;1,100;1,200;1,300;1,600;1,700&display=swap" rel="stylesheet">

</head>
<style>
.title{
    text-shadow: 3px 1px 4px #0f5cc3;
    font-family: 'Raleway';
    font-size: 54px;
    color: #ffffff;
    font-weight: 600;
    line-height: 137%;
}
.text{
    font-family: 'Raleway';
    color: grey;
    font-size: 21px;
    line-height: 150%;

}
.title2{
    font-family: 'Raleway';
    color: #5e99ea;
    font-size: 28px;
    font-weight: 600;
    line-height: 150%;
}
.title3{
    font-family: 'Raleway';
    color: #5e99ea;
    font-size: 18px;
    font-weight: 600;
    line-height: 150%;
}
#show_bg_2 {
    background-image: linear-gradient(to bottom, rgb(245 246 252 / 0%), rgb(37 37 68)), url(/images/datcover.png);
    height: 400px;
    background-size: cover;
    color: white;
}
</style>
<body>
<div class="container-fluid" style="background: #0026ff;  /* fallback for old browsers */
background: -webkit-linear-gradient(to top, #452ff9, #0026ff);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to top, #452ff9, #0026ff) /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
">
<header class="container" style="    padding-bottom: 20px;
    padding-top: 10px;">
        <div class="row">
            <div class="col-md-12">
                <h1 class="title">
                Mejora tu logística monitoreando tus unidades en vivo las 24 horas
                </h1>
            </div>
        </div>
    </header>
    </div>
   
    <div class="container">
        <div class="row"  style="padding-top: 30px;">
            <section class="col-md-6" id="show_bg_2"style="    padding: 20px 0 0 0px;">
        
            </section>
            <aside class="col-md-6" style="    padding: 0px 0 0 30px;">
            <h2 class="title2">Evita robos y malas prácticas con tus unidades de transporte.</h2>
            <p class="text"> Digital Admin Track te ofrece el mejor 
            de los servicios de rastreo con equipos de calidad, 
            la plataforma más moderna y la posibilidad de moldear
             tus necesidades a nuestro sistema.</p>

            <p class="title3">Con nuestra plataforma obtendrás:</p>
                <ul class="title3">
                <li>Botón de pánico </li>
                <li>Bloqueo de motor
                <li>Reporte de trayectoria</li>
                <li>Detección de anclaje</li>
                <li>Seguimiento de remolques las 24 hrs</li>
            </ul>

            <p class="title3">Entre otros beneficios más.</p>

            </aside>
        </div>
    </div>

@yield('content')
@section('script')
@show
<script>
    $('.client_select').change(function(){
        console.log('cambio')
    })

</script>

</body>
</html>
