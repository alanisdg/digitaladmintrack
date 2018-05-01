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

    public function balance(){
        $user = User::find(Auth::user()->id);
        $ingresos = Ingresos::where( DB::raw('MONTH(date)'), '=', date('n') )->get();
        $clients = Clients::all();

        $ing = Ingresos::all();
        $gast = Gastos::all();
        $currentYear = date('y');
        
        $ingresos_totales = '';
        $gastos_totales = '';

        $Currentmonths= array('01','02','03','04','05','06','07','08','09','10','11','12');
        $Pasmonths= array('08','09','10','11','12');
        foreach($ing as $ingr){
            $ingresos_totales = $ingresos_totales + $ingr->subtotal;
            $date = new Carbon ($ingr->date);
        } 

        foreach($gast as $gasto){
            $gastos_totales = $gastos_totales + $gasto->subtotal;
        }

        $contributors = User::all(); 
        foreach ($contributors as $key => $user_) { 
            if($user_->role_id != 1){ 
                $contributors->forget($key); 
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
        return view('admin.balance', compact('balance','class','ingresos','ingresos_totales','gastos_totales','user','Currentmonths','Pasmonths','contributors','clients')); 
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
