<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use DateTime;

class Invoices extends Model
{
    protected $fillable = ['client_id','devices','month','year','subtotal','iva','total'];

    public function client(){
        return $this->belongsTo(Clients::class);
    }

    public function month_by($month,$invoice){
    	
    	if($invoice->month == $month){

    		echo '<td>'. $invoice->id . '</td>';
    		echo '<td>'. $invoice->total . '</td>';
    		echo '<td><a class="btn btn-xs  btn-primary" href="/dashboard/invoice_read/'.$invoice->id.'">Ver</a></td>';
    	}
    }

    public function printMonth($m){
    	echo '<tr colspan="2" ><td>';
    	if($m ==1){
    		echo " ENERO ";
    	}
    	if($m ==2){
    		echo "FEBRERO";
    	}
    	if($m ==3){
    		echo "MARZO";
    	}
    	if($m ==4){
    		echo "ABRIL";
    	}
    	if($m ==5){
    		echo "MAYO";
    	}
    	if($m ==6){
    		echo "JUNIO";
    	}
    	if($m ==7){
    		echo "JULIO";
    	}
    	if($m ==8){
    		echo "AGOSTO";
    	}
    	if($m ==9){
    		echo "SEPTIEMBRE";
    	}
    	if($m ==10){
    		echo "OCTUBRE";
    	}
    	if($m ==11){
    		echo "NOVIEMBRE";
    	}
    	if($m ==12){
    		echo "DICIEMBRE";
    	}
    	echo "</td><tr>";
    }
}