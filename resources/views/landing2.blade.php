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
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,200;0,300;0,400;0,600;0,700;1,100;1,200;1,300;1,600;1,700&display=swap" rel="stylesheet">

</head>
<style>
.fa {
  padding: 10px;
    font-size: 16px;
    width: 34px;
    text-align: center;
    text-decoration: none;
    background: #0450b9;
  color: white;
}

/* Add a hover effect if you want */
.fa:hover {
  opacity: 0.7;
   color: #c1c1c1;
    text-decoration: none;
}

/* Set a specific color for each brand */

/* Facebook */
.fa-facebook {
  
}

/* Twitter */
.fa-twitter {
  background: #55ACEE;
  color: white;
}
.footer{
     
    padding-bottom:15px;
    background-color:#1f1f1f;
    margin-top:30px;
}
.title{
     
    font-family: 'Raleway';
    font-size: 40px;
    color: #ffffff;
    font-weight: 600;
    line-height: 137%;
}
.text{
    font-family: 'Raleway';
    color: #8e8e8e;
    font-size: 16px;
    line-height: 150%;

}
.wave{
    position:absolute;
    bottom:0;
    left:0
}
.title2{
    font-family: 'Raleway';
    color: #0096ff;
    font-size: 18px;
    font-weight: 600;
    line-height: 150%;
}
.title3{
    font-family: 'Raleway';
    color: #0096ff;
    font-size: 16px;
    font-weight: 600;
    line-height: 150%;
}
.testimonial_fa{
  color: #005ddc;
    background: transparent !important;
    font-size: 20px;x;
}
#show_bg_2 {
    background-image: linear-gradient(to bottom, rgb(245 246 252 / 0%), rgb(37 37 68)), url(/images/datcover.png);
    height: 400px;
    background-size: cover;
    color: white;
}
.bg-prim{
    background: linear-gradient(to top, #46aaff, #0026ff),url(/images/datcover.png);
}
.gr{
  color:#005ddc
}
.te{
  font-weight:bold
}
.wirld{
    background-repeat:no-repeat;
    background-size:contain;
    background-image:url(/images/wave3.svg);
    }
    .logo{
    width:150px
}
 
.form-container{
    border: 1px solid #b1b1b1;
    background-color: white;
    border-radius: 6px;
    box-shadow: 0px 0px 25px #cccccc;
}
label{
    font-weight: 600;
    font-size: .875rem;
}
.right{
    text-decoration: underline;
    color: #cdcdcd!important;
}

.testimonial_subtitle{
    color: #0aaa7a;
    font-size: 12px;
}
  .testimonial_btn{
    background-color: #373d4b !important;
    color: #fff !important;
 }
 .seprator {
    height: 2px;
    width: 56px;
    background-color: #0aaa7a;
    margin: 7px 0 10px 0;
}
.what{
  margin: 0 auto;
    padding: 20px 26px;
    margin-top: 20px;
    background: #f3f3f3;
    border-radius: 8px;
    border: 1px solid #c1c1c1;
}
}
</style>
<body class="wirld">
<div class="container-fluid ">
<header class="container" style="padding-top: 20px; padding-bottom: 20px;">
        <div class="row">
        <div class="col-md-2" style="padding-top: 24px">
        <a href="http://digitaladmintrack.com/"><img style="width:120px" src="http://digitaladmintrack.com/images/logodatt.png"></a>

        </div>
            <div class="col-md-10">
                <h1 class="title">
                Mejora tu logística monitoreando tus unidades en vivo las 24 horas
                </h1>
            </div>
        </div>
    </header>
  
   
    <div class="container ">
        <div class="row"  style=" ">
            <section class="col-md-6"  style="    ">
                <img src="/images/dato.png" style="width:86%">
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
            <button class="btn btn-danger">Obtén tu prueba GRATUITA</button>
            </aside>

        </div>
    </div>
    </div>
    <!--<svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,192L48,170.7C96,149,192,107,288,90.7C384,75,480,85,576,122.7C672,160,768,224,864,224C960,224,1056,160,1152,165.3C1248,171,1344,245,1392,282.7L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    -->
    <div class="container " data-aos="fade-right">
        <div class="row">
            <div class="col-md-12 text-center" style="padding-top:150px">
                <h1>PONTE EN CONTACTO CON NOSOTROS</h1>
            </div>
            <div class="col-md-4 mt-40">
            <div class="row pt-5">
                <div class="col-md-12 col-sm-10 pt-4 pb-4 form-container">
                    <p class="te">Déjanos tus datos para ponernos en contacto contigo y agendar tu prueba <span class="gr"> GRATUITA</span></p>
          <form id="signupForm" action="" class="pt-3 needs-validation" novalidate>
            <div class="form-group">
              <label for="exampleInputEmail1">Nombre</label>
              <input
                type="text"
                class="was-validated form-control"
                id="name"
                placeholder="Ingresa un nombre"
                required
              />
              <div id="name-errors" class="invalid-feedback"></div>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Ciudad</label>
              <input
                type="number"
                class="form-control"
                
                placeholder="Ingresa una ciudad"
                required
              />
              <div id="edad-errors" class="invalid-feedback"></div>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Empresa</label>
              <input
                type="text"
                class="was-validated form-control"
                id="name"
                placeholder="Ingresa el nombre de tu empresa"
                required
              />
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Unidades</label>
              <input
                type="text"
                class="was-validated form-control"
                id="name"
                id="edad"
                onkeydown="javascript: return event.keyCode === 8 ||
                    event.keyCode === 46 ? true : !isNaN(Number(event.key))"
                placeholder="Ingresa la cantidad de unidades "
                required
              />
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Comentarios</label>
              <textarea class="form-control "></textarea>
            </div>

            <button type="submit" class="btn btn-primary is-valid" disabled>Enviar
            </button>
          </form>
                </div>
                <a href="https://wa.me/5218114114297?text=Hola%20me%20gustaría%20tener%20informacion%20del%20monitoreo%20gps" class="what">
                  O envíanos un Whatsapp
                <img style="width:30px" src="/images/whatsapp.png">
                 
                </a>
                
            </div>
            
        </div>

        <hr>
        <div class="col-md-8" style="padding-left: 50px;
    padding-top: 50px;">
       
        <h3><strong>Testimonios</strong></h3>
        <div class="seprator"></div>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <!-- Wrapper for slides -->
              <div class="carousel-inner">
                <div class="item active">
                  <div class="row" style="padding: 20px">
                    <p class="testimonial_para"><i class="fa fa-quote-left testimonial_fa" aria-hidden="true"></i> DAT es la plataforma que hemos eligido entre otras más, 
                    por su fácil manejo, es una aplicación muy intuitiva
                    y nuestras unidades estan siempre en linea</p><br>
                    <div class="row">
                    
                        <div class="col-sm-10">
                        <h4><strong>Andres Ibarra</strong></h4>
                        <p class="testimonial_subtitle"><span>Express 57</span><br>
                        <span>Jefe de Tráfico</span>
                        </p>
                    </div>
                    </div>
                  </div>
                </div>
               <div class="item">
                   <div class="row" style="padding: 20px">
                    
                    <p class="testimonial_para"><i class="fa fa-quote-left testimonial_fa" aria-hidden="true"></i> Gracias a la plataforma DAT, hemos podido reducir nuestros 
                    costos de operación detectando malos habitos de nuestros choferes, 
                    ademas de poder compartir con nuestros clientes la ubicación de nuestras unidades en tiempo real</p><br>
                    <div class="row">
                    
                        <div class="col-sm-10">
                        <h4><strong>Kiara Andreson</strong></h4>
                        <p class="testimonial_subtitle"><span>Chlinical Chemistry Technologist</span><br>
                        <span>Officeal All Star Cafe</span>
                        </p>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
       
               </div>


        </div>

        


    </div>
<div class="container-fluid footer">
<div class="row">
            <div class="col-md-4" style="padding-top:20px">
            <a href="http://digitaladmintrack.com/"><img style="width:120px" src="http://digitaladmintrack.com/images/logodatt.png"></a>
            </div>
            <div class="col-md-4 text-center" style="padding-top:20px">
            <a href="#" class="fa fa-facebook"></a>
<a href="#" class="fa fa-linkedin"></a>
<a href="#" class="fa fa-instagram"></a>
            </div>
            <div class="col-md-4"></div>
        </div>
</div>
@yield('content')
@section('script')
@show
<script>
  AOS.init();
</script>
<script>
$("button").on('click', function(e) {

    $('html, body').animate({
       scrollTop:700
     }, 700, function(){

  
       
     });

});
    $('.client_select').change(function(){
        console.log('cambio')
    })

</script>

</body>
</html>
