<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Digital Admin Track</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,900i" rel="stylesheet">
    <title>Gentelella Alela! | </title>
    <!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="/vendors/jquery-confirm.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/vendors/custom.min.css" rel="stylesheet">
    <script src="/js/charts.js"></script>
    <script src="/js/chart_utils.js"></script>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="/dashboard" class="site_title"><span><img src="/images/logodat.png" alt="logo"></span></a>
            </div>
            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_info">
                <span>Bienvenido,</span>

                <h2>{{ $user->name }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Administracion <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li {{{ (Request::is('dashboard/devices') ? 'class=current-page' : '') }}}  >
                            <a href="/dashboard/devices">Equipos</a>
                        </li>
                        <li {{{ (Request::is('dashboard/clients') ? 'class=current-page' : '') }}} >
                            <a href="/dashboard/clients">Clientes</a>
                        </li>
                        <li {{{ (Request::is('dashboard/users') ? 'class=current-page' : '') }}} >
                            <a href="/dashboard/users">Usuarios</a>
                        </li>
                       
                    </ul>
                  </li>
                </ul>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Finanzas<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                       
                        <li {{{ (Request::is('dashboard/balance') ? 'class=current-page' : '') }}} >
                            <a href="/dashboard/balance">Balance</a>
                        </li>
                        <li {{{ (Request::is('dashboard/gastos') ? 'class=current-page' : '') }}} >
                            <a href="/dashboard/gastos">Gastos</a>
                        </li>
                        <li {{{ (Request::is('dashboard/ingresos') ? 'class=current-page' : '') }}} >
                            <a href="/dashboard/ingresos">Ingresos</a>
                        </li>
                        <li {{{ (Request::is('dashboard/comisiones') ? 'class=current-page' : '') }}} >
                            <a href="/dashboard/comisiones">Comisiones</a>
                        </li>
                    </ul>
                  </li>
                </ul>

                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Programacion<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                       
                        <li {{{ (Request::is('dashboard/recuperacion') ? 'class=current-page' : '') }}} >
                            <a href="/dashboard/recuperacion">Recuperación</a>
                        </li>
                       
                    </ul>
                  </li>
                </ul>


              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
           
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

            </nav>
          </div>
        </div>
        <!-- /top navigation -->


                @yield('content')


      </div>
    </div>
    <style type="text/css">
        .left_col {
    background: #001e38;
}
.site_title {
     
    height: auto;
   
}

.nav_title {
   height: auto;
    background: #093e71;
    
}
body{
    background-image: url("https://www.toptal.com/designers/subtlepatterns/patterns/whirlpool.png");
}
body .container.body .right_col {
    background: none;
}
.nav.side-menu>li.active>a {
    text-shadow: rgba(0,0,0,.25) 0 -1px 0;
    background: linear-gradient(#0083ff,#043767),#b4d0ec;
    box-shadow: rgba(0,0,0,.25) 0 1px 0, inset rgba(255,255,255,.16) 0 1px 0;
}
    </style>
    <!-- jQuery -->
    <script src="/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="/vendors/Flot/jquery.flot.js"></script>
    <script src="/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="/vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="/vendors/moment/min/moment.min.js"></script>
    <script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="/vendors/custom.min.js"></script>

    

    <script src="/js/master_admin.js"></script> 
    
    @if (session()->has('flash_notification.message'))
    <script type="text/javascript">
        swal("{!! session('flash_notification.message') !!}", "", "success")
    </script>
    @endif
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
<script>
    $('.client_select').change(function(){
        console.log($('.client_select').val())
        $.ajax({ 
        url:'/dashboard/devices/devices_by_client',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: $('.client_select').val() },
        success: function(r){
            console.log(r)
            $('.devices_table').html('')
            $('.devices_table').html(r)
        }
    })
    })

</script>

  </body>
</html>
