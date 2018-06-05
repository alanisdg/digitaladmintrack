@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
    <div style="width: 100%">
      <div class="panel panel-default col-md-3" style="padding:0;margin-left:20px">
  <div class="panel-heading ">Ingresos Totales</div>
  <div class="panel-body">
    $ {{ $ingresos_totales }}
  </div>
</div>

<div class="panel panel-default col-md-3" style="padding:0;margin-left:20px">
  <div class="panel-heading">Deuda Total</div>
  <div class="panel-body">
    $ {{ $deuda_total }}
  </div>
</div>

<div class="panel panel-default col-md-3" style="padding:0;margin-left:20px">
  <div class="panel-heading">Balance</div>
  <div class="panel-body">
    <span class="price {{ $class }}"><span class="price  "><a href="/dashboard/detail/balance" class="btn btn-primary">$ {{ $balance_general }}</a></span>
  </div>
</div>

<div class="panel panel-default col-md-3" style="padding:0;margin-left:20px">
  <div class="panel-heading">Inversion por usuario</div>
  <div class="panel-body">
    <?php foreach ($contributors as $contributor) {
           ?> <p ><span class="lename"> <?php echo $contributor->name . '</span>: Inversion <span class="price2">$ ' . $contributor->total_inversion($contributor->id) ?></span> - Deuda <span class="price2"><?php echo $contributor->deuda_total($contributor->id) ?></span></p> <?php } ?>
  </div>
</div>

<div class="panel panel-default col-md-3" style="padding:0;margin-left:20px">
  <div class="panel-heading">Comisiones totales por usuario</div>
  <div class="panel-body">
    <?php foreach ($contributors as $contributor) {
           ?> <p  ><span class="lename"> <?php echo $contributor->name . '</span>: Comision <span class="price2">$ ' . $contributor->total_comission($contributor->id) ?></span> - Real <span class="price2"><?php echo $contributor->real_commission($contributor->id,$contributor) ?></span></p> <?php } ?>
  </div>
</div>

<div class="panel panel-default col-md-3" style="padding:0;margin-left:20px">
  <div class="panel-heading">Ingresos por cliente</div>
  <div class="panel-body">
    <?php foreach ($clients as $client) {
           ?> <p  > <a href="/dashboard/detail/client/{{ $client->id }}" class="btn btn-primary btn-xs"><?php echo $client->name . '</a>: <span class="price2">$ ' . $client->total_balance($client->id) ?></span></p> <?php } ?>
  </div>
</div>

<div class="panel panel-default col-md-3" style="padding:0;margin-left:20px">
  <div class="panel-heading">Ingresos mensuales por cliente</div>
  <div class="panel-body">
    <?php 
    $total_mensualidad = '';
    foreach ($cobranza as $client_) { 
      $total_mensualidad = $total_mensualidad + $client_->invoice['total']
 ?> <p  > <a href="/dashboard/invoice/{{ $client_->id }}" class="btn btn-primary btn-xs"><?php echo $client_->name . '</a>: <span class="price2"> ' ?>

            <?php echo $client_->invoice['total'] / 1.16 ?></span></p> <?php } ?>
              <p>Total: <?php echo $total_mensualidad / 1.16 ?></p>
  </div>
</div>

      <div style="width:75%;">

      	<canvas id="myChart" width="400" height="150"></canvas>
      	<?php $totals = '' ?>
      	@foreach($Currentmonths as $month)
 <?php 
 $son = $contributor->ingreso_by_month($month,'2018');
 if($son == ''){
 	$son = 0;
 }
 $totals .= $son . ',' ?>
        
@endforeach 

<?php 
$totals = rtrim($totals,",");
?>

<?php $totals_2017 = '' ?>
      	@foreach($Pasmonths as $month)
 <?php 
 $son = $contributor->ingreso_by_month($month,'2017');
 if($son == ''){
 	$son = 0;
 }
 $totals_2017 .= $son . ',' ?>
        
@endforeach 

<?php 
$totals_2017 = rtrim($totals_2017,",");
?>
<script>

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        datasets: [{
            label: '2018',
            data: [{{ $totals }}],
            backgroundColor: [
                '#29c9f93d'
            ],
            borderColor: [
                'rgb(54, 162, 235)'
            ],
            borderWidth: 1
        },{
        	label: '2017',
            data: [{{ $totals_2017 }}],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }
        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>


		

@foreach($Pasmonths as $month)
<div class="lemont">
    <h4><a class="btn btn-success btn-xs" href="/dashboard/detail/{{ $month }}/2017"><?php echo $monthName = date('F', mktime(0, 0, 0, $month, 10)); ?> 2017</a></h4>
    <table class="table table-striped">
      <tr>
        <td>
          <p>Ingreso: <span class="price3">$ {{ $contributor->ingreso_by_month($month,'2017') }}</span></p>
          <p>Gasto: <span class="price3">$ {{ $contributor->gasto_by_month($month,'2017') }} </span></p>
        </td>
        <td>
          <?php foreach ($contributors as $contributor) {
           ?> <p> <?php echo $contributor->name . ':<span class="price3"> ' . $contributor->comission($month,'2017',$contributor->id) ?></span></p> <?php } ?>
        </td>
      </tr>
    </table> 
    
</div>
@endforeach 

@foreach($Currentmonths as $month)
<div class="lemont">
    <h4><a class="btn btn-success btn-xs" href="/dashboard/detail/{{ $month }}/2018"><?php echo $monthName = date('F', mktime(0, 0, 0, $month, 10)); ?> 2018</a></h4>
    <table class="table table-striped">
      <tr>
        <td>
          <p>Ingreso: <span class="price3">$ {{ $contributor->ingreso_by_month($month,'2018') }}</span></p>
          <p>Gasto: <span class="price3">$ {{ $contributor->gasto_by_month($month,'2018') }} </span></p>
        </td>
        <td>
          <?php foreach ($contributors as $contributor) {
           ?> <p> <?php echo $contributor->name . ': <span class="price3">' . $contributor->comission($month,'2018',$contributor->id) ?></span></p> <?php } ?>
        </td>
      </tr>
    </table> 
    
</div>
@endforeach 
 
 


 
 
 
    <div style="clear:both"></div>
</div>
    
        </div>
<style type="text/css">
    .lemont{
      width: 20%;
           box-shadow: 1px 3px 4px #cccccc;
    background: white;
    border: 1px solid #adadad;
    margin: 20px;
    padding: 10px;
    float: left;
    border-radius: 4px;
    }
    .god{

    }
    .bad{
      color:red !important;
    }
    .price{
      font-weight: bold;
    color: #3379b7;
    font-size: 26px;
    }
    .price2{
          font-weight: bold;
    color: #656565;
    font-size: 14px;
    }
    .lename{
      font-weight: bold;
    }
    .letitle{
          font-size: 18px;
    font-weight: bold;
    color: #353535;
    }
    .price3{
      font-weight: bold;
    color: #3379b7;
    font-size: 12px;
    }
</style>
@stop