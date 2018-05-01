<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Clients;
use App\Devices;
use App\Configs;
use App\user;
use Auth;
use Carbon\Carbon;
use Redirect;
use App\Invoices;
use DB;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }
    public function index(){
        $user = User::find(Auth::user()->id);
        $clients = Clients::all();
        return view('admin.clients.index', compact('clients','user'));
    }



    public function add(){
        $user = User::find(Auth::user()->id);
        return view('admin.clients.add',compact('user') );
    }

    public function store(){ 
        $user = request()->all();
        $client = Clients::create($user);
 
        DB::table('configs')->insert([
    ['rssi_alarm' => request()->get('rssi_alarm'), 'battery_alarm' => request()->get('rssi_alarm'),'client_id' => $client->id , 'supply_alarm' => 0.00]
]);
        return redirect()->to('dashboard/clients');
    }


    public function update(){
        $file = array('logo' => Input::file('logo'));
         $id = request()->get('client_id');
        $client = Clients::find($id);
        $client->name=request()->get('name');
        $client->device_price=request()->get('device_price');
        $client->charge_at=request()->get('charge_at');
        if($file['logo'] != null){
            $file = Input::file('logo');
                $path = public_path().'/client_profile/';
                $image = \Image::make(Input::file('logo'));

                $extension = Input::file('logo')->getClientOriginalExtension(); // getting image extension
                $fileName = $id.'_'.rand(11111,99999).'.'.$extension; // renameing image

                 
                $image->save($path.$fileName);
                 
                

                $client->logo = '/client_profile/'.$fileName;


        }

       

        if(request()->get('boxs')==null){
            $client->boxs = 0;
            }else{
            $client->boxs = 1;
            }
        $client->save();
        return redirect()->to('dashboard/client/'.$id); 
    }



    public function read($id){
         $user = User::find(Auth::user()->id);
        $client = Clients::find($id);
       
        return view('admin.clients.read',compact('client','user') );
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
    
    public function invoice($id){    
        $user = User::find(Auth::user()->id);
            $invoice = $this->generateInvoice($id);
            
            $client = $invoice['client'];
            $from_date = $invoice['from_date'];
            $to_date = $invoice['to_date'];
            $total_devices = $invoice['total_devices'];
            $total_count = $invoice['total_count'];
            $iva = $invoice['iva'];
            $total = $invoice['total']; 

            return view('admin.clients.invoice', compact('client','from_date','to_date','total_devices','total_count','iva','total','user'));
    }

    public function publicInvoice($id){    
    
            $invoice = $this->generateInvoice($id);
             
            $devices = $invoice['devices'];
            $client = $invoice['client'];
            
            $from_date = $invoice['from_date'];
            $to_date = $invoice['to_date'];
            $total_devices = $invoice['total_devices'];
            $total_count = $invoice['total_count'];
            
            $inv['client_id']=$client->id;
            $inv['devices']=json_encode($invoice['devices']);
            $inv['subtotal']=$invoice['total_count'];
            $inv['iva']=$invoice['iva'];
            $inv['total']=$invoice['total'];
            $inv['month']=$invoice['month'];
            $inv['year']=$invoice['year'];
            
            $in = Invoices::create($inv);
            
            return redirect()->to('/dashboard/invoices/'.$client->id);
            //return view('admin.clients.index');
    }

}
