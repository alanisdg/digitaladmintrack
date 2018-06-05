<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Geofences;
use App\Travels;
use App\Drivers;
use App\Notifications;
use App\Devices;
use App\Gastos;
use App\Locations;
use App\Toclients;
use App\Moneys;
use App\Routes;
use App\Clients;
use App\Comments;
use App\Tcodes;
use App\Comissions;
use App\Subclients;
use App\Packets;
use App\User;
use App\Signes;
use App\Ingresos;
use Auth;
use DB;
use Session;
use Redirect;
use Carbon\Carbon;

class AdminController extends Controller
{
    use DevicesTraits;
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    public function index(){
    	$user = User::find(Auth::user()->id);
        $gastos = Gastos::where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        return view('admin.gastos.index', compact('gastos','user')); 
    }

        public function getNextMonth($m){
        if($m == 12){
            return 1;
        }

        $m = $m + 1;
        
        return $m;
    }

    public function pasMonth($m){
        if($m == 1){
            return 12;
        }else{
            $mon = $m -1;
            return $mon;
        }
        
    }

    public function thisYear($m,$y){
        if($m == 1){
            return $y - 1;
        }else{
            return $y;
        }
    }



    public function generateInvoice($id){
        $devices = array();
        $client = Clients::find($id);
        $charge_day = $client->charge_at;
        //dd($charge_day);
        //dd(date('m')); 01
        //dd(date('y')); 18
        $nextMonth = $this->getNextMonth(date('m'));
        //dd($nextMonth); 2
        $elmon = $this->pasMonth(date('m'));
        //dd($elmon);
        $leyear = $this->thisYear(date('m'),date('y'));
        //dd($leyear);
        $from_ = $charge_day .'-'.$elmon.'-'.'20'.$leyear;
        $to_ = $charge_day .'-'.date('m').'-'.'20'.date('y');
        $from_date = new Carbon($from_);
        $to_date = new Carbon($to_);  
        /*dd($from_date);
        $from_date = new Carbon('first day of this month');
        dd($from_date);
        $to_date = new Carbon('last day of this month');*/

        $total_devices = Devices::where('client_id',$client->id)->get();
        $total_count = 0;
        //dd($total_devices);
        foreach ($total_devices as $device) {
            
                $charge_from = new Carbon($device->charge_from);

                $stop_from = new Carbon($device->stop_from);

                if($device->charge_from == ''){
                    $device->month_charge = 'sin fecha para cobrar';
                    $device->charge_from_date = ' - '; 
                    $device->stop_from_date = ' - ';
                    $device->total = ' - ';
                }
                if($device->charge_from != ''){

                    if($charge_from->lt($to_date) AND $from_date->lt($charge_from)  ){
                       
                        $device->month_charge = 'nueva cobranza';
                        $charge_from_ = new Carbon($device->charge_from);
                        $device->charge_from_date = $charge_from_; 
                        if($device->stop_from != ''){
                            $stop_from_ = new Carbon($device->stop_from);
                            $device->stop_from_date = $stop_from_;
                            $de = new Carbon($device->charge_from);
                            $a = new Carbon($device->stop_from);
                            $device->days = $days = $de->diffInDays($a);

                            if($to_date->lt($stop_from)){
                                $device->days = 'completo';
                                $device->total = $client->device_price($device,$client->device_price);
                                continue;
                            }
                            $price_by_day = $client->device_price($device,$client->device_price) / 30;
                            $total = $device->days * $price_by_day;

                            $device->total = round($total);
                            $total_count = $total_count + $device->total;
                        }else{
                            $de = new Carbon($device->charge_from);
                       
                             
                                $device->days = $days = $de->diffInDays($to_date);
                                $device->stop_from_date = $to_date;
                                $price_by_day = $client->device_price($device,$client->device_price) / 30;
                                $total = $device->days * $price_by_day;
                                $device->total = round($total);
                                $total_count = $total_count + $device->total;
                            
                            
                        }
                        if($device->stop_charge != 1){
                            array_push($devices, $device);
                        }
                    }else{
                        //if($device->name == 'ford'){ dd('f'); }
                        if($device->stop_from == ''){
                            if($to_date->lt($charge_from)){
                                $device->month_charge = 'empieza a cobrar: ' . $charge_from;
                                $device->charge_from_date = ' - '; 
                                $device->stop_from_date = ' - ';
                                $device->total = ' - ';
                                $device->days = ' - ';
                                continue;
                            }
                            $device->month_charge = 'si';
                            
                            $device->charge_from_date = $from_date; 
                            $device->stop_from_date = $to_date;
                            $device->days = 'completo';
                            $device->total = $client->device_price($device,$client->device_price);
                            if($device->stop_charge != 1){
                                array_push($devices, $device);
                            }
                            // dd($device);
                        $date1 = new Carbon($device->charge_from);
                        // $device->month_charge = ' sin cobro ';
                        if($date1 == $device->stop_from_date){
                            $device->month_charge = ' 0 dias';
                            $device->days = '0';
                            $device->total = 0;
                        }else{
                            $total_count = $total_count + $client->device_price($device,$client->device_price);
                        }

                        }

                    }
            }
            //dd($device);
        }
        //'client','from_date','to_date','total_devices','total_count','to_'
        $iva = $total_count * .16;
        $total = $total_count * 1.16;
        $array = array(
            'total_count'=>$total_count,
            'client'=>$client,
            'from_date' =>$from_date,
            'to_date' =>$to_date,
            'total_devices' => $total_devices,
            'total_count' => $total_count,
            'devices' => $devices,
            'iva' => $iva,
            'total' => $total,
            'month'=> date('m'),
            'year' => date('y')
            );
        return($array);
    }

