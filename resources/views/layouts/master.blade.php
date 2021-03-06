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
        <link href="/css/usamex.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,900i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i" rel="stylesheet">

    </head>
    <body>
        @foreach($jammer_devices as $jammer)
            
        <div   class="jammer">El equipo de la unidad {{ $jammer->name }} ha detectado un intento de robo <button id="pause" class="btn btn-danger stopJammer" ide="{{ $jammer->id }}">Terminar Alerta</button></div>
        @endforeach
        <div style="display: none" class="jammer">EL EQUIPO </div>
       <div id="preloader">
  <div id="status">&nbsp;</div>
</div> 
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/home"><img style="height: inherit;" src="{{$client_profile->logo}}"></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        @if(  Auth::user()->role_id ==1  OR Auth::user()->role_id ==6 OR Auth::user()->role_id ==4 OR Auth::user()->role_id ==3 )
                        <li class="active"><a href="/tools">Herramientas <span class="sr-only">(current)</span></a></li>
                        @endif

                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/reportes">Trayectoria  <span class="sr-only">(current)</span></a></li>
                                <li><a href="/reportesgeocercas">Geocercas  <span class="sr-only">(current)</span></a></li>
                                
                            </ul>
                        </li>


                         
                        
                        <li><a href="/trucks">Unidades</a></li>
                        @if($client_profile->box == 1)
                        <li><a href="/boxs">Cajas</a></li>
                        @endif
                        <li><a href="/travels">Viajes</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/drivers">Choferes  <span class="sr-only">(current)</span></a></li>
                                <li><a href="/geofences">Geocercas  <span class="sr-only">(current)</span></a></li>
                                @if(  Auth::user()->role_id ==1  OR Auth::user()->role_id ==6 )
                                <li>
                                    <a href="/users">Usuarios</a>
                                </li>
                                @endif</li>
                                @if(  Auth::user()->role_id ==1  OR Auth::user()->role_id ==6 OR Auth::user()->role_id ==4 )
                                <li><a href="/clients">Clientes  <span class="sr-only">(current)</span></a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="infoDevices">
              
                            <img src="/images/trucks_.png">&nbsp; <span class="grey"> {{ $total_devices }}</span>&nbsp;&nbsp;
                            &nbsp;&nbsp;|&nbsp;&nbsp; 
                            <img src="/images/boxes_.png">&nbsp; <span class="grey">{{ $available_boxes }}</span>&nbsp;&nbsp;

                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="geo_show_button">
                        <img src="/images/1_.png">
                            <input type="checkbox" class="show_traffic lebox" value="">
                        </li>
                        <li class="geo_show_button">
                            <img src="/images/2_.png">     <input type="checkbox" class="lebox show_all_geofence" value="">
                        </li>

                        @if(  Auth::user()->role_id ==1  OR Auth::user()->role_id ==6 OR Auth::user()->role_id ==4 )
                        <li>
                            <a href="/orders" class="noti">
                                <img src="/images/tasks_.png">
                                <span class="badge badge-notify-p">{{ $pending_orders }}</span>
                            </a>
                        </li>
                        @endif 


                        
                        <li>
                            <a href="" class="jewelButton noti topicon"  >
                            <img src="/images/bell_.png" class="@if(Auth::user()->read == 1) blue @endif ">
                                
                                <span class="badge
                                @if(Auth::user()->read != 0)
                                @if(Auth::user()->new_notifications > 0)
                                    shows
                                @endif
                                @endif

                                badge-notify-p badge-notify-p-count none">{{ Auth::user()->new_notifications }}</span>



                            </a>
                            <div class="pyramid none">
                                <img src="/images/pyramid.png" alt="">
                            </div>
                            <div class="notifications none">
                                <div class="ntitle">
                                    <p>Notificaciones</p>
                                </div>
                                <span class="live"></span>
                                
                                <div style="clear:both">

                                </div>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" style="padding: 4px 4px;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                @if(Auth::user()->thumb_image != null)
                                <img src="{{ Auth::user()->thumb_image }}" alt="..." class="img-circle"> {{ Auth::user()->name }}<span class="caret"></span>
                                @else
                                <img src="/profile/user.png" alt="..." class="img-circle"> {{ Auth::user()->name }}<span class="caret"></span>
                                @endif
                            </a>
                            <ul class="dropdown-menu">
                            <li><a href="/profile/{{ Auth::user()->id }}">Mi perfil</a></li>
                                
                                @if(  Auth::user()->role_id ==1  )
                                <li class="">
                                    <a href="/dashboard">Administrador</a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    Desconectarse <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    @yield('content')
    @section('script')
    @show
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
    </html>