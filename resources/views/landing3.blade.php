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
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">

    <link media="all" type="text/css" rel="stylesheet" href="/css/swipper.css">

<script src="js/swiper.js"></script>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</head>
<style>
body{
    font-family:'Source Sans Pro' !important
}
.fa {
  padding: 10px;
    font-size: 16px;
    width: 34px;
    text-align: center;
    text-decoration: none;
    background: #0450b9;
  color: white;
}
.swiper-container {
    margin-left: auto;
    margin-right: auto;
    position: relative;
    overflow: hidden;
    z-index: 1;
}
img {
    border: none;
    outline: none;
    max-width: 100% !important;
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
     
   font-family:'Source Sans Pro';
    font-size: 40px;
    color: #ffffff;
    font-weight: 100;
    line-height: 137%;
}
.text{
   
    color: #a1d2ff;
    font-size: 16px;
    line-height: 150%;

}
.wave{
    position:absolute;
    bottom:0;
    left:0
}
.title2{
   
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    line-height: 150%;
}
.title3{
 
    color: #fff;
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
.bgd{
    background-color: #330033;
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 800 800'%3E%3Cg fill='none' stroke='%23404' stroke-width='1'%3E%3Cpath d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63'/%3E%3Cpath d='M-31 229L237 261 390 382 603 493 308.5 537.5 101.5 381.5M370 905L295 764'/%3E%3Cpath d='M520 660L578 842 731 737 840 599 603 493 520 660 295 764 309 538 390 382 539 269 769 229 577.5 41.5 370 105 295 -36 126.5 79.5 237 261 102 382 40 599 -69 737 127 880'/%3E%3Cpath d='M520-140L578.5 42.5 731-63M603 493L539 269 237 261 370 105M902 382L539 269M390 382L102 382'/%3E%3Cpath d='M-222 42L126.5 79.5 370 105 539 269 577.5 41.5 927 80 769 229 902 382 603 493 731 737M295-36L577.5 41.5M578 842L295 764M40-201L127 80M102 382L-261 269'/%3E%3C/g%3E%3Cg fill='%23505'%3E%3Ccircle cx='769' cy='229' r='5'/%3E%3Ccircle cx='539' cy='269' r='5'/%3E%3Ccircle cx='603' cy='493' r='5'/%3E%3Ccircle cx='731' cy='737' r='5'/%3E%3Ccircle cx='520' cy='660' r='5'/%3E%3Ccircle cx='309' cy='538' r='5'/%3E%3Ccircle cx='295' cy='764' r='5'/%3E%3Ccircle cx='40' cy='599' r='5'/%3E%3Ccircle cx='102' cy='382' r='5'/%3E%3Ccircle cx='127' cy='80' r='5'/%3E%3Ccircle cx='370' cy='105' r='5'/%3E%3Ccircle cx='578' cy='42' r='5'/%3E%3Ccircle cx='237' cy='261' r='5'/%3E%3Ccircle cx='390' cy='382' r='5'/%3E%3C/g%3E%3C/svg%3E");
  }
  .bg{
    background-color: #0e54eb;
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='232' height='232' viewBox='0 0 800 800'%3E%3Cg fill='none' stroke='%232986ff' stroke-width='1'%3E%3Cpath d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63'/%3E%3Cpath d='M-31 229L237 261 390 382 603 493 308.5 537.5 101.5 381.5M370 905L295 764'/%3E%3Cpath d='M520 660L578 842 731 737 840 599 603 493 520 660 295 764 309 538 390 382 539 269 769 229 577.5 41.5 370 105 295 -36 126.5 79.5 237 261 102 382 40 599 -69 737 127 880'/%3E%3Cpath d='M520-140L578.5 42.5 731-63M603 493L539 269 237 261 370 105M902 382L539 269M390 382L102 382'/%3E%3Cpath d='M-222 42L126.5 79.5 370 105 539 269 577.5 41.5 927 80 769 229 902 382 603 493 731 737M295-36L577.5 41.5M578 842L295 764M40-201L127 80M102 382L-261 269'/%3E%3C/g%3E%3Cg fill='%2348bbe8'%3E%3Ccircle cx='769' cy='229' r='5'/%3E%3Ccircle cx='539' cy='269' r='5'/%3E%3Ccircle cx='603' cy='493' r='5'/%3E%3Ccircle cx='731' cy='737' r='5'/%3E%3Ccircle cx='520' cy='660' r='5'/%3E%3Ccircle cx='309' cy='538' r='5'/%3E%3Ccircle cx='295' cy='764' r='5'/%3E%3Ccircle cx='40' cy='599' r='5'/%3E%3Ccircle cx='102' cy='382' r='5'/%3E%3Ccircle cx='127' cy='80' r='5'/%3E%3Ccircle cx='370' cy='105' r='5'/%3E%3Ccircle cx='578' cy='42' r='5'/%3E%3Ccircle cx='237' cy='261' r='5'/%3E%3Ccircle cx='390' cy='382' r='5'/%3E%3C/g%3E%3C/svg%3E");
  }
.right{
    text-decoration: underline;
    color: #cdcdcd!important;
}

.testimonial_subtitle{
    color: #0aaa7a;
    font-size: 12px;
}
.screen-pagination{
  text-align:center
}

.swiper-container {
   
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
.gtr{
    background-image:url('/images/datcover.png');
    background-size:contain
}
}
</style>
<body class="wirld">
<div class="container-fluid bg ">
<header class="container" style="padding-top: 20px; padding-bottom: 20px;">
        <div class="row">
        <div class="col-md-2" style="padding-top: 24px">
        <a href="http://digitaladmintrack.com/"><img style="width:120px" src="http://digitaladmintrack.com/images/logodat.png"></a>

        </div>
            <div class="col-md-10">
                <h1 class="title">
                Mejora tu logística monitoreando tus unidades en vivo las 24 horas
                </h1>
            </div>
        </div>
    </header>
  
   
    <div class="container d-none d-sm-block">
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
            <button class="btn btn-danger btn-lg button-g">Obtén tu prueba GRATUITA</button>
            </aside>

        </div>
    </div>
    <div class="d-block d-sm-none" style="padding-bottom:20px">
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
            <button class="btn btn-danger btn-lg button-sm">Obtén tu prueba GRATUITA</button>
            </aside>

        </div>
    </div>
    </div>
    <!--<svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#fff" fill-opacity="1" d="M0,192L48,170.7C96,149,192,107,288,90.7C384,75,480,85,576,122.7C672,160,768,224,864,224C960,224,1056,160,1152,165.3C1248,171,1344,245,1392,282.7L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
    -->



    
    <div class="container-fluid ">
   
    <div class="container  " style="padding-top:90px" data-aos="fade-right">


    <div class="swiper-container screen_carousel">
						<div class="swiper-wrapper" style="text-aling:center">
		
															<!--
								<div class="swiper-slide"><img src="https://www.kiperfy.com/new_landing/img/screenshots/screenshot-1.jpg" alt="App Screen"></div>
								-->
								<div class="swiper-slide"><img src="/images/slide1.png" alt="App Screen"></div>
								<div class="swiper-slide"><img src="/images/slide2.png" alt="App Screen"></div>
								<div class="swiper-slide"><img src="/images/slide3.png" alt="App Screen"></div>
							
						
						</div>
						<!-- pagination -->
						<div class="screen-pagination"></div>
					</div>


 
    </div>
    </div>





    <div class="container-fluid ">
    <div class="container  " data-aos="fade-right">
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
              <label for="exampleInputEmail1">Correo</label>
              <input
                type="email"
                class="was-validated form-control"
                id="correo"
                placeholder="Ingresa un nombre"
                required
              />
              <div id="correo-errors" class="invalid-feedback"></div>
            </div>


            <div class="form-group">
              <label for="exampleInputEmail1">Ciudad</label>
              <input
                type="text"
                class="form-control"
                id="ciudad"
                placeholder="Ingresa una ciudad"
                required
              />
              
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Empresa</label>
              <input
                type="text"
                class="was-validated form-control"
                 id="empresa"
                placeholder="Ingresa el nombre de tu empresa"
                required
              />
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Unidades</label>
              <input
                type="text"
                class="was-validated form-control"
                 
                id="unidades"
                onkeydown="javascript: return event.keyCode === 8 ||
                    event.keyCode === 46 ? true : !isNaN(Number(event.key))"
                placeholder="Ingresa la cantidad de unidades "
                required
              />
              <div id="unidades-errors" class="invalid-feedback"></div>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Comentarios</label>
              <textarea id="comentarios" class="form-control "></textarea>
            </div>

            <button type="submit" id="form" class="btn btn-primary is-valid" disabled>Enviar
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
        <div class="col-md-8 " style="padding-left: 50px;
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
                        <h4><strong>Karla González</strong></h4>
                        <p class="testimonial_subtitle"><span>Transportes Rodriguez</span><br>
                        <span>Transportista</span>
                        </p>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
       
               </div>


        </div>

        


    </div> </div> 
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
<script src="/js/validate.js"></script>
<script>
  AOS.init();
</script>
<script>


$('#form').click(function(){
                    console.log('click');
                    name = $('#name').val()
                    correo = $('#correo').val()
                    ciudad = $('#ciudad').val()
                    empresa = $('#empresa').val()
                    unidades = $('#unidades').val()
                    comentarios = $('#comentarios').val()
                    console.log(correo,comentarios)
                    $.ajax({
                            url:'/send/contact/landing',
                            type:'POST',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: { name: name, correo:correo, ciudad:ciudad, empresa:empresa,unidades:unidades,comentarios:comentarios },
                            success: function(response){
                              console.log(response)
                                if(response.send == null){
                                    $('#nombre').val('')
                                    $('#telefono').val('')
                                    $('#compania').val('')
                                    $('#comentarios').val('')
                                    $('.gracias').show()
                                    //alert('Gracias por ponerte en contacto, en breve nos comunicaremos contigo')
                                }
                            },
                            error: function(data){
                                var errors = data.responseJSON;
                                console.log(errors);
                            }
                        })
                    return false;
                })


                
$(".button-g").on('click', function(e) {

    $('html, body').animate({
       scrollTop:1000
     }, 700, function(){

  
       
     });

});

$(".button-sm").on('click', function(e) {

$('html, body').animate({
   scrollTop:1750
 }, 700, function(){


   
 });

});


    $('.client_select').change(function(){
        console.log('cambio')
    })

    function getSlide() {
        var wW = $(window).width();
        if (wW < 601) {
            return 1;
        }
        return 3;
    }
    
    var mySwiper = $('.screen_carousel').swiper({
        mode:'horizontal',
        loop: true,
        speed: 1000,
        autoplay: 1000,
        effect: 'coverflow',
        slidesPerView: getSlide(),
        grabCursor: true,
        pagination: '.screen-pagination',
        paginationClickable: true,
        nextButton: '.arrow-right',
        prevButton: '.arrow-left',
        keyboardControl: true,
        coverflow: {
            rotate: 0,
            stretch: 90,
            depth: 200,
            modifier: 1,
            slideShadows : true
        }
    });            
</script>

</body>
</html>