    public function balance_detail(){
        $user = User::find(Auth::user()->id);
        $ingresos = Ingresos::where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        $clients = Clients::all();



        $ing = Ingresos::all();
        $gast = Gastos::all();
        $currentYear = date('y');
        
        $ingresos_totales = '';
        $gastos_totales = '';

        $Currentmonths= array('01','02','03','04','05','06','07','08','09','10','11','12');
        $Pasmonths= array('01','02','03','04','05','06','07','08','09','10','11','12');
        foreach($ing as $ingr){
            $ingresos_totales = $ingresos_totales + $ingr->subtotal;
            $date = new Carbon ($ingr->date);
        } 
        $deuda_total = '';
        foreach($gast as $gasto){
            if($gasto->user_id_p != 44){
                $deuda_total = $deuda_total + $gasto->subtotal;
            }
            
        }
         $deuda_total = '';
        $contributors = User::all(); 
        $comisiones_totales = '';
        foreach ($contributors as $key => $user_) { 
            if($user_->role_id != 1){ 
                
                $contributors->forget($key); 
            }else{
                $comisiones_totales = $comisiones_totales + $user_->total_comission($user_->id);
                $deuda_total = $deuda_total + $user_->deuda_total($user_->id);
            }
        } 
       
        $balance = $ingresos_totales - $gastos_totales;
        $total_comisiones = Comissions::all();
        $total_com = '';
        foreach ($total_comisiones as $comision){
            $total_com = $total_com + $comision->subtotal;
        }
        $balance = $balance - $total_com;
        if($balance < 0){
            $class="bad";
        }else{
            $class="good";
        }
        $dat = User::find(44);
        $dat_gastos = $dat->total_inversion($dat->id);
        //dd($dat_gastos);
        $balance_general = $ingresos_totales - $comisiones_totales - $dat_gastos; 
        return view('admin.balance_detail', compact('balance_general','user','ingresos_totales','comisiones_totales','dat_gastos')); 
    }
    public function balance(){
        $user = User::find(Auth::user()->id);
        $ingresos = Ingresos::where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        $clients = Clients::all();
        $cobranza  = array();
        foreach ($clients as $client) {
            $inv = $this->generateInvoice($client->id);
            $client->invoice = $inv;

            array_push($cobranza, $client);
        }

      
        $ing = Ingresos::all();
        $gast = Gastos::all();
        $currentYear = date('y');
        
        $ingresos_totales = '';
        $gastos_totales = '';

        $Currentmonths= array('01','02','03','04','05','06','07','08','09','10','11','12');
        $Pasmonths= array('01','02','03','04','05','06','07','08','09','10','11','12');
        foreach($ing as $ingr){
            $ingresos_totales = $ingresos_totales + $ingr->subtotal;
            $date = new Carbon ($ingr->date);
        } 
        $deuda_total = '';
        foreach($gast as $gasto){
            if($gasto->user_id_p != 44){
                $deuda_total = $deuda_total + $gasto->subtotal;
            }
            
        }
         $deuda_total = '';
        $contributors = User::all(); 
        $comisiones_totales = '';
        foreach ($contributors as $key => $user_) { 
            if($user_->role_id != 1){ 
                
                $contributors->forget($key); 
            }else{
                $comisiones_totales = $comisiones_totales + $user_->total_comission($user_->id);
                $deuda_total = $deuda_total + $user_->deuda_total($user_->id);
            }
        } 
       
        $balance = $ingresos_totales - $gastos_totales;
        $total_comisiones = Comissions::all();
        $total_com = '';
        foreach ($total_comisiones as $comision){
            $total_com = $total_com + $comision->subtotal;
        }
        $balance = $balance - $total_com;
        if($balance < 0){
            $class="bad";
        }else{
            $class="good";
        }
        $dat = User::find(44);
        $dat_gastos = $dat->total_inversion($dat->id);
        //dd($dat_gastos);
        $balance_general = $ingresos_totales - $comisiones_totales - $dat_gastos;
        return view('admin.balance', compact('balance','balance_general','class','cobranza','ingresos','ingresos_totales','gastos_totales','user','Currentmonths','Pasmonths','contributors','clients','deuda_total')); 
    }
    public function ingresos(){
    	$user = User::find(Auth::user()->id);
        $ingresos = Ingresos::where( DB::raw('MONTH(date)'), '=', date('n') )->get();

      
      


        return view('admin.ingresos.index', compact('ingresos','user')); 
    }

