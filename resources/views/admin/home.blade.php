@extends('admin.layouts.Dasboardlayout')
@section('content')
<!-- page content -->
<div class="right_col" role="main">
  <!-- top tiles -->
  <div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> USUARIOS</span>
      <div class="count">{{ $users }}</div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-clock-o"></i> Equipos</span>
      <div class="count">{{ $devices }}</div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Paquetes</span>
      <div class="count green">{{ $packets }}</div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Clientes</span>
      <div class="count">{{ $clients }}</div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Viajes en ruta</span>
      <div class="count">{{ $travelsOnRoad }}</div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Viajes totales</span>
      <div class="count">{{ $travels }}</div>
    </div>
  </div>
  <!-- /top tiles -->

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
              <h1>Administrador </h1>
                @if($relax ==0)
                <div class="alert alert-danger" role="alert">
                    <h3>PLATAFORMA RETRASADA</h3> Último reporte -> {{ $timeforhumans }}
                </div>
                @else
                <div class="alert alert-success" role="alert">
                    <h3>PLATAFORMA ESTABLE</h3> Último reporte -> {{ $timeforhumans }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

            </div>

          </div>
          <br />


        </div>
        <!-- /page content -->
@stop
