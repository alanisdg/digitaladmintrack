<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>DAT</title>
        <!-- Styles -->
        <link href="/css/white.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,900i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,700&display=swap" rel="stylesheet">

    </head>
    <style>
    .titletablepop{
            color: #8c8b8b;
    font-weight: bold;
    }
    .tablepop{
        width: 100%;
                            font-size: 12px ;
    color: #85a8ff;
                        }
    .comentpop{
        margin-top: 13px;
    background-color: #e8eeff;
    color: white;
    font-size: 9px;
    padding: 10px;
    border-radius: 4px;
    }
    .hrpop{
        margin-top: 3px;
        margin-bottom: 10px;
    }
    .titlepop{
        font-size: 16px;
        font-weight: bold;
        color:black;
    }
    .textpop{
        font-size: 12px;
        font-weight: lighter;
    }
    .pop{
            padding: 10px;
    width: 300px;  
    background-color: white; 
    border-radius: 5px;
    color: #847f7f;
    }
    .navbar-header {
    border-bottom: none;
}
</style>
    <body> 
        @foreach($jammer_devices as $jammer)
            
        <div   class="jammer">{{ $jammer->name }} ha detectado un intento de robo <button id="pause" class="btn btn-danger stopJammer" ide="{{ $jammer->id }}">Terminar Alerta</button></div>
        @endforeach
        <div style="display: none" class="jammer">EL EQUIPO </div>
       <!-- <div id="preloader">
  <div id="status">&nbsp;</div>
</div>-->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/home"><img width="120" src="{{$client_profile->logo}}"></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        @if(  Auth::user()->role_id ==1  OR Auth::user()->role_id ==6 OR Auth::user()->role_id ==4 OR Auth::user()->role_id ==3 )
                        <li><a href="/tools">Herramientas <span class="sr-only">(current)</span></a></li>
                        @endif
                        <li><a href="/reportes">Reportes <span class="sr-only">(current)</span></a></li>
                        
                        <li><a href="/trucks">Unidades</a></li>
                        @if($client_profile->box == 1)
                        <li><a href="/boxs">Cajas</a></li>
                        @endif
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/drivers">Choferes  <span class="sr-only">(current)</span></a></li>
                                <li><a href="/geofences">Geocercas  <span class="sr-only">(current)</span></a></li>
                                @if(  Auth::user()->role_id ==1  OR Auth::user()->role_id ==6  OR Auth::user()->role_id ==3 )
                                <li>
                                    <a href="/users">Usuarios</a>
                                </li>
                                @endif</li>
                                @if(  Auth::user()->role_id ==1  OR Auth::user()->role_id ==6 OR Auth::user()->role_id ==4 )
                                <li><a href="/clients">Clientes  <span class="sr-only">(current)</span></a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="dropdown nones dev_off" >
                            <a href="#" class="dropdown-toggle" style="padding: 10px 0;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="/images/off_truck.png"><span class="caret"></span></a>
                            <ul class="dropdown-menu off_devices">
                              
                             
                            </ul>
                        </li>
                        <li> <a href="home2">Version Anterior</a></li>
                        <li class="infoDevices">
              
                            
                        </li>
                       
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                        <a href="" class="jewelButton noti topicon"  ide ="{{ Auth::user()->id }}">
                                <span class="glyphicon comment-icon topicon glyphicon-comment @if(Auth::user()->read == 1) blue @endif" style="font-size:18px;"></span>
                                <span class="badge
                                @if(Auth::user()->read == 0 OR Auth::user()->new_notifications == 0)
                                none
                                @endif


                                badge-notify-p badge-notify-p-count ">{{ Auth::user()->new_notifications }}</span>



                            </a>
                            <div class="pyramid none">
                                <img src="/images/pyramid.png" alt="">
                            </div>
                            <div class="notifications none">
                                <div class="ntitle">
                                    <p>Notificaciones</p>
                                </div>
                                <span class="live"></span>  

                                 



                                @foreach($notifications as $notification)


                                <div class="notification not @if($notification->read==1 ) readed @endif notification{{ $notification->id }}">

                                    <span ide="{{ $notification->id }}" device_id="{{ $notification->device_id }}" nid="{{ $notification->id }}" user_id="{{ Auth::user()->id }}" class="nlink not"  >
                                    <div class="not" style="float:left">
                                        @if($notification->author->thumb_image != null)
                                        <img src="{{ $notification->author->thumb_image }}" alt="..." class="img-circle">
                                        @else
                                        <img src="/profile/user.png" alt="..." class="img-circle">
                                        @endif
                                    </div>
                                    <div class="not" style="float:left;     padding: 0px 5px; width: 240px;">
                                        <b> {{ $notification->author->name }}</b> 
                                        <span class="black"> {{ $notification->nde->description }} {{ $notification->device->name }} </span> 
                                        <br>
                                        <span class="grey">{{ $notification->timeago($notification->created_at) }}</span>
                                        </div>
                                    <div class="not" style="clear:both">

                                    </div>
    </span>
                                </div> 
                                @endforeach 
                                <div style="clear:both">

                                </div>
                            </div>
                        </li>
                        <li class="geo_show_button">
                            <span class="glyphicon glyphicon-warning-sign topicon" aria-hidden="true"></span>      <input type="checkbox" class="show_traffic" value="">
                        </li>
                        <li class="geo_show_button">
                            <span class="glyphicon glyphicon-adjust topicon" aria-hidden="true"></span>      <input type="checkbox" class="show_all_geofence" value="">
                        </li>
                        <!--<li class="geo_show_button">
                            <span class="glyphicon glyphicon-picture topicon" aria-hidden="true"></span>      <input type="checkbox" class="changecss" value="">
                        </li>-->

                        @if(  Auth::user()->role_id ==1  OR Auth::user()->role_id ==6 OR Auth::user()->role_id ==4 )
                        <li>
                          
                        </li>
                        @endif 


                        
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
    <style type="text/css">
        .nones{
            display: none !important
        }
    </style>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
    </html>