    public function detailclient($id){
         
        $user = User::find(Auth::user()->id);
        $ingresos = Ingresos::where('client_id', $id )->get();
        $client = Clients::find($id);
        return view('admin.clientdetail', compact('user','ingresos','client')); 
    }
    public function detail($m,$y){

        $user = User::find(Auth::user()->id);
        $gastos = Gastos::where( DB::raw('MONTH(date)'), '=', $m )->where( DB::raw('YEAR(date)'), '=', $y )->get();
        $ingresos = Ingresos::where( DB::raw('MONTH(date)'), '=', $m )->where( DB::raw('YEAR(date)'), '=', $y )->get();
        $contributors = User::all();
        //dd($users); 
        foreach ($contributors as $key => $user) {
            //dd($user);
            if($user->role_id != 1){
                //dd($key);
                $contributors->forget($key);
                //array_push($contributors, $user);
            }
            
            //$user->comissions = $user->commisions_by_month($m,$y,$user->id);

        } 
        //dd($contributors);
        foreach ($contributors as $contributor) {
           
            $contributor->comissions = $contributor->commisions_by_month($m,$y,$contributor->id);
            
        }  
        $monthNum  = $m;
$monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
 
        return view('admin.detail', compact('user','gastos','ingresos','contributors','monthName')); 
    }

    public function comisiones(){
        $user = User::find(Auth::user()->id);
        $comisiones = Comissions::where( DB::raw('MONTH(date)'), '=', date('n') )->get();
         return view('admin.comisiones.index', compact('comisiones','user')); 
    }

    public function recuperacion(){
          $user = User::find(Auth::user()->id);
         return view('admin.programacion.recuperacion', compact('user')); 
    }


    public function add(){
    	$user = User::find(Auth::user()->id);
        
         $contributors = User::all();
        //dd($users); 
        foreach ($contributors as $key => $user_) {
            //dd($user);
            if($user_->role_id != 1){
                //dd($key);
                $contributors->forget($key);
                //array_push($contributors, $user);
            }
        } 
        return view('admin.gastos.add', compact('user','contributors')); 
    }

    public function addingreso(){
    	$user = User::find(Auth::user()->id);
        $clients = Clients::all();
        

        return view('admin.ingresos.add', compact('user','clients')); 
    }

  

        public function addcomision(){
        $user = User::find(Auth::user()->id);
        $contributors = User::all();
        //dd($users); 
        foreach ($contributors as $key => $user) {
            //dd($user);
            if($user->role_id != 1){
                //dd($key);
                $contributors->forget($key);
                //array_push($contributors, $user);
            }
        }  
        return view('admin.comisiones.add', compact('user','contributors')); 
    }
    public function store(){
    	// dd(request()->all()); 
    	$gasto = Gastos::create([
            'subtotal' => request()->get('subtotal'),
            'concepto' => request()->get('concepto'),
            'date' => request()->get('date'),
            'user_id' => request()->get('user_id'),
            'user_id_p' => request()->get('user_id_p')
        ]); 
        $user = User::find(Auth::user()->id);
        $gastos = Gastos::where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        return view('admin.gastos.index', compact('user','gastos')); 
    }

    public function storeingreso(){
    	// dd(request()->all()); 
    	$ingresos = Ingresos::create([
            'subtotal' => request()->get('subtotal'),
            'concepto' => request()->get('concepto'),
            'date' => request()->get('date'),
            'user_id' => request()->get('user_id'),
            'client_id' => request()->get('client_id')
        ]);
        $user = User::find(Auth::user()->id);
        $ingresos = Ingresos::where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        return redirect()->to('/dashboard/ingresos');
         
    }

    public function storecomision(){
         //dd(request()->all()); 
        $ingresos = Comissions::create([
            'subtotal' => request()->get('subtotal'),
            'motivo' => request()->get('concepto'),
            'date' => request()->get('date'),
            'user_id' => request()->get('user_id')
        ]);
        $user = User::find(Auth::user()->id);
        $comisiones = Comissions::where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        return view('admin.comisiones.index', compact('user','comisiones')); 
    }



}
