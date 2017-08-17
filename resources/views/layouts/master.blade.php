    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Digital Admin Tracking</title>
        <!-- Styles -->
        <link href="/css/usamex.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,900i" rel="stylesheet">

    </head>
    <body>
        <!--<div id="preloader">
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
                    <a class="navbar-brand" href="/home"><img width="120" src="{{$client->logo}}"></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        @if(  Auth::user()->role_id ==1  OR Auth::user()->role_id ==6 OR Auth::user()->role_id ==4 OR Auth::user()->role_id ==3 )
                        <li class="active"><a href="/tools">Herramientas <span class="sr-only">(current)</span></a></li>
                        @endif
                        <li><a href="/reportes">Reportes <span class="sr-only">(current)</span></a></li>
                        
                        <li><a href="/trucks">Unidades</a></li>
                        @if($client->box == 1)
                        <li><a href="/boxs">Cajas</a></li>
                        @endif
                        <li><a href="/travels">Viajes</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/drivers">Choferes  <span class="sr-only">(current)</span></a></li>
                                <li><a href="/geofences">Geocercas  <span class="sr-only">(current)</span></a></li>
                                @if(  Auth::user()->role_id ==1  )
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
              
                            <span class="glyphicon glyphicon-road grey" aria-hidden="true"></span>&nbsp; <span class="grey"> {{ $total_devices }}</span>&nbsp;&nbsp;
                            &nbsp;&nbsp;|&nbsp;&nbsp; 
                            <span class="glyphicon glyphicon-stop grey" aria-hidden="true"></span>&nbsp; <span class="grey">{{ $available_boxes }}</span>&nbsp;&nbsp;

                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="geo_show_button">
                            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>      <input type="checkbox" class="show_traffic" value="">
                        </li>
                        <li class="geo_show_button">
                            <span class="glyphicon glyphicon-adjust" aria-hidden="true"></span>      <input type="checkbox" class="show_all_geofence" value="">
                        </li>

                        @if(  Auth::user()->role_id ==1  OR Auth::user()->role_id ==6 OR Auth::user()->role_id ==4 )
                        <li>
                            <a href="/orders" class="noti">
                                <span class="glyphicon glyphicon-bookmark" style="font-size:18px;"></span>
                                <span class="badge badge-notify-p">{{ $pending_orders }}</span>
                            </a>
                        </li>
                        @endif 


                        
                        <li>
                            <a href="" class="jewelButton noti "  >
                                <span class="glyphicon comment-icon glyphicon-comment @if(Auth::user()->read == 1) blue @endif" style="font-size:18px;"></span>
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
                                @foreach($notifications as $notification)

                                <div class="notification not @if($notification->read==1 ) readed @endif ">
                                    <a ide="{{ $notification->id }}" class="nlink not" to="{{ $notification->link }}">
                                    <div class="not" style="float:left">
                                        @if($notification->author->thumb_image != null)
                                        <img src="{{ $notification->author->thumb_image }}" alt="..." class="img-circle">
                                        @else
                                        <img src="/profile/user.png" alt="..." class="img-circle">
                                        @endif
                                    </div>
                                    <div class="not" style="float:left;     padding: 0px 5px; width: 240px;">
                                        <b> {{ $notification->author->name }}</b> 
                                        <span class="black"> {{ $notification->nde->description }} {{ $notification->tcode->code }}</span> 
                                        <br>
                                        <span class="grey">{{ $notification->timeago($notification->created_at) }}</span>
                                        </div>
                                    <div class="not" style="clear:both">

                                    </div>
    </a>
                                </div>

                                @endforeach
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
