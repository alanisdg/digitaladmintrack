@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
<h3>{{ $client->name }}:facturas</h3>
<ul class="nav nav-tabs" role="tablist">
<?php 
$step=1;
$year = '18';
foreach($invoices as $invoice){
    if($year != $invoice->year){
                $title = $invoice->year;
                ?>
            <li role="presentation"><a href="#year_{{$invoice->year }}" aria-controls="viaje" role="tab" data-toggle="tab"><?php echo '20'. $invoice->year ?></a></li>
                <?php
        }
        if($step == 1){
                ?>
                <li role="presentation" class="active"><a href="#year_{{$invoice->year }}" aria-controls="viaje" role="tab" data-toggle="tab"><?php echo '20'. $invoice->year ?></a></li>
                <?php
                $step++;
            }
            $year = $invoice->year;
            $title = $year;
}
$year = '';
?>
</ul>
<!-- Tab panes -->
<div class="tab-content">

    <?php
    $months = array(12,11,10,9,8,7,6,5,4,3,2,1);
    $start = 1;
    foreach ($invoices as $invoice) {
        if($start == 1){
            $start++;
            $year_name = $invoice->year;
            ?><div role="tabpanel" class="tab-pane active" id="year_<?php echo $invoice->year ?>"><?php

            foreach ($months as $m) {
                
                if($m <= date('m')){
                echo '<table class="table ">';
                if($m <= date('m')){
                   echo '- ' .$invoice->printMonth($m);  
                }
                echo '<tr><td>ID</td><td>Total</td><td></tr>';
                }
                    foreach($invoices as $invoice_){
                        echo '<tr>';
                        if($invoice_->year == $year_name){
                            echo $invoice_->month_by($m,$invoice_);
                        }
                        echo '</tr>';
                    }
                }
                echo '</table>';
        ?></div><?php
           
        }
        if($year_name != $invoice->year){
            $year_name = $invoice->year;
            ?><div role="tabpanel" class="tab-pane" id="year_<?php echo $invoice->year ?>"><?php
             foreach ($months as $m) {
                echo $invoice->printMonth($m); 
                    foreach($invoices as $invoice_){
                        if($invoice_->year == $year_name){
                            echo $invoice_->month_by($m,$invoice_);
                        }
                    }
                }
            ?></div><?php
            
        }
    }
    ?>
    
   
    </div>
   
</div>                   
                        
                        <?php 
$step=1;
$year = '18';
foreach($invoices as $invoice){
    if($year != $invoice->year){
                $title = $invoice->year;
                ?>
            
                </div>
                <?php
        }
        if($step == 1){
                ?>
                <div role="tabpanel" class="tab-pane active" id="reportes_">
                </div>
                <?php
                $step++;
            }
            $year = $invoice->year;
            $title = $year;
}
$year = '';
?>
</div>
                    </div>

</div>
@stop