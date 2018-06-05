@extends('admin.layouts.Dasboardlayout')
@section('content')
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/master.js"></script>
<div class="right_col" role="main">
  <span class="btn btn-danger" id="nodeTest">Revisando estado de NodeJS...</span>
  

    <ul>
      <li><h3>Si NodeJS no recibe paquetes se debe reiniciar NodeJs desde la consola</h3></li>
      <li>1) Conectarse por ssh ejecutando ssh alanisdg@45.55.37.222</li>
      <li>2) Ingresar el password</li>
      <li>3) Ejecutar: cd var/www/html/laravel/node</li>
      <li>4) Ejecutar: pm2 restart calamp</li>
    </ul>
  <br><br>
  <a href="/clean_cron" class="btn btn-danger">Limpiar base de datos en vivo</a>
  <a class="btn btn-danger">Limpiar base de datos permanente</a>
</div>
<script type="text/javascript">
  var socket = io(':3000');
  count = 0;
 socket.on("datatest", function(data){
            count = count + 1;          
                   console.log(data)
                   $('#nodeTest').removeClass('btn-danger')
                   $('#nodeTest').addClass('btn-primary')
                   $('#nodeTest').html('NodeJS Activo ✓ <span id="count"></span>')
                   $('#count').html(count)
                        })
</script>
@stop